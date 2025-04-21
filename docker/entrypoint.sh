#!/bin/sh

# Check if APP_KEY is set in environment
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    echo "Generating application key..."
    php artisan key:generate --force
    # Get the generated key from .env file
    APP_KEY=$(grep APP_KEY .env | cut -d '=' -f2)
    echo "Generated APP_KEY: $APP_KEY"
else
    echo "Using provided APP_KEY from environment"
    # Make sure the APP_KEY is in the .env file
    sed -i "s|APP_KEY=.*|APP_KEY=$APP_KEY|g" .env
fi

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