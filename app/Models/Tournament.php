<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sport_id',
        'organizer_id',
        'organizer_type',
        'venue_id',
        'location',
        'tournament_start',
        'tournament_end',
        'registration_start',
        'registration_end',
        'tournament_type',
        'max_participants',
        'current_participants',
        'entry_fee',
        'prize_pool',
        'skill_level',
        'status',
        'rules',
        'created_by',
        'is_public'
    ];

    protected $casts = [
        'tournament_start' => 'datetime',
        'tournament_end' => 'datetime',
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'entry_fee' => 'decimal:2',
        'prize_pool' => 'decimal:2'
    ];

    // Relationships
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'organizer_id'); // Same as organizer
    }

    public function participants()
    {
        return $this->hasMany(TournamentParticipant::class);
    }

    public function activeParticipants()
    {
        return $this->participants()->where('status', 'registered');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('tournament_start', '>=', Carbon::now())
                    ->whereIn('status', ['registration_open', 'registration_closed', 'upcoming']);
    }

    public function scopeRegistrationOpen($query)
    {
        return $query->where('registration_end', '>=', Carbon::now())
                    ->where('status', 'registration_open');
    }

    public function scopePublic($query)
    {
        return $query; // All tournaments are public in this structure
    }

    public function scopeBySport($query, $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    // Accessors
    public function getFormattedRegistrationDeadlineAttribute()
    {
        return $this->registration_end ? 
            $this->registration_end->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y H:i') : '';
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->tournament_start ? 
            $this->tournament_start->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y H:i') : '';
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->tournament_end ? 
            $this->tournament_end->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y H:i') : '';
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->max_participants - $this->current_participants;
    }

    public function getIsFullAttribute()
    {
        return $this->current_participants >= $this->max_participants;
    }

    public function getIsRegistrationOpenAttribute()
    {
        $now = Carbon::now();
        return $this->registration_end >= $now && 
               $this->status === 'registration_open' &&
               !$this->is_full;
    }

    public function getIsUpcomingAttribute()
    {
        return $this->tournament_start >= Carbon::now() && 
               in_array($this->status, ['registration_open', 'registration_closed', 'upcoming']);
    }

    // Methods
    public function canRegister(User $user)
    {
        if (!$this->is_registration_open) {
            return false;
        }

        // Check if user is already registered
        return !$this->participants()
            ->where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function registerParticipant(User $user)
    {
        if (!$this->canRegister($user)) {
            return false;
        }

        $this->participants()->create([
            'user_id' => $user->id,
            'status' => 'confirmed',
            'registered_at' => now()
        ]);

        $this->increment('current_participants');
        
        // Check if tournament is now full
        if ($this->current_participants >= $this->max_participants) {
            $this->update(['status' => 'registration_closed']);
        }
        
        return true;
    }

    public function unregisterParticipant(User $user)
    {
        $participant = $this->participants()
            ->where('user_id', $user->id)
            ->first();

        if ($participant) {
            $participant->update(['status' => 'cancelled']);
            $this->decrement('current_participants');
            
            // Reopen registration if was closed due to being full
            if ($this->status === 'registration_closed' && $this->is_registration_open) {
                $this->update(['status' => 'registration_open']);
            }
            
            return true;
        }

        return false;
    }
}
