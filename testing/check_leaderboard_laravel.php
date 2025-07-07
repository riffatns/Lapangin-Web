<?php

// Include Laravel bootstrap
require __DIR__ . '/../bootstrap/app.php';

use App\Models\UserProfile;
use App\Models\User;

echo "=== LEADERBOARD DATA CHECK ===\n\n";

// Check total user profiles
$totalProfiles = UserProfile::count();
echo "Total user profiles: {$totalProfiles}\n\n";

// Get top players like in the controller
$topPlayers = User::join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
    ->where('users.is_active', true)
    ->orderBy('user_profiles.total_points', 'desc')
    ->limit(10)
    ->select('users.name', 'user_profiles.total_points', 'user_profiles.favorite_sport')
    ->get();

echo "Top players from controller query:\n";
foreach ($topPlayers as $i => $player) {
    echo ($i + 1) . ". {$player->name}: {$player->total_points} points ({$player->favorite_sport})\n";
}

// Also check using the UserProfile model directly
echo "\nUser profiles directly:\n";
$profiles = UserProfile::with('user')->orderBy('total_points', 'desc')->get();
foreach ($profiles as $i => $profile) {
    echo ($i + 1) . ". {$profile->user->name}: {$profile->total_points} points ({$profile->favorite_sport})\n";
}

echo "\n=== CHECK COMPLETED ===\n";
