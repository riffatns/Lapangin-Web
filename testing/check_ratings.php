<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->boot();

use App\Models\Venue;
use App\Models\Booking;

echo "=== VENUE RATINGS CHECK ===\n";
$venues = Venue::all();
foreach ($venues as $venue) {
    echo "Venue: {$venue->name}\n";
    echo "Rating: {$venue->rating}\n";
    echo "Reviews: {$venue->total_reviews}\n";
    echo "----\n";
}

echo "\n=== BOOKINGS WITH REVIEWS ===\n";
$reviewedBookings = Booking::whereNotNull('rating')->with('venue', 'user')->get();
foreach ($reviewedBookings as $booking) {
    echo "User: {$booking->user->name}\n";
    echo "Venue: {$booking->venue->name}\n";
    echo "Rating: {$booking->rating}\n";
    echo "Review: " . substr($booking->review, 0, 50) . "...\n";
    echo "----\n";
}
