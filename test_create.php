<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PlayTogether;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;

echo "Testing PlayTogether creation...\n";

$sport = Sport::first();
$user = User::first();

if (!$sport) {
    echo "No sports found!\n";
    exit;
}

if (!$user) {
    echo "No users found!\n";
    exit;
}

echo "Sport: {$sport->name} (ID: {$sport->id})\n";
echo "User: {$user->name} (ID: {$user->id})\n";

try {
    $playTogether = PlayTogether::create([
        'title' => 'Test Session',
        'description' => 'Test description',
        'creator_id' => $user->id,
        'sport_id' => $sport->id,
        'location' => 'Test Location',
        'scheduled_time' => Carbon::now()->addDays(1),
        'max_participants' => 8,
        'current_participants' => 0,
        'skill_level' => 'beginner',
        'price_per_person' => 25000,
        'status' => 'open'
    ]);

    echo "✅ Created PlayTogether: {$playTogether->title} (ID: {$playTogether->id})\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
