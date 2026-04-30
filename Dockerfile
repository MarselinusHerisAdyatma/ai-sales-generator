# ========================
# NODE BUILD (VITE)
# ========================
FROM node:18 as node
WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ========================
# LARAVEL APP
# ========================
FROM php:8.2-cli
WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy source code
COPY . .

RUN composer install --no-dev --optimize-autoloader

# 🔥 COPY HASIL VITE BUILD (INI KRUSIAL)
COPY --from=node /app/public/build ./public/build

# 🔥 CLEAN LARAVEL CACHE (WAJIB DI PRODUCTION)
RUN php artisan optimize:clear
RUN php artisan config:cache
RUN php artisan route:cache || true
RUN php artisan view:cache || true

RUN chmod -R 775 storage bootstrap/cache

# Railway PORT FIX
CMD php artisan serve --host=0.0.0.0 --port=$PORT