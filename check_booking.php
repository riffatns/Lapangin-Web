<?php

use App\Models\Booking;
use App\Models\User;

$booking = Booking::where('booking_code', 'LAP-TEST-6868585A02A2C')->first();
if ($booking) {
    $user = $booking->user;
    echo 'Booking Code: ' . $booking->booking_code . PHP_EOL;
    echo 'User ID: ' . $booking->user_id . PHP_EOL;
    echo 'User Name: ' . $user->name . PHP_EOL;
    echo 'User Email: ' . $user->email . PHP_EOL;
    echo 'Venue: ' . $booking->venue->name . PHP_EOL;
    echo 'Status: ' . $booking->status . PHP_EOL;
} else {
    echo 'Booking not found' . PHP_EOL;
}
