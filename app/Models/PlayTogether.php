<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PlayTogether extends Model
{
    use HasFactory;

    protected $table = 'play_togethers';

    protected $fillable = [
        'title',
        'description',
        'organizer_id',
        'organizer_type',
        'sport_id',
        'venue_id',
        'venue_partner',
        'venue_notes',
        'scheduled_date',
        'scheduled_time',
        'duration_minutes',
        'registration_deadline',
        'max_participants',
        'current_participants',
        'skill_level',
        'skill_requirements',
        'auto_approve',
        'location',
        'price_per_person',
        'is_paid_event',
        'total_cost',
        'payment_method',
        'payment_required_upfront',
        'chat_enabled',
        'communication_settings',
        'additional_info',
        'rules_and_terms',
        'status',
        'is_public',
        'created_by'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'datetime',
        'registration_deadline' => 'datetime',
        'price_per_person' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'skill_requirements' => 'array',
        'communication_settings' => 'array',
        'additional_info' => 'array',
        'venue_partner' => 'boolean',
        'is_paid_event' => 'boolean',
        'payment_required_upfront' => 'boolean',
        'chat_enabled' => 'boolean',
        'auto_approve' => 'boolean',
        'is_public' => 'boolean'
    ];

    // Relationships
    public function organizer()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function participants()
    {
        return $this->hasMany(PlayTogetherParticipant::class);
    }

    public function activeParticipants()
    {
        return $this->participants()->where('status', 'joined');
    }

    public function pendingParticipants()
    {
        return $this->participants()->where('approval_status', 'pending');
    }

    public function payments()
    {
        return $this->hasMany(PlayTogetherPayment::class);
    }

    public function chats()
    {
        return $this->hasMany(PlayTogetherChat::class);
    }

    public function recentChats()
    {
        return $this->chats()->orderBy('created_at', 'desc');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_time', '>=', Carbon::now())
                    ->where('status', 'open');
    }

    public function scopePublic($query)
    {
        return $query; // All are public in this table structure
    }

    public function scopeBySport($query, $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    // Accessors
    public function getFormattedScheduledTimeAttribute()
    {
        return $this->scheduled_time ? 
            $this->scheduled_time->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('H:i') : '';
    }

    public function getFormattedScheduledDateAttribute()
    {
        return $this->scheduled_time ? 
            $this->scheduled_time->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y') : '';
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->max_participants - $this->current_participants;
    }

    public function getIsFullAttribute()
    {
        return $this->current_participants >= $this->max_participants;
    }

    public function getIsUpcomingAttribute()
    {
        return $this->scheduled_time >= Carbon::now() && $this->status === 'open';
    }

    // Methods
    public function canJoin(User $user)
    {
        if ($this->is_full || !$this->is_upcoming) {
            return false;
        }

        // Check if user is already a participant
        return !$this->participants()
            ->where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function addParticipant(User $user)
    {
        if (!$this->canJoin($user)) {
            return false;
        }

        $this->participants()->create([
            'user_id' => $user->id,
            'status' => 'joined',
            'joined_at' => now()
        ]);

        $this->increment('current_participants');
        
        return true;
    }

    public function removeParticipant(User $user)
    {
        $participant = $this->participants()
            ->where('user_id', $user->id)
            ->first();

        if ($participant) {
            $participant->update(['status' => 'cancelled']);
            $this->decrement('current_participants');
            return true;
        }

        return false;
    }
}
