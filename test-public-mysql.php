<?php
echo "Testing public MySQL connection...\n";

try {
    $pdo = new PDO('mysql:host=gondola.proxy.rlwy.net;port=36450;dbname=railway', 'root', 'ahUPIxhZLPbdnPIPvsZsJPxXPzdDIshF');
    echo "✅ Connection successful!\n";
    
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
