<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;

try {
    $venues = Venue::all();
    echo "Total venues: " . $venues->count() . PHP_EOL;
    
    foreach($venues as $venue) {
        try {
            $galleryImages = $venue->gallery_images;
            $galleryCount = is_array($galleryImages) ? count($galleryImages) : 0;
            echo $venue->name . " - Gallery: " . $galleryCount . " items" . PHP_EOL;
            
            // Also check images field
            $images = $venue->images;
            $imagesCount = is_array($images) ? count($images) : 0;
            echo "  Images: " . $imagesCount . " items" . PHP_EOL;
            
        } catch(Exception $e) {
            echo "Error with venue: " . $venue->name . " - " . $e->getMessage() . PHP_EOL;
        }
    }
    
} catch(Exception $e) {
    echo "General error: " . $e->getMessage() . PHP_EOL;
}
