<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Tournaments table structure:\n";
$table = DB::select('DESCRIBE tournaments');
foreach ($table as $column) {
    echo $column->Field . ': ' . $column->Type . "\n";
}
