<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Sport;
use App\Models\Community;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('profile');
        $userProfile = $user->profile;

        // Get popular venues
        $venues = Venue::with('sport')
            ->where('venues.is_active', true)
            ->orderBy('rating', 'desc')
            ->orderBy('total_reviews', 'desc')
            ->take(6)
            ->get();

        // Get sports
        $sports = Sport::where('sports.is_active', true)->get();

        // Get popular communities
        $popularCommunities = Community::with('sport', 'creator')
            ->where('communities.is_active', true)
            ->where('is_private', false)
            ->orderBy('total_members', 'desc')
            ->take(4)
            ->get();

        // Get user's recent bookings if any
        $recentBookings = $user->bookings()
            ->with('venue.sport')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Stats for user
        $stats = [
            'total_bookings' => $userProfile ? $userProfile->total_bookings : 0,
            'total_communities' => $user->activeCommunities()->count(),
            'total_points' => $userProfile ? $userProfile->total_points : 0,
            'ranking' => $userProfile ? $userProfile->ranking : null
        ];

        return view('dashboard', compact(
            'venues', 
            'sports', 
            'popularCommunities', 
            'recentBookings',
            'stats',
            'user'
        ));
    }

    public function show(Venue $venue)
    {
        $user = Auth::user();
        
        // Load venue with relationships
        $venue->load(['sport', 'bookings' => function($query) {
            $query->with('user')->latest()->take(5);
        }]);

        // Get available time slots (example for today)
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');
        $selectedDate = request('booking_date', $today); // Get selected date from request or use today
        
        $timeSlots = [
            '06:00' => '06:00 - 07:00',
            '07:00' => '07:00 - 08:00',
            '08:00' => '08:00 - 09:00',
            '09:00' => '09:00 - 10:00',
            '10:00' => '10:00 - 11:00',
            '11:00' => '11:00 - 12:00',
            '12:00' => '12:00 - 13:00',
            '13:00' => '13:00 - 14:00',
            '14:00' => '14:00 - 15:00',
            '15:00' => '15:00 - 16:00',
            '16:00' => '16:00 - 17:00',
            '17:00' => '17:00 - 18:00',
            '18:00' => '18:00 - 19:00',
            '19:00' => '19:00 - 20:00',
            '20:00' => '20:00 - 21:00',
            '21:00' => '21:00 - 22:00',
            '22:00' => '22:00 - 23:00'
        ];

        // Check which slots are already booked
        $bookedSlots = [];
        $existingBookings = $venue->bookings()
            ->where('booking_date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->get();

        foreach ($existingBookings as $booking) {
            if ($booking->selected_time_slots && is_array($booking->selected_time_slots)) {
                // If booking has selected_time_slots, use those
                $bookedSlots = array_merge($bookedSlots, $booking->selected_time_slots);
            } else {
                // Fallback to old logic for existing bookings
                $startTime = $booking->start_time instanceof \Carbon\Carbon 
                    ? $booking->start_time->format('H:i') 
                    : $booking->start_time;
                $endTime = $booking->end_time instanceof \Carbon\Carbon 
                    ? $booking->end_time->format('H:i') 
                    : $booking->end_time;
                
                // Generate all hourly slots between start and end time
                $current = \Carbon\Carbon::createFromFormat('H:i', $startTime);
                $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);
                
                while ($current < $end) {
                    $bookedSlots[] = $current->format('H:i');
                    $current->addHour();
                }
            }
        }

        // Remove duplicates
        $bookedSlots = array_unique($bookedSlots);

        // Check which slots are past current time (only for today)
        $pastSlots = [];
        if ($selectedDate === $today) {
            foreach ($timeSlots as $time => $label) {
                if ($time <= $currentTime) {
                    $pastSlots[] = $time;
                }
            }
        }

        $availableSlots = collect($timeSlots)->filter(function($slot, $time) use ($bookedSlots, $pastSlots) {
            return !in_array($time, $bookedSlots) && !in_array($time, $pastSlots);
        });

        // Get venue reviews/ratings (from bookings with ratings)
        $reviews = $venue->bookings()
            ->whereNotNull('rating')
            ->whereNotNull('review')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Calculate average rating
        $averageRating = $venue->bookings()
            ->whereNotNull('rating')
            ->avg('rating') ?? 0;

        // Update venue's rating field
        $venue->update([
            'rating' => $averageRating,
            'total_reviews' => $venue->bookings()->whereNotNull('rating')->count()
        ]);

        // Get similar venues
        $similarVenues = Venue::where('sport_id', $venue->sport_id)
            ->where('id', '!=', $venue->id)
            ->where('venues.is_active', true)
            ->take(3)
            ->get();

        return view('venue-detail', compact(
            'venue', 
            'user', 
            'availableSlots', 
            'timeSlots',
            'bookedSlots',
            'pastSlots',
            'currentTime',
            'today',
            'reviews', 
            'averageRating',
            'similarVenues'
        ));
    }

    public function getBookingData(Request $request, Venue $venue)
    {
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');
        
        $timeSlots = [
            '06:00' => '06:00 - 07:00',
            '07:00' => '07:00 - 08:00',
            '08:00' => '08:00 - 09:00',
            '09:00' => '09:00 - 10:00',
            '10:00' => '10:00 - 11:00',
            '11:00' => '11:00 - 12:00',
            '12:00' => '12:00 - 13:00',
            '13:00' => '13:00 - 14:00',
            '14:00' => '14:00 - 15:00',
            '15:00' => '15:00 - 16:00',
            '16:00' => '16:00 - 17:00',
            '17:00' => '17:00 - 18:00',
            '18:00' => '18:00 - 19:00',
            '19:00' => '19:00 - 20:00',
            '20:00' => '20:00 - 21:00',
            '21:00' => '21:00 - 22:00',
            '22:00' => '22:00 - 23:00'
        ];

        // Check which slots are already booked
        $bookedSlots = [];
        $existingBookings = $venue->bookings()
            ->where('booking_date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->get();

        foreach ($existingBookings as $booking) {
            if ($booking->selected_time_slots && is_array($booking->selected_time_slots)) {
                // If booking has selected_time_slots, use those
                $bookedSlots = array_merge($bookedSlots, $booking->selected_time_slots);
            } else {
                // Fallback to old logic for existing bookings
                $startTime = $booking->start_time instanceof \Carbon\Carbon 
                    ? $booking->start_time->format('H:i') 
                    : $booking->start_time;
                $endTime = $booking->end_time instanceof \Carbon\Carbon 
                    ? $booking->end_time->format('H:i') 
                    : $booking->end_time;
                
                // Generate all hourly slots between start and end time
                $current = \Carbon\Carbon::createFromFormat('H:i', $startTime);
                $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);
                
                while ($current < $end) {
                    $bookedSlots[] = $current->format('H:i');
                    $current->addHour();
                }
            }
        }

        // Remove duplicates
        $bookedSlots = array_unique($bookedSlots);

        // Check which slots are past current time (only for today)
        $pastSlots = [];
        if ($selectedDate === $today) {
            foreach ($timeSlots as $time => $label) {
                if ($time <= $currentTime) {
                    $pastSlots[] = $time;
                }
            }
        }

        return response()->json([
            'timeSlots' => $timeSlots,
            'bookedSlots' => $bookedSlots,
            'pastSlots' => $pastSlots,
            'selectedDate' => $selectedDate,
            'today' => $today,
            'currentTime' => $currentTime
        ]);
    }
}
