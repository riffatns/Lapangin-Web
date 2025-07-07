<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Booking;
use App\Models\Venue;

// Get first user and venue
$user = User::first();
$venue = Venue::first();

if ($user && $venue) {
    // Create a completed booking without rating
    $booking = Booking::create([
        'booking_code' => 'LAP-TEST-' . strtoupper(uniqid()),
        'user_id' => $user->id,
        'venue_id' => $venue->id,
        'booking_date' => now()->subDays(1), // Yesterday
        'start_time' => '10:00',
        'end_time' => '12:00',
        'duration_hours' => 2,
        'total_price' => $venue->price_per_hour * 2,
        'status' => 'completed',
        'payment_status' => 'paid',
        'selected_time_slots' => ['10:00-11:00', '11:00-12:00'],
        'notes' => 'Booking untuk testing rating system',
        'rating' => null, // Make sure no rating yet
        'review' => null
    ]);
    
    echo "✅ Completed booking created successfully!\n";
    echo "Booking ID: " . $booking->id . "\n";
    echo "Booking Code: " . $booking->booking_code . "\n";
    echo "User: " . $user->name . "\n";
    echo "Venue: " . $venue->name . "\n";
    echo "Status: " . $booking->status . "\n";
    echo "Date: " . $booking->booking_date . "\n";
    echo "Time: " . $booking->start_time . " - " . $booking->end_time . "\n";
    echo "Rating: " . ($booking->rating ? $booking->rating : 'Belum ada rating') . "\n";
} else {
    echo "❌ No user or venue found in database\n";
}
