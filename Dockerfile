# =========================
# 1. BUILD FRONTEND (VITE)
# =========================
FROM node:18 as node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# =========================
# 2. BUILD PHP APP
# =========================
FROM php:8.2-cli

WORKDIR /app

# install dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy source code
COPY . .

# install php deps
RUN composer install --no-dev --optimize-autoloader

# copy hasil build vite
COPY --from=node /app/public/build ./public/build

# permission fix
RUN chmod -R 775 storage bootstrap/cache

# clear cache (AMAN di build time)
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear

# =========================
# 3. START SERVER (WAJIB FIX)
# =========================
CMD php artisan serve --host=0.0.0.0 --port=$PORT