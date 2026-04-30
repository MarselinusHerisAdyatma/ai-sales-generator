# ===== FRONTEND BUILD =====
FROM node:18 AS node-builder

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ===== BACKEND BUILD =====
FROM php:8.2-cli

WORKDIR /app

# install dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# copy hasil Vite build (INI PENTING BANGET)
COPY --from=node-builder /app/public/build public/build

# buat folder wajib Laravel
RUN mkdir -p \
    storage/framework/{sessions,views,cache} \
    bootstrap/cache

# permission fix
RUN chmod -R 775 storage bootstrap/cache

# install PHP deps
RUN composer install --no-dev --optimize-autoloader

# clear cache aman (JANGAN paksa views dulu)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true