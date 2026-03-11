FROM php:8.2-apache

# Install system dependencies + Node
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www/html
WORKDIR /var/www/html

# Build step by step
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build
RUN php artisan key:generate
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 755 storage bootstrap/cache

# Apache config
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port (Render requires 10000)
EXPOSE 10000

CMD ["apache2-foreground"]
