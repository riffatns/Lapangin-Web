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
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Futsal',
                'slug' => 'futsal',
                'icon' => '⚽',
                'image' => 'img/Football-Anime.png',
                'description' => 'Permainan sepak bola yang dimainkan di lapangan indoor',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Tennis',
                'slug' => 'tennis',
                'icon' => '🎾',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga raket yang dimainkan di lapangan tenis',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Mini Soccer',
                'slug' => 'mini-soccer',
                'icon' => '⚽',
                'image' => 'img/Football-Anime.png',
                'description' => 'Permainan sepak bola mini untuk anak-anak',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Basketball',
                'slug' => 'basketball',
                'icon' => '🏀',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga beregu yang dimainkan menggunakan bola basket',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Volleyball',
                'slug' => 'volleyball',
                'icon' => '🏐',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga beregu yang dimainkan dengan memukul bola melewati net',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Table Tennis',
                'slug' => 'table-tennis',
                'icon' => '🏓',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga tenis meja yang dimainkan di atas meja',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Swimming',
                'slug' => 'swimming',
                'icon' => '🏊',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga renang di kolam',
                'sort_order' => 8,
                'is_active' => true
            ],
            [
                'name' => 'Golf',
                'slug' => 'golf',
                'icon' => '⛳',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga golf dengan berbagai fasilitas',
                'sort_order' => 9,
                'is_active' => true
            ],
            [
                'name' => 'Boxing',
                'slug' => 'boxing',
                'icon' => '🥊',
                'image' => 'img/Basketball-Anime.png',
                'description' => 'Olahraga tinju dan martial arts',
                'sort_order' => 10,
                'is_active' => true
            ]
        ];

        foreach ($sports as $sport) {
            Sport::updateOrCreate(
                ['slug' => $sport['slug']], // Find by slug
                $sport // Update or create with this data
            );
        }
    }
}
