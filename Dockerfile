FROM php:8.2-apache

# System deps + Node 20
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy full project FIRST
COPY . .

# Install PHP deps BEFORE Vite build
RUN composer install --no-dev --optimize-autoloader

# Generate app key
RUN php artisan key:generate --force

# Install JS deps
RUN npm install

# Build assets
RUN npm run build --debug --verbose --stacktrace

# Copy manifest to legacy location
RUN cp public/build/.vite/manifest.json public/build/manifest.json

# Verify manifest
RUN test -f public/build/manifest.json || (echo "❌ NO MANIFEST" && exit 1)

# SQLite + permissions
# Run migrations (creates sessions table)
RUN php artisan migrate --force

RUN mkdir -p database storage/{logs,framework/{cache,sessions,views}}
RUN touch database/database.sqlite
RUN chown -R www-data:www-data storage database bootstrap/cache
RUN chmod -R 775 storage database bootstrap/cache

# Apache
RUN a2enmod rewrite
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

EXPOSE 10000
CMD ["apache2-foreground"]
