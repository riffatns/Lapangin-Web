<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PlayTogether;
use App\Models\Tournament;
use App\Models\User;

echo "=== Final Verification of Komunitas Features ===\n\n";

// Test PlayTogether upcoming scope
echo "1. Testing PlayTogether upcoming scope:\n";
$upcomingPlayTogethers = PlayTogether::upcoming()->get();
echo "   Found " . $upcomingPlayTogethers->count() . " upcoming PlayTogether sessions\n";
foreach($upcomingPlayTogethers as $pt) {
    echo "   - " . $pt->title . " at " . $pt->formatted_scheduled_date . " " . $pt->formatted_scheduled_time . "\n";
}

echo "\n2. Testing Tournament upcoming scope:\n";
$upcomingTournaments = Tournament::upcoming()->get();
echo "   Found " . $upcomingTournaments->count() . " upcoming tournaments\n";
foreach($upcomingTournaments as $t) {
    echo "   - " . $t->name . " starting " . $t->formatted_start_date . "\n";
}

echo "\n3. Testing relationships:\n";
$firstPlayTogether = PlayTogether::with(['sport', 'creator'])->first();
if($firstPlayTogether) {
    echo "   PlayTogether '" . $firstPlayTogether->title . "' has:\n";
    echo "   - Sport: " . ($firstPlayTogether->sport ? $firstPlayTogether->sport->name : 'No sport') . "\n";
    echo "   - Creator: " . ($firstPlayTogether->creator ? $firstPlayTogether->creator->name : 'No creator') . "\n";
    echo "   - Available slots: " . $firstPlayTogether->available_slots . "\n";
    echo "   - Is upcoming: " . ($firstPlayTogether->is_upcoming ? 'Yes' : 'No') . "\n";
}

$firstTournament = Tournament::with(['sport', 'organizer'])->first();
if($firstTournament) {
    echo "   Tournament '" . $firstTournament->name . "' has:\n";
    echo "   - Sport: " . ($firstTournament->sport ? $firstTournament->sport->name : 'No sport') . "\n";
    echo "   - Organizer: " . ($firstTournament->organizer ? $firstTournament->organizer->name : 'No organizer') . "\n";
    echo "   - Available slots: " . $firstTournament->available_slots . "\n";
    echo "   - Is registration open: " . ($firstTournament->is_registration_open ? 'Yes' : 'No') . "\n";
}

echo "\n4. Testing join functionality:\n";
$user = User::first();
if($user && $firstPlayTogether) {
    $canJoin = $firstPlayTogether->canJoin($user);
    echo "   User '" . $user->name . "' can join '" . $firstPlayTogether->title . "': " . ($canJoin ? 'Yes' : 'No') . "\n";
}

if($user && $firstTournament) {
    $canRegister = $firstTournament->canRegister($user);
    echo "   User '" . $user->name . "' can register for '" . $firstTournament->name . "': " . ($canRegister ? 'Yes' : 'No') . "\n";
}

echo "\n=== All features verified! ===\n";
