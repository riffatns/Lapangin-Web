<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Tournament;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;

echo "Testing Tournament creation...\n";

$sport = Sport::first();
$user = User::first();

echo "Sport: {$sport->name} (ID: {$sport->id})\n";
echo "User: {$user->name} (ID: {$user->id})\n";

try {
    $tournament = Tournament::create([
        'name' => 'Test Tournament',
        'description' => 'Test tournament description',
        'sport_id' => $sport->id,
        'organizer_id' => $user->id,
        'location' => 'Test Arena',
        'start_date' => Carbon::now()->addDays(14),
        'end_date' => Carbon::now()->addDays(16),
        'registration_deadline' => Carbon::now()->addDays(7),
        'max_participants' => 16,
        'current_participants' => 5,
        'entry_fee' => 50000,
        'prize_pool' => 500000,
        'format' => 'single_elimination',
        'skill_level' => 'intermediate',
        'status' => 'registration_open'
    ]);

    echo "✅ Created Tournament: {$tournament->name} (ID: {$tournament->id})\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
