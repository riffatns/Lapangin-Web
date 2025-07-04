<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venue;

class UpdateVenueRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'venue:update-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update venue ratings based on booking reviews';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating venue ratings...');
        
        $venues = Venue::all();
        $bar = $this->output->createProgressBar($venues->count());
        
        foreach ($venues as $venue) {
            $venue->updateRatingAndReviews();
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Venue ratings updated successfully!');
    }
}
