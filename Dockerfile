# Use official PHP image with FPM
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    php8.4-mbstring \
    php8.4-xml \
    php8.4-curl \
    php8.4-tokenizer \
    php8.4-bcmath \
    php8.4-zip

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Set up environment
RUN cp .env.example .env
RUN php artisan key:generate


# Optimize Laravel performance
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan storage:link

# Expose Laravel's default port
EXPOSE 10000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
