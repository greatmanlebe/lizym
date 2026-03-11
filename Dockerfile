FROM php:8.2-apache

# Install Node 18 + deps (CRITICAL for Laravel 12 Vite)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy package files FIRST (Docker layer caching)
WORKDIR /var/www
COPY package*.json ./
RUN npm ci

# Copy ALL files
COPY . .

# BUILD VIT E - STEP BY STEP (CRITICAL!)
RUN npm run build || (echo "❌ VITE BUILD FAILED" && ls -la public/build/ && exit 1)
RUN test -f public/build/manifest.json || (echo "❌ manifest.json MISSING" && ls -la public/ && exit 1)

# Laravel setup
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force --no-interaction

# SQLite + storage
RUN mkdir -p database storage/{logs,framework/{cache,sessions,views},app/public}
RUN touch database/database.sqlite
RUN chown -R www-data:www-data storage database bootstrap/cache
RUN chmod -R 775 storage database bootstrap/cache

# Apache config
RUN a2enmod rewrite
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

# Migrations
RUN php artisan migrate --force --no-interaction || true

EXPOSE 10000
CMD ["apache2-foreground"]
