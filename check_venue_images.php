<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;

echo "=== Venue Main Images Check ===\n\n";

$venues = Venue::all();

$venuesWithoutMainImage = [];
$venuesWithLocalImage = [];
$venuesWithExternalImage = [];

foreach ($venues as $venue) {
    if (empty($venue->main_image)) {
        $venuesWithoutMainImage[] = $venue->name;
    } elseif (str_starts_with($venue->main_image, 'http')) {
        $venuesWithExternalImage[] = [
            'name' => $venue->name,
            'main_image' => $venue->main_image
        ];
    } else {
        $venuesWithLocalImage[] = [
            'name' => $venue->name,
            'main_image' => $venue->main_image
        ];
    }
}

echo "Total venues: " . $venues->count() . "\n\n";

echo "=== Venues WITHOUT main_image ===\n";
if (empty($venuesWithoutMainImage)) {
    echo "✅ All venues have main_image!\n";
} else {
    foreach ($venuesWithoutMainImage as $venueName) {
        echo "❌ $venueName\n";
    }
}

echo "\n=== Venues with LOCAL main_image ===\n";
foreach ($venuesWithLocalImage as $venue) {
    echo "📁 {$venue['name']}: {$venue['main_image']}\n";
}

echo "\n=== Venues with EXTERNAL main_image ===\n";
foreach ($venuesWithExternalImage as $venue) {
    echo "🌐 {$venue['name']}: {$venue['main_image']}\n";
}

echo "\n=== Summary ===\n";
echo "Venues with local images: " . count($venuesWithLocalImage) . "\n";
echo "Venues with external images: " . count($venuesWithExternalImage) . "\n";
echo "Venues without main_image: " . count($venuesWithoutMainImage) . "\n";
