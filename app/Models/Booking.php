<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'venue_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'status',
        'payment_status',
        'notes',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
        'rating',
        'review',
        'selected_time_slots'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'selected_time_slots' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
