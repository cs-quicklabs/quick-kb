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
    nodejs \
    npm \
    supervisor \
    && docker-php-ext-install pdo pdo_sqlite bcmath

# Set working directory
WORKDIR /var/www/html/quick-kb

# Copy application files
COPY . .


# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader
RUN npm install


# Set up environment
RUN cp .env.example .env
# RUN php artisan key:generate


# Optimize Laravel performance
RUN php artisan config:cache
RUN php artisan storage:link

RUN php artisan migrate --force
RUN chmod -R 777 database/database.sqlite
RUN mkdir -p storage/search
RUN chmod -R 777 storage
RUN chmod -R 777 storage/search
RUN chmod -R 777 bootstrap/cache
RUN php artisan scout:import "App\Models\Article"

RUN npm run build

# Clear and cache config, routes, and views
RUN php artisan cache:clear \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:clear \
    && php artisan view:clear

# Copy Nginx config
 COPY docker/nginx.conf /etc/nginx/nginx.conf
 COPY docker/quick-kb.conf /etc/nginx/sites-available/quick-kb

# Ensure the default site is enabled
 RUN ln -s /etc/nginx/sites-available/quick-kb /etc/nginx/sites-enabled/quick-kb

# Expose Laravel's default port
EXPOSE 80

# Start Supervisor to manage Nginx and PHP-FPM
# CMD ["sh", "-c", "service php8.4-fpm start && nginx -g 'daemon off;'"]
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]

