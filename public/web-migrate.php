<?php
// Web container migration script
echo "=== Web Container Migration Script ===\n";

// Set working directory
chdir(__DIR__ . '/..');

// Initialize Laravel
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    echo "1. Testing database connection...\n";
    
    $db = $app['db'];
    $pdo = $db->connection()->getPdo();
    
    echo "✅ Database connection successful!\n";
    
    echo "2. Checking current tables...\n";
    $tables = $db->select("SHOW TABLES");
    echo "Current tables: " . count($tables) . "\n";
    
    echo "3. Running migration...\n";
    
    // Run migration command
    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
    $kernel->bootstrap();
    
    $exitCode = $kernel->call('migrate', [
        '--force' => true,
        '--verbose' => true
    ]);
    
    echo "Migration exit code: $exitCode\n";
    
    echo "4. Checking tables after migration...\n";
    $tables = $db->select("SHOW TABLES");
    echo "Tables after migration: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            echo "  - $tableName\n";
        }
    }
    
    echo "5. Running database seed...\n";
    $exitCode = $kernel->call('db:seed', [
        '--force' => true
    ]);
    
    echo "Seed exit code: $exitCode\n";
    
    echo "✅ Migration and seeding completed!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
