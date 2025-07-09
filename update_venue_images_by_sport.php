<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;
use App\Models\Sport;

echo "=== Updating venue images by sport type ===\n\n";

// Reference images
$referenceImages = [
    'badminton' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=800&h=600&fit=crop',
    'mini-soccer' => 'https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9?w=800&h=600&fit=crop',
    'futsal' => 'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800&h=600&fit=crop',
    'tennis' => 'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?w=800&h=600&fit=crop'
];

// Get sports
$badmintonSport = Sport::where('slug', 'badminton')->first();
$miniSoccerSport = Sport::where('slug', 'mini-soccer')->first();
$futsalSport = Sport::where('slug', 'futsal')->first();
$tennisSport = Sport::where('slug', 'tennis')->first();

$updates = [];

// Update Badminton venues
if ($badmintonSport) {
    $badmintonVenues = Venue::where('sport_id', $badmintonSport->id)->get();
    foreach ($badmintonVenues as $venue) {
        $venue->main_image = $referenceImages['badminton'];
        $venue->save();
        $updates[] = "✅ {$venue->name} (Badminton)";
    }
}

// Update Mini Soccer venues
if ($miniSoccerSport) {
    $miniSoccerVenues = Venue::where('sport_id', $miniSoccerSport->id)->get();
    foreach ($miniSoccerVenues as $venue) {
        $venue->main_image = $referenceImages['mini-soccer'];
        $venue->save();
        $updates[] = "✅ {$venue->name} (Mini Soccer)";
    }
}

// Update Futsal venues
if ($futsalSport) {
    $futsalVenues = Venue::where('sport_id', $futsalSport->id)->get();
    foreach ($futsalVenues as $venue) {
        $venue->main_image = $referenceImages['futsal'];
        $venue->save();
        $updates[] = "✅ {$venue->name} (Futsal)";
    }
}

// Update Tennis venues
if ($tennisSport) {
    $tennisVenues = Venue::where('sport_id', $tennisSport->id)->get();
    foreach ($tennisVenues as $venue) {
        $venue->main_image = $referenceImages['tennis'];
        $venue->save();
        $updates[] = "✅ {$venue->name} (Tennis)";
    }
}

echo "Updated venues:\n";
foreach ($updates as $update) {
    echo "$update\n";
}

echo "\nTotal venues updated: " . count($updates) . "\n";
echo "\n=== Update completed! ===\n";
