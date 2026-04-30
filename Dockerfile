# ========================
# BUILD VITE (NODE STAGE)
# ========================
FROM node:18 as node
WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ========================
# LARAVEL STAGE
# ========================
FROM php:8.2-cli
WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

# 🔥 INI PENTING: ambil hasil build VITE
COPY --from=node /app/public/build public/build

# 🔥 bersihin cache production
RUN php artisan optimize:clear

RUN chmod -R 775 storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT