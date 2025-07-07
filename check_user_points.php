<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\UserProfile;
use App\Models\User;

echo "=== CHECKING USER POINTS DATA ===\n\n";

// Check if UserProfiles table has data
$totalProfiles = UserProfile::count();
echo "Total User Profiles: {$totalProfiles}\n\n";

if ($totalProfiles > 0) {
    echo "User Points Data:\n";
    echo "================\n";
    
    $profiles = UserProfile::with('user')->orderBy('total_points', 'desc')->get();
    
    foreach ($profiles as $profile) {
        $userName = $profile->user ? $profile->user->name : 'Unknown User';
        echo "- {$userName}: {$profile->total_points} points\n";
    }
    
    echo "\nTop 5 Leaderboard:\n";
    echo "=================\n";
    
    $topPlayers = User::join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
        ->where('users.is_active', true)
        ->orderBy('user_profiles.total_points', 'desc')
        ->limit(5)
        ->select('users.name', 'user_profiles.total_points', 'user_profiles.favorite_sport')
        ->get();
    
    $rank = 1;
    foreach ($topPlayers as $player) {
        echo "#{$rank}. {$player->name} - {$player->total_points} points ({$player->favorite_sport})\n";
        $rank++;
    }
} else {
    echo "❌ No user profiles found! Need to seed data.\n";
    echo "\nRun: php artisan db:seed --class=UserProfilesSeeder\n";
}

echo "\n=== CHECKING DATABASE CONNECTION ===\n";
try {
    $users = User::count();
    echo "✅ Database connected. Total users: {$users}\n";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}
