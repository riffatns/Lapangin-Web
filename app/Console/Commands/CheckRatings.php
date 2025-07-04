<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venue;

class CheckRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratings:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check venue ratings synchronization';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Checking Venue Ratings ===');
        $this->newLine();

        $venues = Venue::with('bookings')->get();

        $headers = ['Venue Name', 'DB Rating', 'DB Reviews', 'Calculated Rating', 'Calculated Reviews', 'Status'];
        $rows = [];

        foreach($venues as $venue) {
            $avgRating = $venue->bookings()->whereNotNull('rating')->avg('rating');
            $totalReviews = $venue->bookings()->whereNotNull('rating')->count();
            
            $calculatedRating = $avgRating ? round($avgRating, 2) : 0;
            $status = ($venue->rating == $calculatedRating && $venue->total_reviews == $totalReviews) ? '✅ SYNCED' : '❌ NOT SYNCED';
            
            $rows[] = [
                $venue->name,
                $venue->rating ?? '0',
                $venue->total_reviews ?? '0', 
                $calculatedRating,
                $totalReviews,
                $status
            ];
        }

        $this->table($headers, $rows);
        
        $syncedCount = collect($rows)->where(5, '✅ SYNCED')->count();
        $totalCount = count($rows);
        
        $this->newLine();
        $this->info("Summary: {$syncedCount}/{$totalCount} venues are synced");
        
        return 0;
    }
}
