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
        $volleyballId = Sport::where('slug', 'volleyball')->first()->id;
        $miniSoccerId = Sport::where('slug', 'mini-soccer')->first()->id;
        $tableTennisId = Sport::where('slug', 'table-tennis')->first()->id;
        $swimmingId = Sport::where('slug', 'swimming')->first()->id;
        $golfId = Sport::where('slug', 'golf')->first()->id;
        $boxingId = Sport::where('slug', 'boxing')->first()->id;

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
            [
                'name' => 'BEC Badminton Hall',
                'slug' => 'bec-badminton-hall',
                'sport_id' => $badmintonId,
                'description' => 'Lapangan badminton indoor dengan kualitas profesional dan pencahayaan optimal',
                'location' => 'Pasteur',
                'city' => 'Bandung',
                'address' => 'Jl. Pasteur No. 28, Bandung',
                'phone' => '022-20304050',
                'price_per_hour' => 60000,
                'images' => ['venue5.jpg'],
                'facilities' => ['Shuttlecock', 'Raket', 'AC', 'Parking', 'WiFi', 'Cafeteria'],
                'open_time' => '05:00',
                'close_time' => '23:00',
                'rating' => 4.6,
                'total_reviews' => 95,
                'is_active' => true
            ],
            [
                'name' => 'Istora Badminton Senayan',
                'slug' => 'istora-badminton-senayan',
                'sport_id' => $badmintonId,
                'description' => 'Lapangan badminton premium dengan standar internasional',
                'location' => 'Setiabudi',
                'city' => 'Bandung',
                'address' => 'Jl. Setiabudi No. 120, Bandung',
                'phone' => '022-70809000',
                'price_per_hour' => 85000,
                'images' => ['venue6.jpg'],
                'facilities' => ['Shuttlecock', 'Raket Premium', 'AC', 'Shower', 'Locker', 'Tribun'],
                'open_time' => '06:00',
                'close_time' => '22:00',
                'rating' => 4.9,
                'total_reviews' => 150,
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
            [
                'name' => 'Top Score Futsal',
                'slug' => 'top-score-futsal',
                'sport_id' => $futsalId,
                'description' => 'Lapangan futsal outdoor dengan rumput sintetis berkualitas tinggi',
                'location' => 'Buah Batu',
                'city' => 'Bandung',
                'address' => 'Jl. Buah Batu No. 88, Bandung',
                'phone' => '022-15161718',
                'price_per_hour' => 80000,
                'images' => ['venue7.jpg'],
                'facilities' => ['Bola', 'Rompi', 'Sepatu Futsal', 'Parkir Luas', 'Musholla'],
                'open_time' => '07:00',
                'close_time' => '22:00',
                'rating' => 4.1,
                'total_reviews' => 78,
                'is_active' => true
            ],
            [
                'name' => 'Galaxy Futsal Center',
                'slug' => 'galaxy-futsal-center',
                'sport_id' => $futsalId,
                'description' => 'Futsal center dengan multiple lapangan dan fasilitas modern',
                'location' => 'Antapani',
                'city' => 'Bandung',
                'address' => 'Jl. Antapani No. 45, Bandung',
                'phone' => '022-91011121',
                'price_per_hour' => 120000,
                'images' => ['venue8.jpg'],
                'facilities' => ['Bola Premium', 'Rompi', 'AC', 'Tribun VIP', 'Food Court', 'Gym'],
                'open_time' => '06:00',
                'close_time' => '24:00',
                'rating' => 4.7,
                'total_reviews' => 120,
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
            ],
            [
                'name' => 'Bandung Tennis Club',
                'slug' => 'bandung-tennis-club',
                'sport_id' => $tennisId,
                'description' => 'Klub tenis eksklusif dengan lapangan indoor dan outdoor',
                'location' => 'Dago Atas',
                'city' => 'Bandung',
                'address' => 'Jl. Dago Atas No. 150, Bandung',
                'phone' => '022-31415161',
                'price_per_hour' => 150000,
                'images' => ['venue9.jpg'],
                'facilities' => ['Raket Premium', 'Bola Wilson', 'Pelatih', 'AC', 'Spa', 'Restaurant'],
                'open_time' => '05:00',
                'close_time' => '21:00',
                'rating' => 4.8,
                'total_reviews' => 85,
                'is_active' => true
            ],
            [
                'name' => 'Green Valley Tennis',
                'slug' => 'green-valley-tennis',
                'sport_id' => $tennisId,
                'description' => 'Lapangan tenis dengan suasana pegunungan yang sejuk',
                'location' => 'Cipaganti',
                'city' => 'Bandung',
                'address' => 'Jl. Cipaganti No. 77, Bandung',
                'phone' => '022-71819202',
                'price_per_hour' => 90000,
                'images' => ['venue10.jpg'],
                'facilities' => ['Raket', 'Bola', 'Net Profesional', 'Gazebo', 'Parkir'],
                'open_time' => '06:00',
                'close_time' => '19:00',
                'rating' => 4.4,
                'total_reviews' => 62,
                'is_active' => true
            ],
            
            // Basketball venues
            [
                'name' => 'Basket Hall Bandung',
                'slug' => 'basket-hall-bandung',
                'sport_id' => $basketballId,
                'description' => 'Hall basket indoor dengan ring standar NBA',
                'location' => 'Sukajadi',
                'city' => 'Bandung',
                'address' => 'Jl. Sukajadi No. 99, Bandung',
                'phone' => '022-32233445',
                'price_per_hour' => 120000,
                'images' => ['venue11.jpg'],
                'facilities' => ['Bola Basket', 'Ring Adjustable', 'AC', 'Scorer Table', 'Sound System'],
                'open_time' => '07:00',
                'close_time' => '22:00',
                'rating' => 4.5,
                'total_reviews' => 95,
                'is_active' => true
            ],
            [
                'name' => 'Street Ball Bandung',
                'slug' => 'street-ball-bandung',
                'sport_id' => $basketballId,
                'description' => 'Lapangan basket outdoor dengan suasana streetball',
                'location' => 'Riau',
                'city' => 'Bandung',
                'address' => 'Jl. Riau No. 55, Bandung',
                'phone' => '022-56575859',
                'price_per_hour' => 75000,
                'images' => ['venue12.jpg'],
                'facilities' => ['Bola Basket', 'Ring Outdoor', 'Bench', 'Lighting', 'Sound System'],
                'open_time' => '08:00',
                'close_time' => '21:00',
                'rating' => 4.0,
                'total_reviews' => 72,
                'is_active' => true
            ],
            [
                'name' => 'Champions Basketball Arena',
                'slug' => 'champions-basketball-arena',
                'sport_id' => $basketballId,
                'description' => 'Arena basket premium dengan fasilitas turnamen',
                'location' => 'Pasteur',
                'city' => 'Bandung',
                'address' => 'Jl. Pasteur No. 200, Bandung',
                'phone' => '022-60616263',
                'price_per_hour' => 180000,
                'images' => ['venue13.jpg'],
                'facilities' => ['Bola Premium', 'Ring Profesional', 'AC', 'Tribun', 'Live Streaming', 'Cafeteria'],
                'open_time' => '06:00',
                'close_time' => '23:00',
                'rating' => 4.9,
                'total_reviews' => 140,
                'is_active' => true
            ],
            
            // Volleyball venues
            [
                'name' => 'Voli Center Bandung',
                'slug' => 'voli-center-bandung',
                'sport_id' => $volleyballId,
                'description' => 'Lapangan voli indoor dengan net standar internasional',
                'location' => 'Cimahi',
                'city' => 'Bandung',
                'address' => 'Jl. Cimahi Raya No. 111, Cimahi',
                'phone' => '022-64656667',
                'price_per_hour' => 85000,
                'images' => ['venue14.jpg'],
                'facilities' => ['Bola Voli', 'Net Profesional', 'AC', 'Shower', 'Parkir'],
                'open_time' => '07:00',
                'close_time' => '21:00',
                'rating' => 4.3,
                'total_reviews' => 58,
                'is_active' => true
            ],
            [
                'name' => 'Beach Volleyball Paradise',
                'slug' => 'beach-volleyball-paradise',
                'sport_id' => $volleyballId,
                'description' => 'Lapangan beach volleyball dengan pasir putih berkualitas',
                'location' => 'Margahayu',
                'city' => 'Bandung',
                'address' => 'Jl. Margahayu No. 88, Bandung',
                'phone' => '022-68697071',
                'price_per_hour' => 100000,
                'images' => ['venue15.jpg'],
                'facilities' => ['Bola Beach Volley', 'Net Beach', 'Gazebo', 'Shower Outdoor', 'Bar'],
                'open_time' => '08:00',
                'close_time' => '20:00',
                'rating' => 4.6,
                'total_reviews' => 75,
                'is_active' => true
            ],
            
            // Mini Soccer venues
            [
                'name' => 'Kids Soccer Arena',
                'slug' => 'kids-soccer-arena',
                'sport_id' => $miniSoccerId,
                'description' => 'Arena sepak bola mini khusus untuk anak-anak',
                'location' => 'Setiabudi',
                'city' => 'Bandung',
                'address' => 'Jl. Setiabudi No. 99, Bandung',
                'phone' => '022-72737475',
                'price_per_hour' => 60000,
                'images' => ['venue16.jpg'],
                'facilities' => ['Bola Mini', 'Gawang Kecil', 'Matras', 'Tribun', 'Kantin'],
                'open_time' => '09:00',
                'close_time' => '17:00',
                'rating' => 4.4,
                'total_reviews' => 45,
                'is_active' => true
            ],
            
            // Table Tennis venues
            [
                'name' => 'Ping Pong Palace',
                'slug' => 'ping-pong-palace',
                'sport_id' => $tableTennisId,
                'description' => 'Klub tenis meja dengan meja berkualitas tournament',
                'location' => 'Sukajadi',
                'city' => 'Bandung',
                'address' => 'Jl. Sukajadi No. 77, Bandung',
                'phone' => '022-76777879',
                'price_per_hour' => 40000,
                'images' => ['venue17.jpg'],
                'facilities' => ['Meja Tournament', 'Bet Profesional', 'Bola Premium', 'AC', 'Cafeteria'],
                'open_time' => '07:00',
                'close_time' => '22:00',
                'rating' => 4.2,
                'total_reviews' => 38,
                'is_active' => true
            ],
            
            // Swimming venues
            [
                'name' => 'Aquatic Center Bandung',
                'slug' => 'aquatic-center-bandung',
                'sport_id' => $swimmingId,
                'description' => 'Kolam renang olimpik dengan fasilitas lengkap',
                'location' => 'Cibiru',
                'city' => 'Bandung',
                'address' => 'Jl. Cibiru No. 150, Bandung',
                'phone' => '022-80818283',
                'price_per_hour' => 25000,
                'images' => ['venue18.jpg'],
                'facilities' => ['Kolam Olimpik', 'Kolam Anak', 'Diving Board', 'Shower', 'Locker', 'Cafeteria'],
                'open_time' => '05:00',
                'close_time' => '21:00',
                'rating' => 4.5,
                'total_reviews' => 92,
                'is_active' => true
            ],
            
            // Golf venues
            [
                'name' => 'Highland Golf Course',
                'slug' => 'highland-golf-course',
                'sport_id' => $golfId,
                'description' => 'Lapangan golf dengan pemandangan pegunungan yang indah',
                'location' => 'Lembang',
                'city' => 'Bandung',
                'address' => 'Jl. Raya Lembang No. 200, Lembang',
                'phone' => '022-84858687',
                'price_per_hour' => 300000,
                'images' => ['venue19.jpg'],
                'facilities' => ['Golf Cart', 'Driving Range', 'Putting Green', 'Caddy', 'Clubhouse', 'Restaurant'],
                'open_time' => '06:00',
                'close_time' => '18:00',
                'rating' => 4.8,
                'total_reviews' => 65,
                'is_active' => true
            ],
            
            // Boxing venues
            [
                'name' => 'Fight Club Bandung',
                'slug' => 'fight-club-bandung',
                'sport_id' => $boxingId,
                'description' => 'Gym tinju profesional dengan pelatih berpengalaman',
                'location' => 'Ciumbuleuit',
                'city' => 'Bandung',
                'address' => 'Jl. Ciumbuleuit No. 300, Bandung',
                'phone' => '022-88899091',
                'price_per_hour' => 150000,
                'images' => ['venue20.jpg'],
                'facilities' => ['Ring Tinju', 'Heavy Bag', 'Speed Bag', 'Gloves', 'Protective Gear', 'Sauna'],
                'open_time' => '06:00',
                'close_time' => '22:00',
                'rating' => 4.6,
                'total_reviews' => 42,
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
