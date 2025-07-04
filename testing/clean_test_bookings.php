<?php

require 'vendor/autoload.php';

use App\Models\Booking;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧹 Cleaning up test bookings...\n\n";

// Delete all bookings (be careful in production!)
$deletedCount = Booking::count();
Booking::truncate();

echo "✅ Deleted {$deletedCount} test bookings\n";
echo "🎯 Database is now clean for fresh testing\n\n";

echo "📝 Next steps:\n";
echo "1. Run create_comprehensive_test_bookings.php to create fresh test data\n";
echo "2. Test the booking functionality on the website\n";
