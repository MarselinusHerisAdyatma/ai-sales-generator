# ================= FRONTEND BUILD =================
FROM node:18 AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# paksa vite build generate manifest
RUN npm run build


# ================= BACKEND =================
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project backend
COPY . .

# 🔥 COPY HASIL VITE YANG BENAR (INI FIX UTAMA)
COPY --from=node-builder /app/public/build ./public/build

# debug (optional tapi penting)
RUN ls -lah public || true
RUN ls -lah public/build || true

# Laravel folders wajib
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

# amanin cache
RUN php artisan config:clear || true
RUN php artisan view:clear || true
RUN php artisan route:clear || true

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0", "8080", "-t", "public"]