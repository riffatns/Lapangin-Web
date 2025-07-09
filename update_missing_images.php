<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;

echo "=== Updating Venues with Missing Images ===\n\n";

// Define external image URLs by sport type
$imagesBySport = [
    'Badminton' => [
        'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1534158914592-062992fbe900?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop'
    ],
    'Futsal' => [
        'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1560272564-c83b66b1ad12?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop'
    ],
    'Tennis' => [
        'https://images.unsplash.com/photo-1622547748225-3fc4abd2cca0?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1526045478516-99145907023c?w=800&h=600&fit=crop'
    ],
    'Basketball' => [
        'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1577223625816-7546f13df25d?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=800&h=600&fit=crop'
    ],
    'Volleyball' => [
        'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1594736797933-d0c3668a9c78?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1571038803263-2deceaae4855?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1593766827228-8737b4534aa6?w=800&h=600&fit=crop'
    ],
    'Mini Soccer' => [
        'https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1560272564-c83b66b1ad12?w=800&h=600&fit=crop'
    ],
    'Table Tennis' => [
        'https://images.unsplash.com/photo-1534158914592-062992fbe900?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop'
    ],
    'Swimming' => [
        'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1526045478516-99145907023c?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=800&h=600&fit=crop'
    ]
];

$venues = Venue::all();
$venuesPath = public_path('img/venues/');
$updatedCount = 0;

foreach ($venues as $venue) {
    // Check if venue has a local main_image that doesn't exist
    if (!empty($venue->main_image) && !str_starts_with($venue->main_image, 'http')) {
        $imagePath = $venuesPath . $venue->main_image;
        if (!file_exists($imagePath)) {
            $sportName = $venue->sport->name;
            $sportImages = $imagesBySport[$sportName] ?? $imagesBySport['Badminton'];
            
            // Use modulo to cycle through available images for each sport
            $imageIndex = $venue->id % count($sportImages);
            $newImageUrl = $sportImages[$imageIndex];
            
            $venue->update(['main_image' => $newImageUrl]);
            
            echo "✅ Updated {$venue->name} ({$sportName})\n";
            echo "   New image: $newImageUrl\n\n";
            $updatedCount++;
        }
    }
}

echo "=== Summary ===\n";
echo "Total venues updated: $updatedCount\n";
