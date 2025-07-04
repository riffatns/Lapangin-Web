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
        'main_image',
        'gallery_images',
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
        'gallery_images' => 'array',
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

    /**
     * Update venue rating and review count based on bookings
     */
    public function updateRatingAndReviews()
    {
        $avgRating = $this->bookings()->whereNotNull('rating')->avg('rating') ?? 0;
        $totalReviews = $this->bookings()->whereNotNull('rating')->count();

        $this->update([
            'rating' => round($avgRating, 2),
            'total_reviews' => $totalReviews
        ]);

        return $this;
    }
}
