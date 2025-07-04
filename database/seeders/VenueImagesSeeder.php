<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venuesData = [
            [
                'name' => 'GOR Badminton Telyu',
                'main_image' => 'badminton-telyu-main.jpg',
                'gallery_images' => [
                    'badminton-telyu-thumb-1.jpg',
                    'badminton-telyu-thumb-2.jpg',
                    'badminton-telyu-thumb-3.jpg'
                ]
            ],
            [
                'name' => 'Futsal Indoor Arena',
                'main_image' => 'futsal-indoor-main.jpg',
                'gallery_images' => [
                    'futsal-indoor-thumb-1.jpg',
                    'futsal-indoor-thumb-2.jpg'
                ]
            ],
            [
                'name' => 'Tennis Outdoor Court',
                'main_image' => 'tennis-outdoor-main.jpg',
                'gallery_images' => [
                    'tennis-outdoor-thumb-1.jpg'
                ]
            ],
            [
                'name' => 'Basketball Court Telyu',
                'main_image' => 'basketball-court-main.jpg',
                'gallery_images' => [
                    'basketball-court-thumb-1.jpg'
                ]
            ],
            // Update venue lain dengan gambar yang sama dulu
            [
                'name' => 'GOR Badminton Citra Raya',
                'main_image' => 'badminton-telyu-main.jpg',
                'gallery_images' => [
                    'badminton-telyu-thumb-1.jpg',
                    'badminton-telyu-thumb-2.jpg'
                ]
            ],
            [
                'name' => 'Lapang Voli Telyu',
                'main_image' => 'basketball-court-main.jpg',
                'gallery_images' => [
                    'basketball-court-thumb-1.jpg'
                ]
            ],
        ];

        foreach ($venuesData as $data) {
            $venue = Venue::where('name', $data['name'])->first();
            if ($venue) {
                $venue->update([
                    'main_image' => $data['main_image'],
                    'gallery_images' => $data['gallery_images']
                ]);
                $this->command->info("Updated images for venue: {$venue->name}");
            } else {
                $this->command->warn("Venue not found: {$data['name']}");
            }
        }

        // Update venue yang tidak ada di list dengan gambar default
        $updatedVenues = collect($venuesData)->pluck('name');
        $remainingVenues = Venue::whereNotIn('name', $updatedVenues)->get();
        
        foreach ($remainingVenues as $venue) {
            $sportName = strtolower($venue->sport->name ?? 'default');
            $defaultImage = match($sportName) {
                'badminton' => 'badminton-telyu-main.jpg',
                'futsal' => 'futsal-indoor-main.jpg',
                'tennis' => 'tennis-outdoor-main.jpg',
                'basketball' => 'basketball-court-main.jpg',
                default => 'badminton-telyu-main.jpg'
            };
            
            $venue->update([
                'main_image' => $defaultImage,
                'gallery_images' => [$defaultImage]
            ]);
            $this->command->info("Updated default images for venue: {$venue->name}");
        }
    }
}
