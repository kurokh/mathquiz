FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
    build-base \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    nginx

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Install Composer dependencies (no-dev for production)
RUN composer install --optimize-autoloader --no-dev

# Cache Laravel configuration and routes
RUN php artisan config:cache && php artisan route:cache

COPY nginx.conf /etc/nginx/nginx.conf

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["sh", "-c", "nginx -g 'daemon off;' & php-fpm"]
