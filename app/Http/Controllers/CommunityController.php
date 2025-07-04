<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\Sport;
use App\Models\CommunityMember;
use App\Models\User;
use App\Models\UserProfile;
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

        return view('komunitas', compact(
            'userCommunities',
            'popularCommunities', 
            'sports',
            'topCommunities',
            'communities',
            'user',
            'userStats',
            'topPlayers'
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
}


