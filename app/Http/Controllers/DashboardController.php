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
}
