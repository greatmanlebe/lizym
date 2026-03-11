FROM php:8.2-apache

# Node 22 + NO SQLite deps
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
RUN npm ci --legacy-peer-deps

COPY . .
RUN npm run build || (echo "❌ VITE FAILED" && exit 1)
RUN test -f public/build/manifest.json || (echo "❌ NO MANIFEST" && exit 1)

# Laravel (NO DB extension needed for SQLite file)
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force --no-interaction

# SQLite file (NO extension install)
RUN mkdir -p database storage/{logs,framework/{cache,sessions,views}}
RUN touch database/database.sqlite
RUN chown -R www-data:www-data storage database bootstrap/cache
RUN chmod -R 775 storage database bootstrap/cache

# Apache
RUN a2enmod rewrite
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

EXPOSE 10000
CMD ["apache2-foreground"]
