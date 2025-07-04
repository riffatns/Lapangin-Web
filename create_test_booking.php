<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create test booking for 08:00-09:00 today
$booking = App\Models\Booking::create([
    'user_id' => 1,
    'venue_id' => 1,
    'booking_date' => date('Y-m-d'),
    'start_time' => '08:00',
    'end_time' => '09:00',
    'duration_hours' => 1,
    'total_price' => 50000,
    'status' => 'confirmed',
    'booking_code' => 'LAP-TEST001',
    'selected_time_slots' => json_encode(['08:00'])
]);

echo "Test booking created for 08:00-09:00 today\n";
echo "Booking ID: " . $booking->id . "\n";
