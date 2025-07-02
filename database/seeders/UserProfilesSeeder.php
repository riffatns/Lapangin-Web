<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample user if not exists
        $user = User::firstOrCreate(
            ['email' => 'nabil@lapangin.com'],
            [
                'name' => 'Nabil',
                'password' => Hash::make('password'),
                'phone' => '+62 812-3456-7890',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now()
            ]
        );

        // Create user profile
        UserProfile::create([
            'user_id' => $user->id,
            'phone' => '+62 812-3456-7890',
            'birthdate' => '1995-05-15',
            'city' => 'bandung',
            'district' => 'Coblong',
            'address' => 'Jl. Ganesha No. 10, Bandung',
            'favorite_sport' => 'badminton',
            'skill_level' => 'intermediate',
            'bio' => 'Seorang enthusiast badminton yang senang bermain dan berkompetisi. Aktif di komunitas olahraga Bandung.',
            'total_bookings' => 12,
            'total_points' => 1250,
            'ranking' => 25,
            'notification_preferences' => [
                'booking' => true,
                'community' => true,
                'promo' => false,
                'newsletter' => true
            ]
        ]);

        // Create additional sample users
        $sampleUsers = [
            [
                'name' => 'Ahmad Rivaldy',
                'email' => 'ahmad@example.com',
                'favorite_sport' => 'badminton',
                'skill_level' => 'advanced',
                'total_bookings' => 25,
                'total_points' => 2100,
                'ranking' => 8
            ],
            [
                'name' => 'Sari Dewi',
                'email' => 'sari@example.com',
                'favorite_sport' => 'tennis',
                'skill_level' => 'intermediate',
                'total_bookings' => 18,
                'total_points' => 1650,
                'ranking' => 15
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'favorite_sport' => 'futsal',
                'skill_level' => 'expert',
                'total_bookings' => 30,
                'total_points' => 2850,
                'ranking' => 3
            ]
        ];

        foreach ($sampleUsers as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'phone' => '+62 812-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now()
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'phone' => $user->phone,
                'city' => 'bandung',
                'favorite_sport' => $userData['favorite_sport'],
                'skill_level' => $userData['skill_level'],
                'bio' => 'Passionate sports enthusiast who loves playing ' . $userData['favorite_sport'],
                'total_bookings' => $userData['total_bookings'],
                'total_points' => $userData['total_points'],
                'ranking' => $userData['ranking'],
                'notification_preferences' => [
                    'booking' => true,
                    'community' => true,
                    'promo' => true,
                    'newsletter' => true
                ]
            ]);
        }
    }
}
