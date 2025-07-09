<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;
use App\Models\Sport;

echo "=== Fixing Volleyball venue images ===\n\n";

// New working volleyball image URL
$newVolleyballImage = 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop';

// Get volleyball sport
$volleyballSport = Sport::where('slug', 'volleyball')->first();

$updates = [];

// Update Volleyball venues
if ($volleyballSport) {
    $volleyballVenues = Venue::where('sport_id', $volleyballSport->id)->get();
    foreach ($volleyballVenues as $venue) {
        $venue->main_image = $newVolleyballImage;
        $venue->save();
        $updates[] = "✅ {$venue->name} (Volleyball)";
    }
}

echo "Updated volleyball venues:\n";
foreach ($updates as $update) {
    echo "$update\n";
}

echo "\nTotal volleyball venues updated: " . count($updates) . "\n";
echo "New volleyball image URL: $newVolleyballImage\n";
echo "\n=== Volleyball image fix completed! ===\n";
