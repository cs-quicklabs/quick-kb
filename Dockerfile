# Use official PHP 8.4 FPM image
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite bcmath

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .


# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Set up environment
RUN cp .env.example .env
RUN php artisan key:generate


# Optimize Laravel performance
RUN php artisan config:cache
RUN php artisan storage:link

RUN php artisan migrate --force
RUN chmod -R 777 /database/database.sqlite
RUN mkdir -p /storage/search
RUN chmod -R 777 /storage/search
RUN chmod -R 777 /bootstrap/cache
RUN php artisan scout:import "App\Models\Article"
RUN php artisan config:cache
# Expose Laravel's default port
EXPOSE 10000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
