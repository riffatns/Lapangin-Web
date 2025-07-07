<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\Sport;
use App\Models\User;

class CommunitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badmintonId = Sport::where('slug', 'badminton')->first()->id;
        $futsalId = Sport::where('slug', 'futsal')->first()->id;
        $tennisId = Sport::where('slug', 'tennis')->first()->id;

        $creator = User::where('email', 'nabil@lapangin.com')->first();
        $ahmad = User::where('email', 'ahmad@example.com')->first();
        $sari = User::where('email', 'sari@example.com')->first();

        $communities = [
            [
                'name' => 'Badminton Club Bandung',
                'slug' => 'badminton-club-bandung',
                'description' => 'Komunitas badminton untuk para pecinta olahraga raket di Bandung. Kami mengadakan latihan rutin setiap minggu dan turnamen bulanan.',
                'sport_id' => $badmintonId,
                'creator_id' => $ahmad->id,
                'city' => 'bandung',
                'skill_level' => 'all',
                'max_members' => 50,
                'is_private' => false,
                'total_members' => 15,
                'total_points' => 2500,
                'is_active' => true
            ],
            [
                'name' => 'Tennis Enthusiasts Bandung',
                'slug' => 'tennis-enthusiasts-bandung',
                'description' => 'Komunitas tennis untuk pemain level menengah hingga mahir. Focus pada improvement teknik dan kompetisi friendly.',
                'sport_id' => $tennisId,
                'creator_id' => $sari->id,
                'city' => 'bandung',
                'skill_level' => 'intermediate',
                'max_members' => 30,
                'is_private' => false,
                'total_members' => 12,
                'total_points' => 1800,
                'is_active' => true
            ],
            [
                'name' => 'Futsal Weekend Warriors',
                'slug' => 'futsal-weekend-warriors',
                'description' => 'Komunitas futsal yang aktif di weekend. Cocok untuk yang ingin bermain futsal sambil bersosialisasi.',
                'sport_id' => $futsalId,
                'creator_id' => $creator->id,
                'city' => 'bandung',
                'skill_level' => 'all',
                'max_members' => 25,
                'is_private' => false,
                'total_members' => 8,
                'total_points' => 1200,
                'is_active' => true
            ]
        ];

        foreach ($communities as $communityData) {
            $community = Community::updateOrCreate(
                ['slug' => $communityData['slug']], // Find by slug
                $communityData // Update or create with this data
            );

            // Add creator as admin if not already exists
            CommunityMember::updateOrCreate(
                [
                    'community_id' => $community->id,
                    'user_id' => $community->creator_id
                ],
                [
                    'role' => 'admin',
                    'joined_at' => now(),
                    'is_active' => true
                ]
            );

            // Add some sample members
            $sampleMembers = User::where('id', '!=', $community->creator_id)->take(3)->get();
            foreach ($sampleMembers as $member) {
                CommunityMember::updateOrCreate(
                    [
                        'community_id' => $community->id,
                        'user_id' => $member->id
                    ],
                    [
                        'role' => 'member',
                        'joined_at' => now()->subDays(rand(1, 30)),
                        'is_active' => true
                    ]
                );
            }
        }
    }
}
