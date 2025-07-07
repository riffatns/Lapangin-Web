<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Setup database connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../database/database.sqlite',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "=== CHECKING LEADERBOARD DATA ===\n\n";

// Check users and their profiles
echo "1. Users with profiles:\n";
$users = Capsule::table('users')
    ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
    ->select('users.name', 'user_profiles.total_points', 'user_profiles.ranking', 'user_profiles.favorite_sport')
    ->orderBy('user_profiles.total_points', 'desc')
    ->get();

foreach ($users as $user) {
    echo "- {$user->name}: {$user->total_points} points, Rank #{$user->ranking}, Sport: {$user->favorite_sport}\n";
}

echo "\n2. Total user profiles: " . Capsule::table('user_profiles')->count() . "\n";
echo "3. Users without profiles: " . (Capsule::table('users')->count() - Capsule::table('user_profiles')->count()) . "\n";

// Check the top players query that's used in controller
echo "\n4. Top players query (same as controller):\n";
$topPlayers = Capsule::table('users')
    ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
    ->where('users.is_active', true)
    ->orderBy('user_profiles.total_points', 'desc')
    ->limit(5)
    ->select('users.name', 'user_profiles.total_points', 'user_profiles.favorite_sport')
    ->get();

foreach ($topPlayers as $player) {
    echo "- {$player->name}: {$player->total_points} pts, {$player->favorite_sport}\n";
}

echo "\n=== CHECK COMPLETED ===\n";
