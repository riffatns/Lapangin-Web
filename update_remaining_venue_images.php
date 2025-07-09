<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;
use App\Models\Sport;

echo "=== Updating Remaining Venue Images ===\n\n";

// Get reference images
$championsBasketball = Venue::where('slug', 'champions-basketball-arena')->first();
$highlandGolf = Venue::where('slug', 'highland-golf-course')->first();
$pingPongPalace = Venue::where('slug', 'ping-pong-palace')->first();

$championsImage = $championsBasketball ? $championsBasketball->main_image : 'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=800&h=600&fit=crop';
$golfImage = $highlandGolf ? $highlandGolf->main_image : 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?w=800&h=600&fit=crop';
$tableTennisImage = $pingPongPalace ? $pingPongPalace->main_image : 'https://images.unsplash.com/photo-1534158914592-062992fbe900?w=800&h=600&fit=crop';
$volleyballImage = 'https://images.unsplash.com/photo-1594736797933-d0c3668a9c78?w=800&h=600&fit=crop'; // As requested

echo "Reference images:\n";
echo "Basketball: $championsImage\n";
echo "Golf: $golfImage\n";
echo "Table Tennis: $tableTennisImage\n";
echo "Volleyball: $volleyballImage\n\n";

// Update Basketball venues
$basketballSport = Sport::where('slug', 'basketball')->first();
if ($basketballSport) {
    $basketballVenues = Venue::where('sport_id', $basketballSport->id)->get();
    echo "Updating Basketball venues:\n";
    foreach ($basketballVenues as $venue) {
        $venue->main_image = $championsImage;
        $venue->save();
        echo "✅ Updated: {$venue->name}\n";
    }
    echo "\n";
}

// Update Golf venues
$golfSport = Sport::where('slug', 'golf')->first();
if ($golfSport) {
    $golfVenues = Venue::where('sport_id', $golfSport->id)->get();
    echo "Updating Golf venues:\n";
    foreach ($golfVenues as $venue) {
        $venue->main_image = $golfImage;
        $venue->save();
        echo "✅ Updated: {$venue->name}\n";
    }
    echo "\n";
}

// Update Table Tennis venues
$tableTennisSport = Sport::where('slug', 'table-tennis')->first();
if ($tableTennisSport) {
    $tableTennisVenues = Venue::where('sport_id', $tableTennisSport->id)->get();
    echo "Updating Table Tennis venues:\n";
    foreach ($tableTennisVenues as $venue) {
        $venue->main_image = $tableTennisImage;
        $venue->save();
        echo "✅ Updated: {$venue->name}\n";
    }
    echo "\n";
}

// Update Volleyball venues
$volleyballSport = Sport::where('slug', 'volleyball')->first();
if ($volleyballSport) {
    $volleyballVenues = Venue::where('sport_id', $volleyballSport->id)->get();
    echo "Updating Volleyball venues:\n";
    foreach ($volleyballVenues as $venue) {
        $venue->main_image = $volleyballImage;
        $venue->save();
        echo "✅ Updated: {$venue->name}\n";
    }
    echo "\n";
}

echo "=== Update Complete ===\n";
echo "All remaining sport venues have been updated with consistent images!\n";
