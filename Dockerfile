# =========================
# NODE BUILD (VITE)
# =========================
FROM node:18 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build

# =========================
# LARAVEL APP
# =========================
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# 🔥 WAJIB: buat folder Laravel
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache

RUN chmod -R 775 bootstrap/cache storage

# install dependency PHP
RUN composer install --no-dev --optimize-autoloader

# 🔥 ambil hasil build Vite (AMAN)
COPY --from=node /app/public /app/public

# clear cache aman (jangan fail build)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT