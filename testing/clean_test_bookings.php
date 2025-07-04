<?php

require 'vendor/autoload.php';

use App\Models\Booking;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧹 Cleaning up test bookings...\n\n";

// Delete all bookings (be careful in production!)
$deletedCount = Booking::count();

// Delete related records first if they exist
if (Schema::hasTable('payments')) {
    DB::table('payments')->delete();
}

// Then delete bookings
Booking::query()->delete();

echo "✅ Deleted {$deletedCount} test bookings\n";
echo "🎯 Database is now clean for fresh testing\n\n";

echo "📝 Next steps:\n";
echo "1. Run create_comprehensive_test_bookings.php to create fresh test data\n";
echo "2. Test the booking functionality on the website\n";
