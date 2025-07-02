<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;

class BookingsSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $venues = Venue::all();
        
        foreach ($users as $user) {
            // Create 2-5 bookings for each user
            $bookingCount = rand(2, 5);
            
            for ($i = 0; $i < $bookingCount; $i++) {
                $venue = $venues->random();
                $bookingDate = Carbon::now()->addDays(rand(-30, 30));
                $startTime = Carbon::createFromTime(rand(8, 20), 0);
                $durationHours = rand(1, 3);
                $endTime = $startTime->copy()->addHours($durationHours);
                
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'venue_id' => $venue->id,
                    'booking_code' => 'BKG' . $user->id . time() . $i . rand(100, 999),
                    'booking_date' => $bookingDate->format('Y-m-d'),
                    'start_time' => $startTime->format('H:i:s'),
                    'end_time' => $endTime->format('H:i:s'),
                    'duration_hours' => $durationHours,
                    'total_price' => $venue->price_per_hour * $durationHours,
                    'status' => ['pending', 'confirmed', 'completed', 'cancelled'][rand(0, 3)],
                    'notes' => 'Booking untuk ' . $venue->sport->name,
                ]);
                
                // Create payment for confirmed/completed bookings
                if (in_array($booking->status, ['confirmed', 'completed'])) {
                    Payment::create([
                        'payment_code' => 'PAY' . $user->id . time() . $i . rand(100, 999),
                        'user_id' => $user->id,
                        'booking_id' => $booking->id,
                        'amount' => $booking->total_price,
                        'method' => ['credit_card', 'transfer', 'ewallet', 'cash'][rand(0, 3)],
                        'status' => 'completed',
                        'external_id' => 'EXT' . $user->id . time() . $i . rand(100, 999),
                        'paid_at' => now(),
                    ]);
                }
            }
        }
    }
}
