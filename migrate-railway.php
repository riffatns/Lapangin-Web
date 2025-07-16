<?php
// Migration script for Railway MySQL database
echo "🚀 Lapangin Railway Migration Script\n";
echo "=====================================\n\n";

echo "1. Testing database connection...\n";
try {
    $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $database = $_ENV['DB_DATABASE'] ?? 'lapangin_db';
    $username = $_ENV['DB_USERNAME'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    
    echo "   Host: $host\n";
    echo "   Database: $database\n";
    echo "   Username: $username\n";
    
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "   ✅ Database connection successful!\n\n";
    
    // Check existing tables
    echo "2. Checking existing tables...\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "   Found " . count($tables) . " tables:\n";
        foreach ($tables as $table) {
            echo "   - $table\n";
        }
    } else {
        echo "   No tables found - fresh database\n";
    }
    echo "\n";
    
    // Run Laravel migration
    echo "3. Running Laravel migration...\n";
    $output = [];
    $returnCode = 0;
    
    // Change to the Laravel directory
    chdir(__DIR__);
    
    // Run migration command
    exec('php artisan migrate --force 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "   ✅ Migration completed successfully!\n";
        echo "   Output:\n";
        foreach ($output as $line) {
            echo "   $line\n";
        }
    } else {
        echo "   ❌ Migration failed with code $returnCode\n";
        echo "   Error output:\n";
        foreach ($output as $line) {
            echo "   $line\n";
        }
    }
    
    // Check tables after migration
    echo "\n4. Checking tables after migration...\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "   Found " . count($tables) . " tables after migration:\n";
    foreach ($tables as $table) {
        echo "   - $table\n";
    }
    
} catch (PDOException $e) {
    echo "   ❌ Database error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🎉 Migration script completed!\n";
?>
