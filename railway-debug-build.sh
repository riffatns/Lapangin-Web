#!/bin/bash

echo "🚀 Railway Debug during Build/Deploy"

# Create debug log file
DEBUG_LOG="/tmp/railway-debug.log"

{
    echo "=== Railway Debug Log ==="
    echo "Timestamp: $(date)"
    echo "Working Directory: $(pwd)"
    echo ""
    
    echo "=== Environment Variables ==="
    env | grep -E "(MYSQL|DB_|RAILWAY)" | sort
    echo ""
    
    echo "=== Files in Directory ==="
    ls -la
    echo ""
    
    echo "=== Database Connection Test ==="
    # Test Railway connection
    if [ -n "$RAILWAY_PRIVATE_DOMAIN" ] && [ -n "$MYSQL_ROOT_PASSWORD" ]; then
        echo "Testing Railway connection..."
        php -r "
            try {
                \$pdo = new PDO('mysql:host={$RAILWAY_PRIVATE_DOMAIN};port=3306;dbname=railway', 'root', '{$MYSQL_ROOT_PASSWORD}', [PDO::ATTR_TIMEOUT => 10]);
                echo 'Railway connection: SUCCESS\n';
            } catch(Exception \$e) {
                echo 'Railway connection: FAILED - ' . \$e->getMessage() . '\n';
            }
        "
    else
        echo "Railway variables not found"
    fi
    
    # Test MySQL* connection
    if [ -n "$MYSQLHOST" ] && [ -n "$MYSQLPASSWORD" ]; then
        echo "Testing MySQL* connection..."
        php -r "
            try {
                \$pdo = new PDO('mysql:host={$MYSQLHOST};port={$MYSQLPORT};dbname={$MYSQLDATABASE}', '{$MYSQLUSER}', '{$MYSQLPASSWORD}', [PDO::ATTR_TIMEOUT => 10]);
                echo 'MySQL* connection: SUCCESS\n';
            } catch(Exception \$e) {
                echo 'MySQL* connection: FAILED - ' . \$e->getMessage() . '\n';
            }
        "
    else
        echo "MySQL* variables not found"
    fi
    
    echo ""
    echo "=== Laravel Configuration ==="
    if [ -f artisan ]; then
        php artisan --version
        echo "Laravel config test..."
        php artisan tinker --execute="
            try {
                \$config = config('database.connections.mysql');
                echo 'DB Host: ' . \$config['host'] . '\n';
                echo 'DB Port: ' . \$config['port'] . '\n';
                echo 'DB Database: ' . \$config['database'] . '\n';
                echo 'DB Username: ' . \$config['username'] . '\n';
            } catch(Exception \$e) {
                echo 'Config test failed: ' . \$e->getMessage() . '\n';
            }
        " 2>/dev/null || echo "Laravel config test failed"
    else
        echo "artisan not found"
    fi
    
    echo ""
    echo "=== Debug Complete ==="
    
} > "$DEBUG_LOG" 2>&1

# Show the log
echo "📋 Debug Log Contents:"
cat "$DEBUG_LOG"

# Also save to a file that can be accessed later
cp "$DEBUG_LOG" "/tmp/railway-debug-$(date +%Y%m%d-%H%M%S).log"
