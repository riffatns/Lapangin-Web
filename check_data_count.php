<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PlayTogether;
use App\Models\Tournament;

echo "PlayTogether Sessions: " . PlayTogether::count() . "\n";
foreach(PlayTogether::all() as $pt) {
    echo "- " . $pt->title . " (" . $pt->status . ")\n";
}

echo "\nTournaments: " . Tournament::count() . "\n";
foreach(Tournament::all() as $t) {
    echo "- " . $t->name . " (" . $t->status . ")\n";
}
