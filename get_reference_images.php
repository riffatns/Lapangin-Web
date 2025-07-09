<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;
use App\Models\Sport;

// Get reference images
$badmintonRef = Venue::where('slug', 'gor-badminton-telyu')->first();
$soccerRef = Venue::where('slug', 'soccer-field-cibiru')->first();
$futsalRef = Venue::where('slug', 'galaxy-futsal-center')->first();
$tennisRef = Venue::where('slug', 'tennis-court-cimahi')->first();

echo "Reference Images:\n";
echo "Badminton (GOR Badminton Telyu): " . ($badmintonRef ? $badmintonRef->main_image : 'NOT FOUND') . "\n";
echo "Soccer (Soccer Field Cibiru): " . ($soccerRef ? $soccerRef->main_image : 'NOT FOUND') . "\n";
echo "Futsal (Galaxy Futsal Center): " . ($futsalRef ? $futsalRef->main_image : 'NOT FOUND') . "\n";
echo "Tennis (Tennis Court Cimahi): " . ($tennisRef ? $tennisRef->main_image : 'NOT FOUND') . "\n";
