<?php
// Web container migration script
echo "=== Web Container Migration Script ===\n";

// Set working directory
chdir(__DIR__ . '/..');

try {
    // Initialize Laravel
    require_once 'vendor/autoload.php';
    
    $app = require_once 'bootstrap/app.php';
    
    // Boot the application
    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
    $kernel->bootstrap();
    
    echo "✅ Laravel application booted successfully!\n";
    
    echo "1. Testing database connection...\n";
    
    $db = $app->make('db');
    $pdo = $db->connection()->getPdo();
    
    echo "✅ Database connection successful!\n";
    
    echo "2. Checking current tables...\n";
    $tables = $db->select("SHOW TABLES");
    echo "Current tables: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            echo "  - $tableName\n";
        }
    }
    
    echo "3. Running FRESH migration (drop all tables)...\n";
    
    // Run migration command
    $consoleKernel = $app->make('Illuminate\Contracts\Console\Kernel');
    $consoleKernel->bootstrap();
    
    $exitCode = $consoleKernel->call('migrate:fresh', [
        '--force' => true,
        '--verbose' => true
    ]);
    
    echo "Fresh migration exit code: $exitCode\n";
    echo "Fresh migration output:\n";
    echo $consoleKernel->output() . "\n";
    
    echo "4. Checking tables after fresh migration...\n";
    $tables = $db->select("SHOW TABLES");
    echo "Tables after fresh migration: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            echo "  - $tableName\n";
        }
        
        echo "5. Running database seed with fresh data...\n";
        $exitCode = $consoleKernel->call('db:seed', [
            '--force' => true,
            '--verbose' => true
        ]);
        
        echo "Seed exit code: $exitCode\n";
        echo "Seed output:\n";
        echo $consoleKernel->output() . "\n";
        
        echo "6. Final table count check...\n";
        $tables = $db->select("SHOW TABLES");
        echo "Final tables: " . count($tables) . "\n";
        
        // Check specific tables
        $importantTables = ['users', 'venues', 'bookings', 'communities', 'play_togethers', 'tournaments'];
        foreach ($importantTables as $tableName) {
            $found = false;
            foreach ($tables as $table) {
                if (array_values((array) $table)[0] === $tableName) {
                    $found = true;
                    break;
                }
            }
            echo "  - $tableName: " . ($found ? "✅ EXISTS" : "❌ MISSING") . "\n";
        }
        
        echo "✅ Fresh migration and seeding completed!\n";
    } else {
        echo "⚠️ No tables created after fresh migration!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
