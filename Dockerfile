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

# install dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# copy vite build
COPY --from=node-builder /app/public/build /app/public/build

# storage wajib
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

# install php deps
RUN composer install --no-dev --optimize-autoloader

# clear + cache config (INI PENTING)
RUN php artisan optimize:clear || true

# check build (debug only)
RUN echo "=== CHECK BUILD ===" && ls -lah public/build || true
RUN cat public/build/manifest.json || true

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0", "8080", "-t", "public"]