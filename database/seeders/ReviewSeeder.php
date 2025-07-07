<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\User;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get existing users and venues
        $users = User::all();
        $venues = Venue::all();

        if ($users->isEmpty() || $venues->isEmpty()) {
            $this->command->info('No users or venues found. Please run other seeders first.');
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'review' => 'Venue yang sangat bagus! Fasilitas lengkap dan lapangan dalam kondisi prima. Staff juga sangat ramah dan helpful.'
            ],
            [
                'rating' => 4,
                'review' => 'Tempat yang nyaman untuk bermain. Parkir luas dan mudah diakses. Hanya saja bisa lebih bersih lagi toiletnya.'
            ],
            [
                'rating' => 5,
                'review' => 'Excellent venue! Lapangan berkualitas tinggi dengan pencahayaan yang sangat baik. Recommended banget!'
            ],
            [
                'rating' => 4,
                'review' => 'Overall bagus, fasilitas cukup lengkap. AC dingin dan ruang ganti bersih. Value for money!'
            ],
            [
                'rating' => 3,
                'review' => 'Lumayan lah untuk harga segini. Lapangan standar tapi masih bisa diterima untuk main bareng teman.'
            ],
            [
                'rating' => 5,
                'review' => 'Top markotop! Venue favorit saya dan teman-teman. Booking mudah dan pelayanan memuaskan.'
            ],
            [
                'rating' => 4,
                'review' => 'Bagus banget venuenya, cuma agak susah cari parkir kalau weekend. Tapi lapangannya keren!'
            ],
            [
                'rating' => 5,
                'review' => 'Mantap jiwa! Fasilitas modern, lapangan berkualitas, dan staff yang profesional. Highly recommended!'
            ],
            [
                'rating' => 4,
                'review' => 'Venue yang solid. Lokasinya strategis dan mudah dijangkau. Cocok untuk main rutin sama tim.'
            ],
            [
                'rating' => 3,
                'review' => 'Oke sih, tapi bisa ditingkatkan lagi kebersihan kamar mandinya. Overall masih worth it.'
            ]
        ];

        // Create some bookings with reviews
        foreach ($venues as $venue) {
            // Create 3-7 reviewed bookings per venue
            $reviewCount = rand(3, 7);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();
                $reviewData = $reviews[array_rand($reviews)];
                
                // Create a completed booking from the past
                $bookingDate = Carbon::now()->subDays(rand(1, 60));
                
                // Generate unique booking code
                do {
                    $bookingCode = 'BK' . time() . rand(1000, 9999);
                } while (Booking::where('booking_code', $bookingCode)->exists());
                
                $booking = Booking::create([
                    'booking_code' => $bookingCode,
                    'user_id' => $user->id,
                    'venue_id' => $venue->id,
                    'booking_date' => $bookingDate->format('Y-m-d'),
                    'start_time' => '09:00',
                    'end_time' => '11:00',
                    'duration_hours' => 2,
                    'total_price' => $venue->price_per_hour * 2,
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'selected_time_slots' => ['09:00', '10:00'],
                    'rating' => $reviewData['rating'],
                    'review' => $reviewData['review'],
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate
                ]);
            }
        }

        // Update venue ratings based on reviews
        foreach ($venues as $venue) {
            $averageRating = $venue->bookings()
                ->whereNotNull('rating')
                ->avg('rating');
            
            $totalReviews = $venue->bookings()
                ->whereNotNull('rating')
                ->count();
            
            $venue->update([
                'rating' => round($averageRating, 2),
                'total_reviews' => $totalReviews
            ]);
        }

        $this->command->info('Review seeder completed successfully!');
        $this->command->info('Total bookings with reviews created: ' . Booking::whereNotNull('rating')->count());
    }
}
