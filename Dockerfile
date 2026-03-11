FROM php:8.2-apache

# Install dependencies + Node 18
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Update Node/npm
RUN npm install -g npm@latest

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel lives here
WORKDIR /var/www
COPY . .

# CRITICAL: Build Vite assets FIRST
RUN npm ci
RUN npm run build
RUN ls -la public/build/  # Verify manifest.json exists

# Laravel setup
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN php artisan key:generate --force --no-interaction

# SQLite database
RUN mkdir -p /var/www/database storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
RUN touch /var/www/database/database.sqlite
RUN chown -R www-data:www-data storage bootstrap/cache /var/www/database
RUN chmod -R 775 storage bootstrap/cache /var/www/database/database.sqlite

# Apache → Laravel public folder
RUN a2enmod rewrite
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

EXPOSE 10000
CMD ["apache2-foreground"]
