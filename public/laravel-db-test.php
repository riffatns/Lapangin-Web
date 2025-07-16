<?php
// Laravel database connectivity test
echo "=== Laravel Database Test ===\n";

// Initialize Laravel
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

try {
    // Test Laravel's database connection
    $db = $app['db'];
    
    echo "Laravel Database Config:\n";
    echo "Host: " . config('database.connections.mysql.host') . "\n";
    echo "Database: " . config('database.connections.mysql.database') . "\n";
    echo "Username: " . config('database.connections.mysql.username') . "\n";
    
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
    }
    
} catch (Exception $e) {
    echo "❌ Laravel database error: " . $e->getMessage() . "\n";
}
?>
