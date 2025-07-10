<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('profile');
        $profile = $user->profile;
        
        // Get user statistics
        $totalBookings = $user->bookings()->count();
        $totalCommunities = $user->activeCommunities()->count();
        $totalPoints = $profile && $profile->total_points !== null ? $profile->total_points : 0;
        
        // Calculate user ranking (simple implementation based on points)
        // Ensure $totalPoints is not null before using in query
        $usersWithHigherPoints = \App\Models\UserProfile::where('total_points', '>', $totalPoints)->count();
        $ranking = $usersWithHigherPoints + 1;
        
        return view('profile', compact('user', 'profile', 'totalBookings', 'totalCommunities', 'totalPoints', 'ranking'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'favorite_sport' => 'nullable|string',
            'skill_level' => 'nullable|string',
        ]);
        
        $user = Auth::user()->load('profile');
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        // Update or create user profile
        $profileData = [
            'birthdate' => $request->birthdate,
            'city' => $request->city,
            'district' => $request->district,
            'address' => $request->address,
            'bio' => $request->bio,
            'favorite_sport' => $request->favorite_sport,
            'skill_level' => $request->skill_level,
        ];
        
        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }
        
        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
    }
}
