<?php

require 'vendor/autoload.php';

use App\Models\Booking;
use App\Models\Venue;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📊 BOOKING SYSTEM TEST REPORT\n";
echo "========================================\n\n";

$venue = Venue::first();
if (!$venue) {
    echo "❌ No venue found in database\n";
    exit;
}

echo "🏟️  Testing Venue: {$venue->name}\n";
echo "📅 Current Date: " . now()->format('Y-m-d') . "\n";
echo "⏰ Current Time: " . now()->format('H:i') . "\n\n";

// Test dates
$testDates = [
    now()->format('Y-m-d'), // Today
    now()->addDay()->format('Y-m-d'), // Tomorrow
    now()->addDays(2)->format('Y-m-d'), // Day after tomorrow
    now()->addDays(3)->format('Y-m-d'), // 3 days from now
];

foreach ($testDates as $date) {
    echo "📅 Date: {$date}\n";
    echo "----------------------------------------\n";
    
    $bookings = Booking::where('venue_id', $venue->id)
                      ->where('booking_date', $date)
                      ->where('status', '!=', 'cancelled')
                      ->get();
    
    if ($bookings->count() == 0) {
        echo "✅ No bookings - all slots available\n";
    } else {
        echo "📋 Bookings found: {$bookings->count()}\n";
        foreach ($bookings as $booking) {
            $slots = is_array($booking->selected_time_slots) 
                   ? implode(', ', $booking->selected_time_slots)
                   : $booking->start_time . '-' . $booking->end_time;
            echo "   🔒 Booked: {$slots} (Status: {$booking->status})\n";
        }
    }
    
    // Check booked slots
    $bookedSlots = [];
    foreach ($bookings as $booking) {
        if ($booking->selected_time_slots && is_array($booking->selected_time_slots)) {
            $bookedSlots = array_merge($bookedSlots, $booking->selected_time_slots);
        }
    }
    $bookedSlots = array_unique($bookedSlots);
    
    if (!empty($bookedSlots)) {
        echo "   🚫 Unavailable slots: " . implode(', ', $bookedSlots) . "\n";
    }
    
    echo "\n";
}

echo "🧪 API ENDPOINT TESTS\n";
echo "========================================\n";

foreach ($testDates as $date) {
    echo "Testing endpoint for {$date}:\n";
    echo "GET /venue/{$venue->id}/booking-data?date={$date}\n";
    
    // Simulate the controller logic
    $timeSlots = [
        '06:00' => '06:00 - 07:00',
        '07:00' => '07:00 - 08:00',
        '08:00' => '08:00 - 09:00',
        '09:00' => '09:00 - 10:00',
        '10:00' => '10:00 - 11:00',
        '11:00' => '11:00 - 12:00',
        '12:00' => '12:00 - 13:00',
        '13:00' => '13:00 - 14:00',
        '14:00' => '14:00 - 15:00',
        '15:00' => '15:00 - 16:00',
        '16:00' => '16:00 - 17:00',
        '17:00' => '17:00 - 18:00',
        '18:00' => '18:00 - 19:00',
        '19:00' => '19:00 - 20:00',
        '20:00' => '20:00 - 21:00',
        '21:00' => '21:00 - 22:00',
        '22:00' => '22:00 - 23:00'
    ];
    
    $existingBookings = $venue->bookings()
        ->where('booking_date', $date)
        ->where('status', '!=', 'cancelled')
        ->get();

    $bookedSlots = [];
    foreach ($existingBookings as $booking) {
        if ($booking->selected_time_slots && is_array($booking->selected_time_slots)) {
            $bookedSlots = array_merge($bookedSlots, $booking->selected_time_slots);
        }
    }
    $bookedSlots = array_unique($bookedSlots);
    
    $today = now()->format('Y-m-d');
    $currentTime = now()->format('H:i');
    $pastSlots = [];
    if ($date === $today) {
        foreach ($timeSlots as $time => $label) {
            if ($time <= $currentTime) {
                $pastSlots[] = $time;
            }
        }
    }
    
    echo "   📊 Response would contain:\n";
    echo "   - Total slots: " . count($timeSlots) . "\n";
    echo "   - Booked slots: " . count($bookedSlots) . " (" . implode(', ', $bookedSlots) . ")\n";
    echo "   - Past slots: " . count($pastSlots) . " (" . implode(', ', $pastSlots) . ")\n";
    echo "   - Available slots: " . (count($timeSlots) - count($bookedSlots) - count($pastSlots)) . "\n";
    echo "\n";
}

echo "🎯 TESTING RECOMMENDATIONS\n";
echo "========================================\n";
echo "1. Visit venue detail page and verify initial slot status\n";
echo "2. Change booking date and watch slots update via AJAX\n";
echo "3. Try booking available slots (should work)\n";
echo "4. Try booking booked slots (should show error)\n";
echo "5. Try booking past slots (should show error)\n";
echo "6. Test on different dates to verify dynamic loading\n";
echo "7. Check browser console for any JavaScript errors\n";
echo "8. Verify booking submission works correctly\n\n";

echo "✅ Test report completed!\n";
