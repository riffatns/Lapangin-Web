<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $venues = Venue::all();

        if ($users->isEmpty() || $venues->isEmpty()) {
            return;
        }

        $reviews = [
            ['rating' => 5, 'review' => 'Lapangan sangat bagus dan bersih! Fasilitas lengkap dan pelayanan memuaskan.'],
            ['rating' => 4, 'review' => 'Tempat yang nyaman untuk bermain. Hanya saja kadang agak ramai di weekend.'],
            ['rating' => 5, 'review' => 'Kualitas lapangan top! Pencahayaan bagus dan tidak licin.'],
            ['rating' => 4, 'review' => 'Overall bagus, tapi parkiran agak sempit. Lapangannya mantap!'],
            ['rating' => 3, 'review' => 'Standar lah, tidak terlalu istimewa tapi cukup untuk bermain.'],
            ['rating' => 5, 'review' => 'Recommended banget! Tempatnya strategis dan mudah dijangkau.'],
            ['rating' => 4, 'review' => 'Lapangan berkualitas dengan harga yang reasonable. Akan datang lagi.'],
            ['rating' => 5, 'review' => 'Perfect! Fasilitas shower dan toilet bersih. Lapangan juga terawat.'],
            ['rating' => 4, 'review' => 'Bagus untuk training. Suasana nyaman dan tidak terlalu berisik.'],
            ['rating' => 3, 'review' => 'Lumayan, tapi AC-nya kurang dingin. Secara keseluruhan oke.'],
        ];

        // Create sample bookings with reviews for each venue
        foreach ($venues as $venue) {
            $reviewCount = rand(3, 8);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();
                $reviewData = $reviews[array_rand($reviews)];
                
                Booking::create([
                    'booking_code' => 'LAP-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'venue_id' => $venue->id,
                    'booking_date' => Carbon::now()->subDays(rand(1, 30)),
                    'start_time' => sprintf('%02d:00', rand(8, 20)),
                    'end_time' => sprintf('%02d:00', rand(9, 22)),
                    'duration_hours' => rand(1, 3),
                    'total_price' => $venue->price_per_hour * rand(1, 3),
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'rating' => $reviewData['rating'],
                    'review' => $reviewData['review'],
                ]);
            }
        }
    }
}
