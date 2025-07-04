<?php

require 'vendor/autoload.php';

use App\Models\Booking;
use App\Models\Venue;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$venue = Venue::first();
$user = User::first();

// Create booking for July 4, 2025
Booking::create([
    'booking_code' => 'LPN-' . date('Ymd') . '-004',
    'user_id' => $user->id,
    'venue_id' => $venue->id,
    'booking_date' => '2025-07-04',
    'start_time' => '10:00',
    'end_time' => '12:00',
    'selected_time_slots' => ['10:00', '11:00'],
    'duration_hours' => 2,
    'total_price' => 200000,
    'status' => 'confirmed'
]);

// Create booking for July 5, 2025
Booking::create([
    'booking_code' => 'LPN-' . date('Ymd') . '-005',
    'user_id' => $user->id,
    'venue_id' => $venue->id,
    'booking_date' => '2025-07-05',
    'start_time' => '14:00',
    'end_time' => '16:00',
    'selected_time_slots' => ['14:00', '15:00'],
    'duration_hours' => 2,
    'total_price' => 200000,
    'status' => 'confirmed'
]);

echo "Test bookings created for July 4 and 5, 2025\n";
