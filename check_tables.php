<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== Checking Database Tables ===\n\n";

try {
    // Check if play_together table exists
    if (Schema::hasTable('play_together')) {
        echo "✅ Table 'play_together' exists\n";
        $columns = Schema::getColumnListing('play_together');
        echo "Columns: " . implode(', ', $columns) . "\n\n";
    } else {
        echo "❌ Table 'play_together' doesn't exist\n\n";
    }

    // Check if play_togethers table exists
    if (Schema::hasTable('play_togethers')) {
        echo "✅ Table 'play_togethers' exists\n";
        $columns = Schema::getColumnListing('play_togethers');
        echo "Columns: " . implode(', ', $columns) . "\n\n";
    } else {
        echo "❌ Table 'play_togethers' doesn't exist\n\n";
    }

    // Check if tournaments table exists
    if (Schema::hasTable('tournaments')) {
        echo "✅ Table 'tournaments' exists\n";
        $columns = Schema::getColumnListing('tournaments');
        echo "Columns: " . implode(', ', $columns) . "\n\n";
    } else {
        echo "❌ Table 'tournaments' doesn't exist\n\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
