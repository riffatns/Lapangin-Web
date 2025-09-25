<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\User;
use Carbon\Carbon;

class PopularVenuesTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = Venue::take(8)->get();
        $users = User::all();

        if ($venues->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No venues or users found. Please run VenuesSeeder and ensure users exist first.');
            return;
        }

        $bookingsCreated = 0;

        foreach($venues as $venue) {
            $numBookings = rand(5, 15); // More bookings for better testing
            
            for($i = 0; $i < $numBookings; $i++) {
                $startHour = rand(8, 18);
                $endHour = $startHour + rand(1, 3);
                
                Booking::create([
                    'booking_code' => 'TST' . time() . str_pad($bookingsCreated, 4, '0', STR_PAD_LEFT),
                    'user_id' => $users->random()->id,
                    'venue_id' => $venue->id,
                    'booking_date' => Carbon::now()->subDays(rand(1, 90)), // Last 3 months
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'duration_hours' => $endHour - $startHour,
                    'total_price' => $venue->price_per_hour * ($endHour - $startHour),
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'confirmed_at' => Carbon::now()->subDays(rand(1, 90))
                ]);
                $bookingsCreated++;
            }
        }

        $this->command->info("Created {$bookingsCreated} test bookings for popular venues feature.");
        
        // Show popular venues
        $popularVenues = Venue::withCount(['bookings' => function($query) {
            $query->where('status', '!=', 'cancelled')
                  ->where('created_at', '>=', now()->subMonths(3));
        }])
        ->having('bookings_count', '>', 0)
        ->orderBy('bookings_count', 'desc')
        ->take(8)
        ->get();

        $this->command->info("Popular venues (by booking count):");
        foreach($popularVenues as $venue) {
            $this->command->line("- {$venue->name}: {$venue->bookings_count} bookings");
        }
    }
}