# ===== FRONTEND BUILD =====
FROM node:18 AS node-builder

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ===== BACKEND =====
FROM php:8.2-cli

WORKDIR /app

# install dependency sistem
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# copy hasil vite build (INI WAJIB)
COPY --from=node-builder /app/public/build /app/public/build

# ===== FIX LARAVEL RUNTIME =====
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# install dependency php
RUN composer install --no-dev --optimize-autoloader

# generate app key kalau belum ada (optional tapi aman)
RUN php artisan key:generate || true

# cache clear aman
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# permission final
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]