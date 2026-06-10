#!/bin/bash
set -e
cd /var/www/html
/usr/local/bin/php artisan config:clear
/usr/local/bin/php artisan migrate --force
echo "Starting server on port ${PORT:-8000}"
exec /usr/local/bin/php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
