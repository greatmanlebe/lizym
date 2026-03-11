FROM php:8.2-apache

# Dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy ALL files FIRST
WORKDIR /var/www
COPY . .

# Build everything
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm ci && npm run build
RUN php artisan key:generate --force --no-interaction
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Apache: Point to Laravel PUBLIC folder
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf
RUN echo "<Directory /var/www/public>" >> /etc/apache2/sites-available/000-default.conf
RUN echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf
RUN echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf
RUN echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Symlink public to Apache root
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

EXPOSE 10000
CMD ["apache2-foreground"]
