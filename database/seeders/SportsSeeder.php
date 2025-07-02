<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sports = [
            [
                'name' => 'Badminton',
                'slug' => 'badminton',
                'icon' => '🏸',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga raket yang dimainkan menggunakan raket untuk memukul shuttlecock',
                'is_active' => true
            ],
            [
                'name' => 'Futsal',
                'slug' => 'futsal',
                'icon' => '⚽',
                'image' => 'img/Football-Anime.png',
                'description' => 'Permainan sepak bola yang dimainkan di lapangan indoor',
                'is_active' => true
            ],
            [
                'name' => 'Tennis',
                'slug' => 'tennis',
                'icon' => '🎾',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga raket yang dimainkan di lapangan tenis',
                'is_active' => true
            ],
            [
                'name' => 'Basketball',
                'slug' => 'basketball',
                'icon' => '🏀',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga beregu yang dimainkan menggunakan bola basket',
                'is_active' => true
            ],
            [
                'name' => 'Volleyball',
                'slug' => 'volleyball',
                'icon' => '🏐',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga beregu yang dimainkan dengan memukul bola melewati net',
                'is_active' => true
            ]
        ];

        foreach ($sports as $sport) {
            Sport::create($sport);
        }
    }
}
