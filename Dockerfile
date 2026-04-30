FROM node:18 AS node-builder

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# COPY VITE BUILD (INI FIX UTAMA)
COPY --from=node-builder /app/public/build ./public/build

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0", "8080", "-t", "public"]