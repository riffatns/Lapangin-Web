<?php

// Railway Debug Test
echo "🔍 Railway Web Debug Test\n";
echo "========================\n";

// Test basic PHP functionality
echo "✅ PHP Version: " . phpversion() . "\n";
echo "✅ Memory Limit: " . ini_get('memory_limit') . "\n";
echo "✅ Max Execution Time: " . ini_get('max_execution_time') . "\n";

// Test Laravel bootstrap
echo "\n--- Laravel Bootstrap Test ---\n";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "✅ Composer autoload: OK\n";
    
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "✅ Laravel app bootstrap: OK\n";
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "✅ HTTP Kernel: OK\n";
    
    // Test basic request
    $request = Illuminate\Http\Request::create('/', 'GET');
    echo "✅ Request created: OK\n";
    
    // Test response (this might fail)
    echo "\n--- Response Test ---\n";
    $response = $kernel->handle($request);
    echo "✅ Response generated: OK\n";
    echo "Response Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() == 500) {
        echo "❌ 500 Error detected!\n";
        echo "Content length: " . strlen($response->getContent()) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// Test environment variables
echo "\n--- Environment Test ---\n";
echo "APP_ENV: " . getenv('APP_ENV') . "\n";
echo "APP_DEBUG: " . getenv('APP_DEBUG') . "\n";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'SET' : 'NOT SET') . "\n";

// Test database
echo "\n--- Database Test ---\n";
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=lapangin_db', 'root', '');
    echo "✅ Database connection: OK\n";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

// Test file permissions
echo "\n--- File Permissions Test ---\n";
echo "Storage writable: " . (is_writable(__DIR__ . '/storage') ? 'YES' : 'NO') . "\n";
echo "Cache writable: " . (is_writable(__DIR__ . '/storage/framework/cache') ? 'YES' : 'NO') . "\n";
echo "Views writable: " . (is_writable(__DIR__ . '/storage/framework/views') ? 'YES' : 'NO') . "\n";

echo "\n=== Debug Test Complete ===\n";
?>
