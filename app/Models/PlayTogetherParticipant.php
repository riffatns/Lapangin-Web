<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogetherParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'play_together_id',
        'user_id',
        'status',
        'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'datetime'
    ];

    // Relationships
    public function playTogether()
    {
        return $this->belongsTo(PlayTogether::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeJoined($query)
    {
        return $query->where('status', 'joined');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
