#!/bin/bash
set -e

# --- Variables ---
APP_DIR="/var/www/quick-kb"
GIT_REPO="https://github.com/cs-quicklabs/quick-kb.git"
BRANCH="do-database-persistence"

# Update & install prerequisites
sudo apt update && sudo apt install -y software-properties-common curl unzip git nginx sqlite3

# Add PHP 8.4 repo and install
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.4 php8.4-cli php8.4-common php8.4-mbstring php8.4-xml php8.4-bcmath php8.4-curl php8.4-sqlite3 php8.4-fpm php8.4-mysql

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

echo "📁 Cloning project..."
rm -rf $APP_DIR
git clone --branch $BRANCH $GIT_REPO $APP_DIR

cd $APP_DIR

# Set up Laravel
composer install --no-dev --optimize-autoloader
cp .env.example .env

# Set SQLite DB path in .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=/mnt/data/database.sqlite|g" .env

# Generate app key
php artisan key:generate

# Create persistent directory
sudo mkdir -p /mnt/data
sudo chmod 777 /mnt/data

# Create SQLite file if it doesn't exist
if [ ! -f /mnt/data/database.sqlite ]; then
    echo "Creating SQLite database file..."
    touch /mnt/data/database.sqlite
    chmod 777 /mnt/data/database.sqlite
fi

# Run migrations
php artisan migrate --force

mkdir -p storage/search
ln -sf /mnt/data/search storage/search || true
php artisan scout:import "App\Models\Article"

# Set permissions
chmod -R 777 storage bootstrap/cache
# Clear caches
echo "Clearing Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build assets
npm install && npm run build

# Configure Nginx (basic default example)
sudo cp docker/do-nginx.conf /etc/nginx/sites-available/quick-kb
sudo ln -s /etc/nginx/sites-available/quick-kb /etc/nginx/sites-enabled/
sudo systemctl restart nginx
sudo systemctl enable php8.4-fpm
sudo systemctl start php8.4-fpm