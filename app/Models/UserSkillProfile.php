<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkillProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sport_id',
        'skill_level',
        'experience_years',
        'achievements',
        'video_portfolio',
        'bio',
        'average_rating',
        'total_matches',
        'verified',
        'verified_at'
    ];

    protected $casts = [
        'achievements' => 'array',
        'video_portfolio' => 'array',
        'average_rating' => 'decimal:2',
        'verified' => 'boolean',
        'verified_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function verifications()
    {
        return $this->hasMany(SkillVerification::class);
    }

    public function pendingVerifications()
    {
        return $this->verifications()->where('status', 'pending');
    }

    public function approvedVerifications()
    {
        return $this->verifications()->where('status', 'approved');
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeBySkillLevel($query, $level)
    {
        return $query->where('skill_level', $level);
    }

    public function scopeExperienced($query, $minYears = 2)
    {
        return $query->where('experience_years', '>=', $minYears);
    }

    // Accessors
    public function getSkillLevelLabelAttribute()
    {
        $labels = [
            'beginner' => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced' => 'Lanjutan',
            'expert' => 'Ahli'
        ];

        return $labels[$this->skill_level] ?? 'Tidak diketahui';
    }

    public function getVerificationStatusAttribute()
    {
        if ($this->verified) {
            return 'verified';
        }

        if ($this->pendingVerifications()->exists()) {
            return 'pending';
        }

        return 'unverified';
    }

    public function getTotalVideosAttribute()
    {
        return is_array($this->video_portfolio) ? count($this->video_portfolio) : 0;
    }

    public function getTotalAchievementsAttribute()
    {
        return is_array($this->achievements) ? count($this->achievements) : 0;
    }

    // Methods
    public function addVideo($videoUrl, $title = null, $description = null)
    {
        $videos = $this->video_portfolio ?? [];
        $videos[] = [
            'url' => $videoUrl,
            'title' => $title,
            'description' => $description,
            'uploaded_at' => now()->toDateTimeString()
        ];

        $this->update(['video_portfolio' => $videos]);
    }

    public function addAchievement($title, $description = null, $date = null, $certificate = null)
    {
        $achievements = $this->achievements ?? [];
        $achievements[] = [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'certificate' => $certificate,
            'added_at' => now()->toDateTimeString()
        ];

        $this->update(['achievements' => $achievements]);
    }

    public function updateRating($newRating)
    {
        $totalMatches = $this->total_matches;
        $currentAverage = $this->average_rating;

        // Calculate new average
        $newAverage = (($currentAverage * $totalMatches) + $newRating) / ($totalMatches + 1);

        $this->update([
            'average_rating' => round($newAverage, 2),
            'total_matches' => $totalMatches + 1
        ]);
    }

    public function markAsVerified()
    {
        $this->update([
            'verified' => true,
            'verified_at' => now()
        ]);
    }
}
