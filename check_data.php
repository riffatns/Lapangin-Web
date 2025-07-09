<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PlayTogether;
use App\Models\Tournament;

echo "PlayTogether count: " . PlayTogether::count() . "\n";
echo "Tournament count: " . Tournament::count() . "\n";

$playTogethers = PlayTogether::with(['sport', 'creator'])->get();
foreach ($playTogethers as $pt) {
    echo "PlayTogether: " . $pt->title . " (" . $pt->sport->name . ")\n";
}

$tournaments = Tournament::with(['sport', 'organizer'])->get();
foreach ($tournaments as $t) {
    echo "Tournament: " . $t->name . " (" . $t->sport->name . ")\n";
}
