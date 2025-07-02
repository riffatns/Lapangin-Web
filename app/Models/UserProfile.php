<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'birthdate',
        'city',
        'district',
        'address',
        'avatar',
        'favorite_sport',
        'skill_level',
        'bio',
        'total_bookings',
        'total_points',
        'ranking',
        'notification_preferences'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'notification_preferences' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteSport()
    {
        return $this->belongsTo(Sport::class, 'favorite_sport', 'slug');
    }
}
