#!/bin/bash
/usr/local/bin/php artisan config:clear
/usr/local/bin/php artisan migrate --force
/usr/local/bin/php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
