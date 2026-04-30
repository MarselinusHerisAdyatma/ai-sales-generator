# =========================
# FRONTEND BUILD (VITE)
# =========================
FROM node:18 AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# =========================
# BACKEND BUILD (LARAVEL)
# =========================
FROM php:8.2-cli

WORKDIR /app

# install dependencies OS
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# IMPORTANT: COPY hasil Vite build
COPY --from=node-builder /app/public/build ./public/build

# =========================
# FIX LARAVEL STORAGE ERROR (INI WAJIB)
# =========================
RUN mkdir -p \
    storage/app \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

# permission wajib
RUN chmod -R 775 storage bootstrap/cache

# =========================
# install PHP deps
# =========================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# =========================
# cache aman (JANGAN paksa views dulu)
# =========================
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# =========================
# start server
# =========================
CMD php artisan serve --host=0.0.0.0 --port=8080