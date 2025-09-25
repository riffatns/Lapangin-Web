<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_skill_profile_id',
        'submitted_by',
        'verification_type',
        'verification_data',
        'status',
        'reviewer_notes',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'verification_data' => 'array',
        'reviewed_at' => 'datetime'
    ];

    // Relationships
    public function skillProfile()
    {
        return $this->belongsTo(UserSkillProfile::class, 'user_skill_profile_id');
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('verification_type', $type);
    }

    // Accessors
    public function getVerificationTypeLabelAttribute()
    {
        $labels = [
            'video' => 'Video Portfolio',
            'achievement' => 'Prestasi/Sertifikat',
            'peer_review' => 'Review Sesama Pemain',
            'admin_review' => 'Review Admin'
        ];

        return $labels[$this->verification_type] ?? 'Tidak diketahui';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak'
        ];

        return $labels[$this->status] ?? 'Tidak diketahui';
    }

    public function getVideoUrlAttribute()
    {
        if ($this->verification_type === 'video' && is_array($this->verification_data)) {
            return $this->verification_data['video_url'] ?? null;
        }
        return null;
    }

    public function getAchievementTitleAttribute()
    {
        if ($this->verification_type === 'achievement' && is_array($this->verification_data)) {
            return $this->verification_data['title'] ?? null;
        }
        return null;
    }

    // Methods
    public function approve($reviewerId, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_by' => $reviewerId,
            'reviewer_notes' => $notes,
            'reviewed_at' => now()
        ]);

        // Mark skill profile as verified if this was a critical verification
        if ($this->verification_type === 'video' || $this->verification_type === 'admin_review') {
            $this->skillProfile->markAsVerified();
        }
    }

    public function reject($reviewerId, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewerId,
            'reviewer_notes' => $notes,
            'reviewed_at' => now()
        ]);
    }
}
