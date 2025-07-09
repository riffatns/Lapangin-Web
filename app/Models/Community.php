<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sport_id',
        'creator_id',
        'city',
        'image',
        'skill_level',
        'max_members',
        'is_private',
        'total_members',
        'total_points',
        'is_active'
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'community_members')
                    ->withPivot('role', 'joined_at', 'is_active')
                    ->withTimestamps();
    }

    public function communityMembers()
    {
        return $this->hasMany(CommunityMember::class);
    }

    // PlayTogether relationships
    public function organizedPlayTogethers()
    {
        return $this->morphMany(PlayTogether::class, 'organizer');
    }

    // Tournament relationships
    public function organizedTournaments()
    {
        return $this->morphMany(Tournament::class, 'organizer');
    }
}
