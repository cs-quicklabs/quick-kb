#!/bin/sh
# Check if database exists, if not create it
if [ ! -f /var/www/html/storage/app/database.sqlite ]; then
    echo "Creating new SQLite database..."
    touch /var/www/html/storage/app/database.sqlite
    chmod 777 /var/www/html/storage/app/database.sqlite
    php artisan migrate --force
    php artisan scout:import "App\Models\Article"
else
    echo "Using existing SQLite database..."
    # Run migrations in case there are new ones
    php artisan migrate --force
fi

# Clear and cache config
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear

# Replace env vars in nginx.conf
envsubst '$PORT' < /etc/nginx/nginx.tpl.conf > /etc/nginx/nginx.conf

# Start services
php-fpm -D
nginx -g "daemon off;"