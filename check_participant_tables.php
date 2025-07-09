<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;

if (Schema::hasTable('play_together_participants')) {
    echo "Table play_together_participants exists\n";
    echo "Columns: " . implode(', ', Schema::getColumnListing('play_together_participants')) . "\n";
} else {
    echo "Table play_together_participants does not exist\n";
}

if (Schema::hasTable('tournament_participants')) {
    echo "Table tournament_participants exists\n";
    echo "Columns: " . implode(', ', Schema::getColumnListing('tournament_participants')) . "\n";
} else {
    echo "Table tournament_participants does not exist\n";
}
