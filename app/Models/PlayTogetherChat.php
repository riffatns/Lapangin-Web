<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogetherChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'play_together_id',
        'user_id',
        'message',
        'message_type',
        'attachments',
        'is_system_message',
        'read_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_system_message' => 'boolean',
        'read_at' => 'datetime'
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
    public function scopeText($query)
    {
        return $query->where('message_type', 'text');
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system_message', true);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getIsReadAttribute()
    {
        return $this->read_at !== null;
    }

    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    // Methods
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update(['read_at' => now()]);
        }
    }

    public static function createSystemMessage($playTogetherId, $message)
    {
        return static::create([
            'play_together_id' => $playTogetherId,
            'user_id' => null,
            'message' => $message,
            'message_type' => 'system',
            'is_system_message' => true
        ]);
    }
}
