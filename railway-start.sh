#!/bin/bash

echo "🚀 Starting Lapangin Railway deployment..."

# Check if we have database environment variables
if [ -z "$MYSQLHOST" ]; then
    echo "❌ Error: MYSQLHOST environment variable not set"
    echo "Make sure MySQL service is added to Railway project"
    exit 1
fi

echo "📡 Database connection info:"
echo "   Host: $MYSQLHOST"
echo "   Port: $MYSQLPORT"
echo "   Database: $MYSQLDATABASE"
echo "   User: $MYSQLUSER"

# Wait for database with timeout
echo "⏳ Waiting for database connection..."
for i in {1..20}; do
    if timeout 30 bash check-db.sh; then
        echo "✅ Database connection established!"
        break
    else
        echo "🔄 Attempt $i/20: Database not ready, waiting 15 seconds..."
        sleep 15
    fi
    
    if [ $i -eq 20 ]; then
        echo "❌ Database connection timeout after 5 minutes"
        echo "Debug: Trying direct connection test..."
        php -r "
            try {
                \$pdo = new PDO('mysql:host='.\$_ENV['MYSQLHOST'].';port='.\$_ENV['MYSQLPORT'].';dbname='.\$_ENV['MYSQLDATABASE'], \$_ENV['MYSQLUSER'], \$_ENV['MYSQLPASSWORD'] ?? '');
                echo 'Direct connection: SUCCESS\n';
            } catch(Exception \$e) {
                echo 'Direct connection error: ' . \$e->getMessage() . '\n';
            }
        "
        exit 1
    fi
done

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
    echo "✅ Application key generated"
fi

# Run migrations
echo "📊 Running database migrations..."
if php artisan migrate --force --no-interaction; then
    echo "✅ Migrations completed successfully"
else
    echo "❌ Migration failed"
    exit 1
fi

# Check if we need to seed data
echo "🌱 Checking if database needs seeding..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n1 || echo "0")

if [ "$USER_COUNT" = "0" ] || [ "$USER_COUNT" = "" ]; then
    echo "🌱 Database is empty, seeding with sample data..."
    if php artisan db:seed --force --no-interaction; then
        echo "✅ Database seeded successfully"
    else
        echo "⚠️  Seeding failed, but continuing..."
    fi
else
    echo "📊 Database already has $USER_COUNT users, skipping seeding"
fi

# Cache configurations (optional, continue on failure)
echo "⚡ Caching configurations..."
php artisan config:cache 2>/dev/null && echo "✅ Config cached" || echo "⚠️  Config cache skipped"
php artisan route:cache 2>/dev/null && echo "✅ Routes cached" || echo "⚠️  Route cache skipped"
php artisan view:cache 2>/dev/null && echo "✅ Views cached" || echo "⚠️  View cache skipped"

# Start the server
echo "🌐 Starting Laravel server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
