<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;

echo "=== Venues with Missing Local Images ===\n\n";

$venues = Venue::all();
$venuesPath = public_path('img/venues/');

$missingImages = [];

foreach ($venues as $venue) {
    if (!empty($venue->main_image) && !str_starts_with($venue->main_image, 'http')) {
        $imagePath = $venuesPath . $venue->main_image;
        if (!file_exists($imagePath)) {
            $missingImages[] = [
                'name' => $venue->name,
                'slug' => $venue->slug,
                'main_image' => $venue->main_image,
                'sport' => $venue->sport->name
            ];
        }
    }
}

echo "Total venues with missing local images: " . count($missingImages) . "\n\n";

foreach ($missingImages as $venue) {
    echo "❌ {$venue['name']} ({$venue['sport']})\n";
    echo "   Slug: {$venue['slug']}\n";
    echo "   Missing file: {$venue['main_image']}\n\n";
}
