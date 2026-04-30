# =========================
# NODE BUILD (VITE)
# =========================
FROM node:18 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# 🔥 pastikan VITE benar-benar build
RUN npm run build

# =========================
# PHP LARAVEL
# =========================
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# 🔥 WAJIB FOLDER LARAVEL
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache

RUN chmod -R 775 bootstrap/cache storage

# install dependency
RUN composer install --no-dev --optimize-autoloader

# 🔥 INI FIX UTAMA VITE
COPY --from=node /app/public/build /app/public/build

# 🔥 fallback safety check (biar ketahuan kalau gagal)
RUN ls -lah public/build || true

# cache clear aman
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT