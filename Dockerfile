# Use official PHP image with necessary extensions
FROM php:8.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    sqlite3 \
    supervisor \
    unzip \
    git \
    curl \
    libsqlite3-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite bcmath

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .


# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader
RUN npm install

# Set up environment
RUN cp .env.example .env
RUN php artisan key:generate


# Optimize Laravel performance
RUN php artisan config:cache
RUN php artisan storage:link


RUN php artisan migrate --force
RUN mkdir -p storage/search
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


RUN chmod -R 777 database
RUN chmod -R 777 database/database.sqlite

RUN chmod -R 777 storage
RUN chmod -R 777 storage/search
RUN chmod -R 777 storage/framework/sessions
RUN chmod -R 777 storage/framework/cache
RUN chmod -R 777 storage/framework/views

RUN chmod -R 777 bootstrap/cache

RUN php artisan config:cache



# Expose port 80
EXPOSE 80

# Start PHP-FPM and Nginx when the container starts
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]



