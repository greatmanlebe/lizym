FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first
WORKDIR /var/www/html
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy app
COPY . .

# Build Vue + Laravel
RUN npm ci && npm run build
RUN php artisan key:generate --force --no-interaction
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
RUN chown -R www-data:www-data storage bootstrap/cache /var/www/html
RUN chmod -R 755 storage bootstrap/cache

# CRITICAL: Apache config for Laravel
RUN a2enmod rewrite
RUN echo '<VirtualHost *:10000>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    ServerName localhost' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

EXPOSE 10000
CMD ["apache2-foreground"]
