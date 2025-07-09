<?php

require_once 'vendor/autoload.php';

use Carbon\Carbon;
use App\Models\Booking;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Current time Jakarta: " . Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s T') . PHP_EOL;
echo "Application timezone: " . config('app.timezone') . PHP_EOL;

$bookingsCount = Booking::count();
echo "Bookings count: " . $bookingsCount . PHP_EOL;

if ($bookingsCount > 0) {
    $booking = Booking::with('venue')->first();
    echo "Sample booking:" . PHP_EOL;
    echo "  Date: " . $booking->booking_date->format('Y-m-d') . PHP_EOL;
    echo "  Time: " . $booking->start_time . " - " . $booking->end_time . PHP_EOL;
    echo "  Current Status: " . $booking->getCurrentStatus() . PHP_EOL;
    echo "  Formatted Date: " . $booking->getBookingDateFormatted() . PHP_EOL;
    echo "  Formatted Time: " . $booking->getTimeRangeFormatted() . PHP_EOL;
    echo "  Selected Time Slots: " . implode(', ', $booking->getSelectedTimeSlots()) . PHP_EOL;
    echo "  Raw selected_time_slots: " . json_encode($booking->selected_time_slots) . PHP_EOL;
}
