<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogetherPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'play_together_id',
        'user_id',
        'amount_due',
        'amount_paid',
        'status',
        'payment_method',
        'payment_reference',
        'paid_at',
        'due_date'
    ];

    protected $casts = [
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
        'due_date' => 'datetime'
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
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                    ->where('due_date', '<', now());
    }

    // Accessors
    public function getRemainingAmountAttribute()
    {
        return $this->amount_due - $this->amount_paid;
    }

    public function getIsFullyPaidAttribute()
    {
        return $this->amount_paid >= $this->amount_due;
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'pending' && $this->due_date && $this->due_date < now();
    }

    // Methods
    public function markAsPaid($paymentMethod = null, $reference = null)
    {
        $this->update([
            'status' => 'paid',
            'amount_paid' => $this->amount_due,
            'payment_method' => $paymentMethod,
            'payment_reference' => $reference,
            'paid_at' => now()
        ]);
    }
}
