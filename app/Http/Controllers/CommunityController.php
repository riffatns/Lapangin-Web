<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\Sport;
use App\Models\CommunityMember;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\PlayTogether;
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user's active communities using the new relationship
        $userCommunities = $user->activeCommunities()
            ->with('sport', 'creator')
            ->get();

        // Get popular communities user is not in
        $userCommunityIds = $userCommunities->pluck('id')->toArray();
        $popularCommunities = Community::with('sport', 'creator')
            ->where('communities.is_active', true)
            ->where('is_private', false)
            ->whereNotIn('id', $userCommunityIds)
            ->orderBy('total_members', 'desc')
            ->take(6)
            ->get();

        // Get sports for filter
        $sports = Sport::where('sports.is_active', true)->get();

        // Top ranking communities
        $topCommunities = Community::with('sport', 'creator')
            ->where('communities.is_active', true)
            ->where('is_private', false)
            ->orderBy('total_points', 'desc')
            ->take(10)
            ->get();

        // For the main communities grid, let's use all available communities
        $communities = Community::with('sport', 'creator')
            ->where('communities.is_active', true)
            ->withCount(['members' => function ($query) {
                $query->where('community_members.is_active', 1);
            }])
            ->get();

        // Add is_member flag to communities
        $communities = $communities->map(function($community) use ($userCommunityIds) {
            $community->is_member = in_array($community->id, $userCommunityIds);
            return $community;
        });

        // Get user stats for stats overview
        $userProfile = $user->profile;
        $userPoints = $userProfile ? $userProfile->total_points : 0;
        $userStats = [
            'total_communities' => $userCommunities->count(),
            'total_points' => $userPoints,
            'total_matches' => $user->bookings()->where('status', 'completed')->count(),
            'ranking' => UserProfile::where('total_points', '>', $userPoints)->count() + 1
        ];

        // Get top players for ranking section - Use UserProfile model directly
        $topPlayers = UserProfile::with('user')
            ->whereHas('user', function($query) {
                $query->where('is_active', true);
            })
            ->where('total_points', '>', 0)
            ->orderBy('total_points', 'desc')
            ->limit(5)
            ->get()
            ->map(function($profile) {
                return (object)[
                    'name' => $profile->user->name,
                    'total_points' => $profile->total_points,
                    'favorite_sport' => $profile->favorite_sport
                ];
            });

        // Get PlayTogether sessions for "Main Bareng" tab
        $playTogethers = PlayTogether::with(['sport', 'venue'])
            ->where('status', 'open')
            ->where('scheduled_time', '>', now())
            ->orderBy('scheduled_time', 'asc')
            ->limit(12)
            ->get()
            ->map(function($playTogether) use ($user) {
                // For the legacy table structure, check participation differently
                $playTogether->is_participant = false; // Will implement later with proper participant tracking
                $playTogether->is_full = $playTogether->current_participants >= $playTogether->max_participants;
                $playTogether->formatted_scheduled_date = $playTogether->scheduled_time->format('d M Y');
                $playTogether->formatted_scheduled_time = $playTogether->scheduled_time->format('H:i');
                $playTogether->skill_level = ucfirst($playTogether->skill_level ?? 'all levels');
                
                // Add organizer info (since the legacy structure uses polymorphic relation)
                $playTogether->organizer = $playTogether->organizer_type === 'App\\Models\\User' 
                    ? \App\Models\User::find($playTogether->organizer_id) 
                    : null;
                
                // Add some additional fields for display
                $playTogether->requires_approval = false; // Legacy doesn't have this
                $playTogether->is_paid_event = $playTogether->price_per_person > 0;
                $playTogether->payment_method = 'per_person';
                $playTogether->duration_hours = 2; // Default 2 hours
                $playTogether->notes = null;
                
                return $playTogether;
            });

        // Get Tournaments for "Tournament" tab
        $tournaments = Tournament::with(['sport', 'creator'])
            ->upcoming()
            ->public()
            ->orderBy('registration_end', 'asc')
            ->get()
            ->map(function($tournament) use ($user) {
                $tournament->is_participant = $tournament->participants()
                    ->where('user_id', $user->id)
                    ->where('status', 'registered')
                    ->exists();
                return $tournament;
            });

        return view('komunitas', compact(
            'userCommunities',
            'popularCommunities', 
            'sports',
            'topCommunities',
            'communities',
            'user',
            'userStats',
            'topPlayers',
            'playTogethers',
            'tournaments'
        ));
    }

    public function join(Community $community)
    {
        $user = Auth::user();

        // Check if user is already a member
        $existingMember = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingMember) {
            return redirect()->back()->with('error', 'Anda sudah menjadi member komunitas ini');
        }

        // Check if community is full
        if ($community->max_members && $community->total_members >= $community->max_members) {
            return redirect()->back()->with('error', 'Komunitas sudah penuh');
        }

        // Add user to community
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => $user->id,
            'role' => 'member',
            'joined_at' => now(),
            'is_active' => true
        ]);

        // Update community member count
        $community->increment('total_members');

        return redirect()->back()->with('success', 'Berhasil bergabung dengan komunitas ' . $community->name);
    }

    public function leave(Community $community)
    {
        $user = Auth::user();

        $member = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Anda bukan member komunitas ini');
        }

        if ($member->role === 'admin' && $community->creator_id === $user->id) {
            return redirect()->back()->with('error', 'Creator tidak dapat keluar dari komunitas');
        }

        $member->delete();
        $community->decrement('total_members');

        return redirect()->back()->with('success', 'Berhasil keluar dari komunitas ' . $community->name);
    }

    // PlayTogether methods (using legacy table structure)
    public function joinPlayTogether(PlayTogether $playTogether)
    {
        $user = Auth::user();

        // Check if event is still open and future
        if ($playTogether->status !== 'open' || $playTogether->scheduled_time <= now()) {
            return redirect()->back()->with('error', 'Event tidak tersedia untuk bergabung.');
        }

        // Check if event is full
        if ($playTogether->current_participants >= $playTogether->max_participants) {
            return redirect()->back()->with('error', 'Event sudah penuh.');
        }

        // Check if organizer
        if ($playTogether->organizer_id === $user->id && $playTogether->organizer_type === 'App\\Models\\User') {
            return redirect()->back()->with('error', 'Anda adalah organizer event ini.');
        }

        // For legacy system, we'll just increment current_participants
        // In a real implementation, you'd want to have a proper participants table
        $playTogether->increment('current_participants');

        return redirect()->back()->with('success', 'Berhasil bergabung dalam event: ' . $playTogether->title);
    }

    public function leavePlayTogether(PlayTogether $playTogether)
    {
        $user = Auth::user();

        // Check if organizer
        if ($playTogether->organizer_id === $user->id && $playTogether->organizer_type === 'App\\Models\\User') {
            return redirect()->back()->with('error', 'Organizer tidak bisa keluar dari event. Batalkan event jika diperlukan.');
        }

        // For legacy system, just decrement if there are participants
        if ($playTogether->current_participants > 0) {
            $playTogether->decrement('current_participants');
            return redirect()->back()->with('success', 'Berhasil keluar dari event: ' . $playTogether->title);
        }

        return redirect()->back()->with('error', 'Tidak dapat keluar dari event ini.');
    }

    // Tournament methods
    public function registerTournament(Tournament $tournament)
    {
        $user = Auth::user();

        if (!$tournament->canRegister($user)) {
            return redirect()->back()->with('error', 'Tidak dapat mendaftar turnamen ini');
        }

        if ($tournament->registerParticipant($user)) {
            return redirect()->back()->with('success', 'Berhasil mendaftar turnamen: ' . $tournament->title);
        }

        return redirect()->back()->with('error', 'Gagal mendaftar turnamen');
    }

    public function unregisterTournament(Tournament $tournament)
    {
        $user = Auth::user();

        if ($tournament->unregisterParticipant($user)) {
            return redirect()->back()->with('success', 'Berhasil batal dari turnamen: ' . $tournament->title);
        }

        return redirect()->back()->with('error', 'Gagal batal dari turnamen');
    }
}


