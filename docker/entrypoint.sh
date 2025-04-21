#!/bin/sh
# Set database path
DB_PATH="/var/www/html/storage/app/database.sqlite"

# Check if database exists, if not create it
if [ ! -f "$DB_PATH" ] || [ ! -s "$DB_PATH" ]; then
    echo "Creating new SQLite database..."
    touch "$DB_PATH"
    chmod 777 "$DB_PATH"
    php artisan migrate --force
    php artisan scout:import "App\Models\Article"
else
    echo "Using existing SQLite database..."
    # Run migrations in case there are new ones
    php artisan migrate --force
fi

# Clear and cache config
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Replace env vars in nginx.conf
envsubst '$PORT' < /etc/nginx/nginx.tpl.conf > /etc/nginx/nginx.conf

# Start services
php-fpm -D
nginx -g "daemon off;"