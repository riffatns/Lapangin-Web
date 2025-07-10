#!/bin/bash

# Simple database connection test
echo "Testing database connection..."

if [ -z "$MYSQLHOST" ] || [ -z "$MYSQLPORT" ] || [ -z "$MYSQLDATABASE" ] || [ -z "$MYSQLUSER" ]; then
    echo "Error: Missing required database environment variables"
    echo "Required: MYSQLHOST, MYSQLPORT, MYSQLDATABASE, MYSQLUSER, MYSQLPASSWORD"
    exit 1
fi

# Test connection with timeout
timeout 30 php -r "
    \$host = getenv('MYSQLHOST');
    \$port = getenv('MYSQLPORT');
    \$database = getenv('MYSQLDATABASE');
    \$username = getenv('MYSQLUSER');
    \$password = getenv('MYSQLPASSWORD');
    
    try {
        \$dsn = \"mysql:host=\$host;port=\$port;dbname=\$database\";
        \$pdo = new PDO(\$dsn, \$username, \$password, [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo \"Database connection successful!\n\";
        exit(0);
    } catch(Exception \$e) {
        echo \"Database connection failed: \" . \$e->getMessage() . \"\n\";
        exit(1);
    }
"

if [ $? -eq 0 ]; then
    echo "✅ Database connection verified"
    exit 0
else
    echo "❌ Database connection failed"
    exit 1
fi
