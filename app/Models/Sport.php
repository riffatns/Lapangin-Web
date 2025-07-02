<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function venues()
    {
        return $this->hasMany(Venue::class);
    }

    public function communities()
    {
        return $this->hasMany(Community::class);
    }

    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class, 'favorite_sport', 'slug');
    }
}
