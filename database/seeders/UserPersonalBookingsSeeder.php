<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\User;
use Carbon\Carbon;

class UserPersonalBookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user (assuming this is the test user)
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('No users found. Please create users first.');
            return;
        }

        // Create pattern: User likes badminton and futsal venues, prefers mid-range prices
        $badmintonVenues = Venue::whereHas('sport', function($q) {
            $q->where('slug', 'badminton');
        })->take(3)->get();

        $futsalVenues = Venue::whereHas('sport', function($q) {
            $q->where('slug', 'futsal');
        })->take(2)->get();

        $bookingsCreated = 0;

        // Create badminton bookings (user's primary preference)
        foreach($badmintonVenues as $venue) {
            $numBookings = rand(3, 6);
            for($i = 0; $i < $numBookings; $i++) {
                $startHour = rand(9, 17);
                $endHour = $startHour + 2;
                
                Booking::create([
                    'booking_code' => 'USR' . time() . str_pad($bookingsCreated, 4, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'venue_id' => $venue->id,
                    'booking_date' => Carbon::now()->subDays(rand(1, 120)), // Last 4 months
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'duration_hours' => 2,
                    'total_price' => $venue->price_per_hour * 2,
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'confirmed_at' => Carbon::now()->subDays(rand(1, 120))
                ]);
                $bookingsCreated++;
            }
        }

        // Create some futsal bookings (secondary preference)
        foreach($futsalVenues as $venue) {
            $numBookings = rand(2, 4);
            for($i = 0; $i < $numBookings; $i++) {
                $startHour = rand(10, 18);
                $endHour = $startHour + 2;
                
                Booking::create([
                    'booking_code' => 'USR' . time() . str_pad($bookingsCreated, 4, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'venue_id' => $venue->id,
                    'booking_date' => Carbon::now()->subDays(rand(1, 120)), // Last 4 months
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'duration_hours' => 2,
                    'total_price' => $venue->price_per_hour * 2,
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'confirmed_at' => Carbon::now()->subDays(rand(1, 120))
                ]);
                $bookingsCreated++;
            }
        }

        $this->command->info("Created {$bookingsCreated} personal bookings for user: {$user->name}");
        
        // Show analysis
        $userBookings = $user->bookings()
            ->with('venue.sport')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subMonths(6))
            ->get();

        $bookedSports = $userBookings->pluck('venue.sport.name')->countBy();
        $avgPrice = $userBookings->avg('venue.price_per_hour');
        $cities = $userBookings->pluck('venue.city')->unique();

        $this->command->info("User booking analysis:");
        $this->command->line("- Sports booked: " . $bookedSports->map(function($count, $sport) {
            return "{$sport} ({$count}x)";
        })->implode(', '));
        $this->command->line("- Average price: Rp " . number_format($avgPrice, 0, ',', '.'));
        $this->command->line("- Preferred cities: " . $cities->implode(', '));
    }
}