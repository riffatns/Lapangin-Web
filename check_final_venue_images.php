<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Venue;
use App\Models\Sport;

echo "=== Final Venue Image Summary by Sport ===\n\n";

$sports = Sport::with(['venues' => function($query) {
    $query->select('id', 'name', 'sport_id', 'main_image');
}])->get();

foreach ($sports as $sport) {
    if ($sport->venues->count() > 0) {
        echo "🏆 {$sport->name} ({$sport->venues->count()} venues):\n";
        $firstVenue = $sport->venues->first();
        echo "   Image: {$firstVenue->main_image}\n";
        
        // Check if all venues have the same image
        $allSame = $sport->venues->every(function($venue) use ($firstVenue) {
            return $venue->main_image === $firstVenue->main_image;
        });
        
        if ($allSame) {
            echo "   ✅ All venues use consistent image\n";
        } else {
            echo "   ⚠️  Inconsistent images found:\n";
            foreach ($sport->venues as $venue) {
                echo "      - {$venue->name}: {$venue->main_image}\n";
            }
        }
        echo "\n";
    }
}

echo "=== Image Assignment Summary ===\n";
echo "- Badminton: https://images.unsplash.com/photo-1626224583764-f87db24ac4ea (badminton court)\n";
echo "- Futsal: https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d (futsal field)\n";
echo "- Tennis: https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0 (tennis court)\n";
echo "- Basketball: https://images.unsplash.com/photo-1608245449230-4ac19066d2d0 (basketball court)\n";
echo "- Volleyball: https://images.unsplash.com/photo-1594736797933-d0c3668a9c78 (volleyball)\n";
echo "- Mini Soccer: https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9 (mini soccer)\n";
echo "- Table Tennis: https://images.unsplash.com/photo-1534158914592-062992fbe900 (table tennis)\n";
echo "- Golf: https://images.unsplash.com/photo-1535131749006-b7f58c99034b (golf course)\n";
echo "- Swimming: Various swimming-related images\n";
echo "- Boxing: https://images.unsplash.com/photo-1549719386-74dfcbf7dbed (boxing gym)\n";
