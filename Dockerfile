FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache → Laravel public folder
RUN a2enmod rewrite && \
    mv /var/www/html /var/www/laravel && \
    mkdir /var/www/html && \
    ln -s /var/www/laravel/public /var/www/html

WORKDIR /var/www/laravel

COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .
RUN npm ci && npm run build
RUN php artisan key:generate --force --no-interaction
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000
CMD ["apache2-foreground"]
