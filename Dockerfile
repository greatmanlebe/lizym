FROM php:8.2-apache

# Node 22 + deps (from your working version)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && docker-php-ext-install mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY package*.json ./

# DEBUG: Show Node/npm versions
RUN node --version && npm --version

# DEBUG: Show package.json scripts
RUN echo "=== PACKAGE.JSON SCRIPTS ===" && cat package.json | grep -A10 -B5 '"scripts"'

RUN npm ci --legacy-peer-deps

COPY . .

# DEBUG: List available npm scripts
RUN echo "=== AVAILABLE NPM SCRIPTS ===" && npm run

# DEBUG: Show npm run build script details
RUN echo "=== NPM RUN BUILD SCRIPT ===" && npm run build --dry-run

# DEBUG: Run build + show FULL error
RUN npm run build || ( \
    echo "=== NPM BUILD FAILED ===" && \
    echo "=== LAST NPM LOG ===" && \
    cat /root/.npm/_logs/*-debug-*.log | tail -50 && \
    echo "=== PUBLIC FOLDER ===" && \
    ls -la public/ || true && \
    exit 1 \
)

# If we reach here, build succeeded - verify manifest
RUN test -f public/build/manifest.json && echo "✅ MANIFEST EXISTS" || (echo "❌ NO MANIFEST" && exit 1)

# Rest of Laravel setup (unchanged)
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force --no-interaction
RUN mkdir -p database storage/{logs,framework/{cache,sessions,views}}
RUN touch database/database.sqlite
RUN chown -R www-data:www-data storage database bootstrap/cache
RUN chmod -R 775 storage database bootstrap/cache
RUN a2enmod rewrite
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html
RUN php artisan migrate --force --no-interaction || true

EXPOSE 10000
CMD ["apache2-foreground"]
