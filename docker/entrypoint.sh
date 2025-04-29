#!/bin/sh
set -e

echo "Current directory: $(pwd)"
echo "Checking .env file existence..."
if [ -f ".env" ]; then
    echo ".env file exists"
    echo "Contents of .env file:"
    cat .env
else
    echo ".env file does not exist! Creating one..."
    echo "APP_NAME=QuickKB" > .env
    echo "APP_ENV=production" >> .env
    echo "APP_DEBUG=true" >> .env
    echo "DB_CONNECTION=sqlite" >> .env
    echo "DB_DATABASE=database/database.sqlite" >> .env
    echo "SCOUT_DRIVER=tntsearch" >> .env
    echo "SESSION_DRIVER=database" >> .env
    echo "SESSION_SECURE_COOKIE=true" >> .env
fi

# Generate a new key regardless of previous settings
echo "Generating a fresh application key..."
php artisan key:generate --force --show

# Read the newly generated key
APP_KEY=$(grep APP_KEY .env | cut -d '=' -f2)
echo "Application key in .env: $APP_KEY"

# Make sure mounted directory exists and is writable
echo "Setting up mounted data directory..."
# mkdir -p /mnt/data
# chmod 777 /mnt/data

# Set database path
DB_PATH="database/database.sqlite"

# Check if database exists, if not create it
if [ ! -f "$DB_PATH" ] || [ ! -s "$DB_PATH" ]; then
    echo "Creating new SQLite database..."
    touch "$DB_PATH"
    chmod 777 "$DB_PATH"
    php artisan migrate --force

    # Create a symbolic link for database search
    mkdir -p storage/search
    # ln -sf /mnt/data/search storage/search || true

    php artisan scout:import "App\Models\Article"
else
    echo "Using existing SQLite database..."
    # Run migrations in case there are new ones
    php artisan migrate --force
fi



# Clear caches
echo "Clearing Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Replace env vars in nginx.conf
envsubst '$PORT' < /etc/nginx/nginx.tpl.conf > /etc/nginx/nginx.conf

# Start services
echo "Starting services..."
php-fpm -D
nginx -g "daemon off;"