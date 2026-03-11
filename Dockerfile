FROM php:8.2-apache

# Install NODE 22 + deps (Your package.json needs this!)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy package files FIRST (caching)
WORKDIR /var/www
COPY package*.json ./
RUN npm ci --legacy-peer-deps  # Ignore engine warnings

# Copy source + BUILD (SEPARATE lines!)
COPY . .
RUN npm run build || (echo "❌ VITE BUILD FAILED" && ls -la public/ && exit 1)

# Verify manifest.json EXISTS
RUN test -f public/build/manifest.json || (echo "❌ NO MANIFEST" && exit 1)
RUN echo "✅ manifest.json = $(wc -c < public/build/manifest.json) bytes"

# Laravel
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force --no-interaction

# SQLite + storage
RUN mkdir -p database storage/{logs,framework/{cache,sessions,views},app/public}
RUN touch database/database.sqlite
RUN chown -R www-data:www-data storage database bootstrap/cache
RUN chmod -R 775 storage database bootstrap/cache

# Apache → public
RUN a2enmod rewrite
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

# Migrations
RUN php artisan migrate --force --no-interaction || true

EXPOSE 10000
CMD ["apache2-foreground"]
