<?php
// filepath: app/Models/User.php
// This file defines the User model for the application, which represents users in the system.
// It includes properties for user attributes, such as name, email, password, phone, role, and is_active status.
// The model uses Laravel's Eloquent ORM features for database interactions, including
// mass assignment protection, hidden attributes, and type casting for certain fields.      

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function createdCommunities()
    {
        return $this->hasMany(Community::class, 'creator_id');
    }

    public function communities()
    {
        return $this->belongsToMany(Community::class, 'community_members')
                    ->withPivot('role', 'joined_at', 'is_active')
                    ->withTimestamps();
    }

    public function activeCommunities()
    {
        return $this->belongsToMany(Community::class, 'community_members')
                    ->withPivot('role', 'joined_at', 'is_active')
                    ->wherePivot('community_members.is_active', 1)
                    ->where('communities.is_active', 1)
                    ->withTimestamps();
    }

    public function communityMemberships()
    {
        return $this->hasMany(CommunityMember::class);
    }

    // Helper methods
    public function getTotalBookingsAttribute()
    {
        return $this->profile ? $this->profile->total_bookings : 0;
    }

    public function getTotalPointsAttribute()
    {
        return $this->profile ? $this->profile->total_points : 0;
    }

    public function getRankingAttribute()
    {
        return $this->profile ? $this->profile->ranking : null;
    }
}