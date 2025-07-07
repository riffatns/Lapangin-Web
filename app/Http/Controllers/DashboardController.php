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
    public function index(Request $request)
    {
        $user = Auth::user()->load('profile');
        $userProfile = $user->profile;

        // Get filter parameters
        $sportFilter = $request->get('sport', 'all');
        $locationFilter = $request->get('location', 'all');
        $distanceFilter = $request->get('distance', 'all');
        $search = $request->get('search');

        // Base query for venues
        $venuesQuery = Venue::with('sport')
            ->where('venues.is_active', true);

        // Apply sport filter
        if ($sportFilter !== 'all') {
            if ($sportFilter === 'other-sports') {
                // Show sports that are not in the main tabs (sort_order > 4)
                $venuesQuery->whereHas('sport', function($query) {
                    $query->where('sort_order', '>', 4);
                });
            } else {
                $venuesQuery->whereHas('sport', function($query) use ($sportFilter) {
                    $query->where('slug', $sportFilter);
                });
            }
        }

        // Apply location filter
        if ($locationFilter !== 'all') {
            $venuesQuery->where('city', 'like', '%' . $locationFilter . '%');
        }

        // Apply search filter
        if ($search) {
            $venuesQuery->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('location', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Base ordering - start with rating and reviews
        $venues = $venuesQuery->orderBy('rating', 'desc')
            ->orderBy('total_reviews', 'desc');

        // Apply distance filter with improved logic
        if ($distanceFilter !== 'all') {
            switch ($distanceFilter) {
                case 'nearby':
                    // Premium venues with high ratings and good reviews (simulating nearby popular places)
                    $venues = $venues->where('rating', '>=', 4.5)
                                   ->where('total_reviews', '>=', 20);
                    break;
                case 'medium':
                    // Good venues that are accessible
                    $venues = $venues->where('rating', '>=', 4.0)
                                   ->where('rating', '<', 4.5);
                    break;
                case 'far':
                    // All venues including budget-friendly options
                    $venues = $venues->orderBy('price_per_hour', 'asc');
                    break;
            }
        }

        // Get total count before applying limits
        $totalCount = $venues->count();
        
        // Show more venues on dashboard, with some randomization for variety
        $showCount = min(18, $totalCount); // Show up to 18 venues
        
        // Add some randomization when no specific filters are applied
        if ($sportFilter === 'all' && $locationFilter === 'all' && $distanceFilter === 'all' && !$search) {
            // Occasionally shuffle results to show variety (30% chance)
            $shouldShuffle = rand(1, 100) <= 30;
            
            if ($shouldShuffle && $totalCount > $showCount) {
                // Get random venues for variety
                $venues = $venues->inRandomOrder()->take($showCount)->get();
            } else {
                // Show top rated venues
                $venues = $venues->take($showCount)->get();
            }
        } else {
            // When filters are applied, show relevant results
            $venues = $venues->take($showCount)->get();
        }

        // Get sports for filter - only show main sports (sort_order <= 4) as individual tabs
        $mainSports = Sport::where('is_active', true)
            ->where('sort_order', '<=', 4)
            ->orderBy('sort_order')
            ->get();

        // Check if there are any "other sports" (sort_order > 4)
        $hasOtherSports = Sport::where('is_active', true)
            ->where('sort_order', '>', 4)
            ->exists();

        // Get unique cities for location filter
        $cities = Venue::select('city')
            ->where('is_active', true)
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        // Get active filters for summary
        $activeFilters = [];
        if ($sportFilter !== 'all') {
            if ($sportFilter === 'other-sports') {
                $activeFilters[] = ['type' => 'sport', 'value' => $sportFilter, 'label' => 'Other Sports'];
            } else {
                $sport = Sport::where('slug', $sportFilter)->first();
                $activeFilters[] = ['type' => 'sport', 'value' => $sportFilter, 'label' => $sport ? $sport->name : $sportFilter];
            }
        }
        if ($locationFilter !== 'all') {
            $activeFilters[] = ['type' => 'location', 'value' => $locationFilter, 'label' => $locationFilter];
        }
        if ($distanceFilter !== 'all') {
            $distanceLabels = [
                'nearby' => 'Premium & Terdekat',
                'medium' => 'Jarak Menengah',
                'far' => 'Budget Friendly'
            ];
            $activeFilters[] = ['type' => 'distance', 'value' => $distanceFilter, 'label' => $distanceLabels[$distanceFilter]];
        }
        if ($search) {
            $activeFilters[] = ['type' => 'search', 'value' => $search, 'label' => 'Search: "' . $search . '"'];
        }

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
            'mainSports',
            'hasOtherSports',
            'cities',
            'popularCommunities', 
            'recentBookings',
            'stats',
            'user',
            'sportFilter',
            'locationFilter',
            'distanceFilter',
            'search',
            'activeFilters'
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

        // Use venue's stored rating (already calculated and stored by seeder)
        $averageRating = $venue->rating ?? 0;

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
