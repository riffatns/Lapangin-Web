<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Sport;

class VenuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badmintonId = Sport::where('slug', 'badminton')->first()->id;
        $futsalId = Sport::where('slug', 'futsal')->first()->id;
        $tennisId = Sport::where('slug', 'tennis')->first()->id;
        $basketballId = Sport::where('slug', 'basketball')->first()->id;

        $venues = [
            // Badminton venues
            [
                'name' => 'GOR Badminton Telyu',
                'slug' => 'gor-badminton-telyu',
                'sport_id' => $badmintonId,
                'description' => 'Gedung olahraga badminton modern dengan fasilitas lengkap di Telkom University',
                'location' => 'Telkom University',
                'city' => 'Bandung',
                'address' => 'Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung',
                'phone' => '022-87654321',
                'price_per_hour' => 50000,
                'images' => ['venue1.jpg', 'venue1_2.jpg'],
                'facilities' => ['Shuttlecock', 'Raket', 'AC', 'Parking', 'Shower'],
                'open_time' => '06:00',
                'close_time' => '22:00',
                'rating' => 4.5,
                'total_reviews' => 125,
                'is_active' => true
            ],
            [
                'name' => 'Badminton Club Bandung',
                'slug' => 'badminton-club-bandung',
                'sport_id' => $badmintonId,
                'description' => 'Klub badminton eksklusif dengan pelatih berpengalaman',
                'location' => 'Dago',
                'city' => 'Bandung',
                'address' => 'Jl. Dago No. 45, Bandung',
                'phone' => '022-12345678',
                'price_per_hour' => 75000,
                'images' => ['venue2.jpg'],
                'facilities' => ['Shuttlecock', 'Raket', 'Pelatih', 'AC', 'Cafeteria'],
                'open_time' => '07:00',
                'close_time' => '21:00',
                'rating' => 4.8,
                'total_reviews' => 89,
                'is_active' => true
            ],
            // Futsal venues
            [
                'name' => 'Futsal Arena',
                'slug' => 'futsal-arena',
                'sport_id' => $futsalId,
                'description' => 'Arena futsal dengan lapangan berkualitas FIFA standar',
                'location' => 'Cihampelas',
                'city' => 'Bandung',
                'address' => 'Jl. Cihampelas No. 123, Bandung',
                'phone' => '022-98765432',
                'price_per_hour' => 100000,
                'images' => ['venue3.jpg'],
                'facilities' => ['Bola', 'Rompi', 'Gawang', 'Tribun', 'Kantin'],
                'open_time' => '08:00',
                'close_time' => '23:00',
                'rating' => 4.3,
                'total_reviews' => 67,
                'is_active' => true
            ],
            // Tennis venues
            [
                'name' => 'Tennis Court Bandung',
                'slug' => 'tennis-court-bandung',
                'sport_id' => $tennisId,
                'description' => 'Lapangan tenis outdoor dengan pemandangan gunung',
                'location' => 'Lembang',
                'city' => 'Bandung',
                'address' => 'Jl. Lembang Raya No. 67, Lembang',
                'phone' => '022-11223344',
                'price_per_hour' => 80000,
                'images' => ['venue4.jpg'],
                'facilities' => ['Raket', 'Bola', 'Net', 'Lighting', 'Parking'],
                'open_time' => '06:00',
                'close_time' => '18:00',
                'rating' => 4.2,
                'total_reviews' => 45,
                'is_active' => true
            ]
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}
