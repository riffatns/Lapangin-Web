<?php
// Laravel database connectivity test
echo "=== Laravel Database Test ===\n";

try {
    // Initialize Laravel properly
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Boot the application
    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
    $kernel->bootstrap();
    
    echo "✅ Laravel application booted successfully!\n";
    
    // Test database configuration
    $config = $app['config'];
    
    echo "Laravel Database Config:\n";
    echo "Host: " . $config->get('database.connections.mysql.host') . "\n";
    echo "Database: " . $config->get('database.connections.mysql.database') . "\n";
    echo "Username: " . $config->get('database.connections.mysql.username') . "\n";
    echo "Port: " . $config->get('database.connections.mysql.port') . "\n";
    
    // Test connection using Laravel's DB facade
    $db = $app->make('db');
    
    echo "✅ Database service resolved!\n";
    
    // Test connection
    $pdo = $db->connection()->getPdo();
    echo "✅ Laravel database connection successful!\n";
    
    // Check tables
    $tables = $db->select("SHOW TABLES");
    echo "Tables found via Laravel: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            echo "  - $tableName\n";
        }
    } else {
        echo "No tables found via Laravel!\n";
        
        // Check if migrations table exists
        try {
            $migrationCount = $db->table('migrations')->count();
            echo "Migration records: $migrationCount\n";
        } catch (Exception $e) {
            echo "No migrations table found\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
