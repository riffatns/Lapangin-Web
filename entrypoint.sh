#!/bin/bash
set -e

echo "=== Starting Laravel Application ==="
echo "PHP Version:"
/usr/local/bin/php --version

echo "=== Running migrations ==="
/usr/local/bin/php artisan migrate --force

echo "=== Running seeders ==="
/usr/local/bin/php artisan db:seed --force

echo "=== Starting Laravel server ==="
exec /usr/local/bin/php artisan serve --host=0.0.0.0 --port=8000
