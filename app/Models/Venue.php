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

    /**
     * Get main image with fallback to first image in images array
     */
    public function getMainImageAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Fallback to first image in images array
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        
        // Default fallback image
        return 'default-venue.jpg';
    }

    /**
     * Get gallery images with safe array handling
     */
    public function getGalleryImagesAttribute($value)
    {
        // If value is null or empty, return empty array
        if (empty($value)) {
            return [];
        }

        // If it's already an array, return as is
        if (is_array($value)) {
            return $value;
        }

        // If it's a JSON string, decode it
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        // Fallback to empty array
        return [];
    }

    /**
     * Get images with safe array handling
     */
    public function getImagesAttribute($value)
    {
        // If value is null or empty, return empty array
        if (empty($value)) {
            return [];
        }

        // If it's already an array, return as is
        if (is_array($value)) {
            return $value;
        }

        // If it's a JSON string, decode it
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        // Fallback to empty array
        return [];
    }

    /**
     * Get facilities with safe array handling
     */
    public function getFacilitiesAttribute($value)
    {
        // If value is null or empty, return empty array
        if (empty($value)) {
            return [];
        }

        // If it's already an array, return as is
        if (is_array($value)) {
            return $value;
        }

        // If it's a JSON string, decode it
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        // Fallback to empty array
        return [];
    }

    /**
     * Get safe count for array properties
     */
    public function getGalleryImagesCountAttribute()
    {
        $images = $this->gallery_images;
        return is_array($images) ? count($images) : 0;
    }

    /**
     * Get safe count for images
     */
    public function getImagesCountAttribute()
    {
        $images = $this->images;
        return is_array($images) ? count($images) : 0;
    }

    /**
     * Get safe count for facilities
     */
    public function getFacilitiesCountAttribute()
    {
        $facilities = $this->facilities;
        return is_array($facilities) ? count($facilities) : 0;
    }
}
