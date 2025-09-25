<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Sport;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a sport for association
        $badmintonSport = Sport::where('slug', 'badminton')->first();
        $futsalSport = Sport::where('slug', 'futsal')->first();
        $basketballSport = Sport::where('slug', 'basketball')->first();
        
        $venues = [
            [
                'name' => 'SportHall Bandung',
                'slug' => 'sporthall-bandung',
                'sport_id' => $badmintonSport ? $badmintonSport->id : null,
                'description' => 'Venue olahraga terlengkap di Bandung dengan berbagai fasilitas modern',
                'location' => 'Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Sudirman No. 123, Bandung',
                'phone' => '022-1234567',
                'price_per_hour' => 50000,
                'facilities' => json_encode(['Parking', 'WiFi', 'Shower', 'Locker', 'Cafeteria']),
                'open_time' => '06:00',
                'close_time' => '22:00',
                'rating' => 4.5,
                'total_reviews' => 120,
                'is_active' => true
            ],
            [
                'name' => 'Arena Sports Jakarta',
                'slug' => 'arena-sports-jakarta',
                'sport_id' => $futsalSport ? $futsalSport->id : null,
                'description' => 'Arena olahraga berkualitas tinggi di Jakarta Selatan',
                'location' => 'Jakarta Selatan',
                'city' => 'Jakarta',
                'address' => 'Jl. Kebayoran Lama No. 456, Jakarta Selatan',
                'phone' => '021-9876543',
                'price_per_hour' => 75000,
                'facilities' => json_encode(['Parking', 'WiFi', 'Shower', 'Locker', 'Gym', 'Spa']),
                'open_time' => '05:30',
                'close_time' => '23:00',
                'rating' => 4.8,
                'total_reviews' => 250,
                'is_active' => true
            ],
            [
                'name' => 'GOR Surabaya Center',
                'slug' => 'gor-surabaya-center',
                'sport_id' => $basketballSport ? $basketballSport->id : null,
                'description' => 'Gedung olahraga pusat kota Surabaya dengan fasilitas lengkap',
                'location' => 'Surabaya Pusat',
                'city' => 'Surabaya',
                'address' => 'Jl. Pemuda No. 789, Surabaya',
                'phone' => '031-5555666',
                'price_per_hour' => 60000,
                'facilities' => json_encode(['Parking', 'WiFi', 'Shower', 'Locker', 'Cafeteria', 'Medical']),
                'open_time' => '06:00',
                'close_time' => '22:00',
                'rating' => 4.2,
                'total_reviews' => 89,
                'is_active' => true
            ],
            [
                'name' => 'Sports Complex Yogya',
                'slug' => 'sports-complex-yogya',
                'sport_id' => $badmintonSport ? $badmintonSport->id : null,
                'description' => 'Kompleks olahraga terbesar di Yogyakarta',
                'location' => 'Yogya Kota',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Malioboro No. 321, Yogyakarta',
                'phone' => '0274-333444',
                'price_per_hour' => 45000,
                'facilities' => json_encode(['Parking', 'WiFi', 'Shower', 'Locker']),
                'open_time' => '06:00',
                'close_time' => '21:30',
                'rating' => 4.0,
                'total_reviews' => 67,
                'is_active' => true
            ],
            [
                'name' => 'Bali Sports Arena',
                'slug' => 'bali-sports-arena',
                'sport_id' => $futsalSport ? $futsalSport->id : null,
                'description' => 'Arena olahraga modern dengan pemandangan indah di Bali',
                'location' => 'Denpasar',
                'city' => 'Bali',
                'address' => 'Jl. Sunset Road No. 555, Denpasar, Bali',
                'phone' => '0361-777888',
                'price_per_hour' => 80000,
                'facilities' => json_encode(['Parking', 'WiFi', 'Shower', 'Locker', 'Pool', 'Restaurant']),
                'open_time' => '06:00',
                'close_time' => '22:00',
                'rating' => 4.7,
                'total_reviews' => 180,
                'is_active' => true
            ]
        ];

        foreach ($venues as $venue) {
            Venue::updateOrCreate(
                ['slug' => $venue['slug']], // Find by slug
                $venue // Update or create with this data
            );
        }
    }
}
