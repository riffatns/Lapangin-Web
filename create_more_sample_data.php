<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PlayTogether;
use App\Models\Tournament;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;

echo "Creating more sample data...\n";

$sports = Sport::all();
$users = User::take(3)->get();

if ($sports->count() < 2) {
    echo "Creating additional sports...\n";
    $futsalSport = Sport::firstOrCreate([
        'slug' => 'futsal'
    ], [
        'name' => 'Futsal',
        'description' => 'Indoor football with 5 players per team',
        'sort_order' => 2
    ]);
    
    $basketballSport = Sport::firstOrCreate([
        'slug' => 'basketball'
    ], [
        'name' => 'Basketball',
        'description' => 'Team sport played with two teams of five players',
        'sort_order' => 3
    ]);
}

$sports = Sport::all();
$creator1 = $users->first();
$creator2 = $users->count() > 1 ? $users->get(1) : $creator1;

// Create more PlayTogether sessions
$playTogethers = [
    [
        'title' => 'Futsal Weekend Fun',
        'description' => 'Futsal santai di weekend. Semua level welcome! Mari bersenang-senang bersama.',
        'creator_id' => $creator1->id,
        'sport_id' => $sports->where('slug', 'futsal')->first()?->id ?? $sports->first()->id,
        'location' => 'Futsal Arena Cihampelas',
        'scheduled_time' => Carbon::now()->addDays(3)->setTime(16, 0, 0),
        'max_participants' => 12,
        'current_participants' => 4,
        'skill_level' => 'beginner',
        'price_per_person' => 35000,
        'status' => 'open'
    ],
    [
        'title' => 'Basketball Training Pro',
        'description' => 'Latihan basket untuk meningkatkan skill shooting dan passing. Coach tersedia.',
        'creator_id' => $creator2->id,
        'sport_id' => $sports->where('slug', 'basketball')->first()?->id ?? $sports->first()->id,
        'location' => 'GOR Basket Siliwangi',
        'scheduled_time' => Carbon::now()->addDays(4)->setTime(19, 0, 0),
        'max_participants' => 10,
        'current_participants' => 6,
        'skill_level' => 'intermediate',
        'price_per_person' => 45000,
        'status' => 'open'
    ],
    [
        'title' => 'Badminton Evening',
        'description' => 'Main badminton santai di sore hari. Cocok untuk pemula sampai menengah.',
        'creator_id' => $creator1->id,
        'sport_id' => $sports->where('slug', 'badminton')->first()?->id ?? $sports->first()->id,
        'location' => 'GOR Badminton Pajajaran',
        'scheduled_time' => Carbon::now()->addDays(1)->setTime(17, 30, 0),
        'max_participants' => 8,
        'current_participants' => 2,
        'skill_level' => 'intermediate',
        'price_per_person' => 30000,
        'status' => 'open'
    ]
];

foreach ($playTogethers as $data) {
    try {
        $playTogether = PlayTogether::create($data);
        echo "✅ Created PlayTogether: {$playTogether->title}\n";
    } catch (Exception $e) {
        echo "❌ Failed to create PlayTogether {$data['title']}: " . $e->getMessage() . "\n";
    }
}

// Create more tournaments
$tournaments = [
    [
        'name' => 'Futsal League Championship',
        'description' => 'Liga futsal bergengsi dengan sistem round-robin. Daftar tim sekarang!',
        'sport_id' => $sports->where('slug', 'futsal')->first()?->id ?? $sports->first()->id,
        'organizer_id' => $creator2->id,
        'location' => 'Galaxy Futsal Center',
        'start_date' => Carbon::now()->addDays(21),
        'end_date' => Carbon::now()->addDays(23),
        'registration_deadline' => Carbon::now()->addDays(12),
        'max_participants' => 16,
        'current_participants' => 6,
        'entry_fee' => 750000,
        'prize_pool' => 999999.99, // Max allowed
        'format' => 'round_robin',
        'skill_level' => 'intermediate',
        'status' => 'registration_open'
    ],
    [
        'name' => 'Basketball 3v3 Cup',
        'description' => 'Turnamen basket 3 lawan 3 yang seru dan kompetitif. Terbuka untuk semua level.',
        'sport_id' => $sports->where('slug', 'basketball')->first()?->id ?? $sports->first()->id,
        'organizer_id' => $creator1->id,
        'location' => 'Lapangan Outdoor Dago',
        'start_date' => Carbon::now()->addDays(15),
        'end_date' => Carbon::now()->addDays(15),
        'registration_deadline' => Carbon::now()->addDays(8),
        'max_participants' => 24,
        'current_participants' => 9,
        'entry_fee' => 25000,
        'prize_pool' => 300000,
        'format' => 'single_elimination',
        'skill_level' => 'all',
        'status' => 'registration_open'
    ]
];

foreach ($tournaments as $data) {
    try {
        $tournament = Tournament::create($data);
        echo "✅ Created Tournament: {$tournament->name}\n";
    } catch (Exception $e) {
        echo "❌ Failed to create Tournament {$data['name']}: " . $e->getMessage() . "\n";
    }
}

echo "\nFinal data count:\n";
echo "PlayTogether sessions: " . PlayTogether::count() . "\n";
echo "Tournaments: " . Tournament::count() . "\n";

echo "\n=== Additional sample data creation completed! ===\n";
