FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy code
COPY . /var/www/html
WORKDIR /var/www/html

# Build Laravel + Vue
RUN composer install --no-dev --optimize-autoloader \
    && npm ci \
    && npm run build \
    && php artisan key:generate \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Apache
RUN a2enmod rewrite
EXPOSE 10000
