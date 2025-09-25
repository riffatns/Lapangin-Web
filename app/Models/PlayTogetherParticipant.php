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
        'approval_status',
        'join_message',
        'skill_match_score',
        'payment_due_date',
        'payment_completed',
        'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'payment_due_date' => 'datetime',
        'payment_completed' => 'boolean',
        'skill_match_score' => 'decimal:2'
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

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeAwaitingApproval($query)
    {
        return $query->where('approval_status', 'pending');
    }

    // Additional relationships
    public function payment()
    {
        return $this->hasOne(PlayTogetherPayment::class, 'user_id', 'user_id')
                    ->where('play_together_id', $this->play_together_id);
    }

    // Accessors
    public function getApprovalStatusLabelAttribute()
    {
        $labels = [
            'auto_approved' => 'Otomatis Diterima',
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak'
        ];

        return $labels[$this->approval_status] ?? 'Tidak diketahui';
    }

    public function getIsApprovedAttribute()
    {
        return in_array($this->approval_status, ['auto_approved', 'approved']);
    }

    public function getPaymentStatusAttribute()
    {
        if (!$this->playTogether->is_paid_event) {
            return 'not_required';
        }

        if ($this->payment_completed) {
            return 'completed';
        }

        if ($this->payment_due_date && $this->payment_due_date < now()) {
            return 'overdue';
        }

        return 'pending';
    }

    // Methods
    public function approve()
    {
        $this->update([
            'approval_status' => 'approved',
            'status' => 'joined'
        ]);

        // Create payment record if event is paid
        if ($this->playTogether->is_paid_event) {
            $this->createPaymentRecord();
        }

        // Send system message
        PlayTogetherChat::createSystemMessage(
            $this->play_together_id,
            "{$this->user->name} bergabung dengan event"
        );
    }

    public function reject($reason = null)
    {
        $this->update([
            'approval_status' => 'rejected',
            'status' => 'cancelled'
        ]);

        // Send system message
        PlayTogetherChat::createSystemMessage(
            $this->play_together_id,
            "Permohonan bergabung {$this->user->name} ditolak"
        );
    }

    public function createPaymentRecord()
    {
        if ($this->playTogether->is_paid_event) {
            $amountDue = $this->calculatePaymentAmount();
            
            PlayTogetherPayment::create([
                'play_together_id' => $this->play_together_id,
                'user_id' => $this->user_id,
                'amount_due' => $amountDue,
                'due_date' => $this->playTogether->scheduled_time->subHours(2), // 2 hours before event
                'status' => 'pending'
            ]);

            $this->update([
                'payment_due_date' => $this->playTogether->scheduled_time->subHours(2)
            ]);
        }
    }

    private function calculatePaymentAmount()
    {
        $playTogether = $this->playTogether;
        
        if ($playTogether->payment_method === 'split_equal') {
            return $playTogether->total_cost / $playTogether->max_participants;
        }
        
        return $playTogether->price_per_person;
    }
}
