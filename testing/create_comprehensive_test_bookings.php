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

echo "Creating various test bookings for different dates and times...\n\n";

$testBookings = [
    [
        'date' => '2025-07-03', // Today
        'start' => '08:00',
        'end' => '10:00',
        'slots' => ['08:00', '09:00'],
        'description' => 'Today morning booking'
    ],
    [
        'date' => '2025-07-03', // Today
        'start' => '15:00',
        'end' => '17:00',
        'slots' => ['15:00', '16:00'],
        'description' => 'Today afternoon booking'
    ],
    [
        'date' => '2025-07-04', // Tomorrow
        'start' => '10:00',
        'end' => '12:00',
        'slots' => ['10:00', '11:00'],
        'description' => 'Tomorrow morning booking'
    ],
    [
        'date' => '2025-07-04', // Tomorrow
        'start' => '18:00',
        'end' => '20:00',
        'slots' => ['18:00', '19:00'],
        'description' => 'Tomorrow evening booking'
    ],
    [
        'date' => '2025-07-05', // Day after tomorrow
        'start' => '06:00',
        'end' => '08:00',
        'slots' => ['06:00', '07:00'],
        'description' => 'Early morning booking'
    ],
    [
        'date' => '2025-07-05', // Day after tomorrow
        'start' => '14:00',
        'end' => '17:00',
        'slots' => ['14:00', '15:00', '16:00'],
        'description' => '3-hour afternoon booking'
    ],
    [
        'date' => '2025-07-06', // Weekend
        'start' => '12:00',
        'end' => '14:00',
        'slots' => ['12:00', '13:00'],
        'description' => 'Weekend lunch time booking'
    ]
];

foreach ($testBookings as $index => $booking) {
    try {
        $bookingCode = 'LPN-' . date('Ymd') . '-' . str_pad($index + 10, 3, '0', STR_PAD_LEFT);
        
        Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => $user->id,
            'venue_id' => $venue->id,
            'booking_date' => $booking['date'],
            'start_time' => $booking['start'],
            'end_time' => $booking['end'],
            'selected_time_slots' => $booking['slots'],
            'duration_hours' => count($booking['slots']),
            'total_price' => count($booking['slots']) * 100000,
            'status' => 'confirmed'
        ]);
        
        echo "✅ Created: {$booking['description']} ({$booking['date']} {$booking['start']}-{$booking['end']})\n";
    } catch (Exception $e) {
        echo "❌ Failed to create {$booking['description']}: {$e->getMessage()}\n";
    }
}

echo "\n📊 Summary:\n";
echo "Total bookings in database: " . Booking::count() . "\n";
echo "Bookings for today (2025-07-03): " . Booking::where('booking_date', '2025-07-03')->count() . "\n";
echo "Bookings for tomorrow (2025-07-04): " . Booking::where('booking_date', '2025-07-04')->count() . "\n";
echo "Bookings for 2025-07-05: " . Booking::where('booking_date', '2025-07-05')->count() . "\n";

echo "\n🎯 Test Cases Created:\n";
echo "- Today's bookings (should show as booked slots)\n";
echo "- Past time slots (should show as gray/disabled)\n";
echo "- Future date bookings (should update when date changes)\n";
echo "- Multi-slot bookings (3-hour booking)\n";
echo "- Different time ranges throughout the day\n";

echo "\n📝 Testing Instructions:\n";
echo "1. Visit the venue detail page\n";
echo "2. Check today's slots - some should be red (booked), some gray (past)\n";
echo "3. Change date to 2025-07-04 - different slots should be red\n";
echo "4. Change date to 2025-07-05 - different slots should be red\n";
echo "5. Change date to 2025-07-06 - lunch time slots should be red\n";
echo "6. Try selecting available slots and booking\n";
