# ===== BUILD FRONTEND =====
FROM node:18 AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# build vite
RUN npm run build


# ===== BUILD BACKEND =====
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# 🔥 INI FIX PALING PENTING
COPY --from=node-builder /app/public/build /app/public/build

# laravel folders wajib
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

# install deps
RUN composer install --no-dev --optimize-autoloader

# clear cache aman
RUN php artisan config:clear || true
RUN php artisan view:clear || true
RUN php artisan route:clear || true

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0", "8080", "-t", "public"]