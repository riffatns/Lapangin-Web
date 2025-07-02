<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sport_id',
        'description',
        'location',
        'city',
        'address',
        'phone',
        'price_per_hour',
        'images',
        'facilities',
        'open_time',
        'close_time',
        'rating',
        'total_reviews',
        'is_active'
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'rating' => 'decimal:2',
        'images' => 'array',
        'facilities' => 'array',
        'is_active' => 'boolean',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i'
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
