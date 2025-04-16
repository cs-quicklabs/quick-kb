#!/bin/sh

# Replace env vars in nginx.conf
envsubst '$PORT' < /etc/nginx/nginx.tpl.conf > /etc/nginx/nginx.conf

# Ensure /data volume and DB path exist
mkdir -p /data


# Move existing DB file if not already present
if [ ! -f /data/database.sqlite ]; then
  echo "Setting up persistent database..."
  if [ -f database/database.sqlite ]; then
    mv database/database.sqlite /data/database.sqlite
  else
    touch /data/database.sqlite
  fi
fi

# Remove old DB and create symlink
rm -f database/database.sqlite
ln -s /data/database.sqlite database/database.sqlite

# Set proper permissions
chmod -R 777 /data/database.sqlite
chmod -R 777 database
chmod -R 777 storage


echo "Preparing .env file..."

# Copy .env.example if .env doesn't exist
if [ ! -f .env ]; then
  cp .env.example .env
  echo ".env file created from .env.example"
fi

# If APP_KEY is missing or empty, generate it
if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate
else
  echo "APP_KEY already exists in .env"
fi

# Double-check the key is present
grep "APP_KEY=" .env

# Run Laravel migrations
php artisan migrate --force

# Laravel cache clear and rebuild
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear
php artisan storage:link



mkdir -p storage/search
php artisan scout:import "App\Models\Article"

# Set proper permissions
chmod -R 777 /data/database.sqlite
chmod -R 777 database
chmod -R 777 storage
chmod -R 777 storage/search
chmod -R 777 storage/framework/sessions
chmod -R 777 storage/framework/cache
chmod -R 777 storage/framework/views
chmod -R 777 bootstrap/cache




npm run build

# Start services
php-fpm -D
nginx -g "daemon off;"