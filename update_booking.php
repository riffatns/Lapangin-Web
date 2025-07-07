<?php

use App\Models\Booking;

$booking = Booking::where('user_id', 1)->first();
if ($booking) {
    $booking->update(['status' => 'completed']);
    echo 'Updated booking to completed status: ' . $booking->booking_code . PHP_EOL;
} else {
    echo 'No booking found for user 1' . PHP_EOL;
}
