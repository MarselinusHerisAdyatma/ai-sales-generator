# ======================
# NODE BUILD STAGE
# ======================
FROM node:18 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# 🔥 FORCE VITE BUILD + FAIL IF ERROR
RUN npm run build

# cek hasil build (WAJIB)
RUN ls -lah public/build


# ======================
# PHP LARAVEL STAGE
# ======================
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# 🔥 WAJIB folder Laravel runtime
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache

RUN chmod -R 775 bootstrap/cache storage

# install PHP deps
RUN composer install --no-dev --optimize-autoloader

# 🔥 INI FIX UTAMA (JANGAN /public BUILD, AMBIL FULL PUBLIC)
COPY --from=node /app/public /app/public

# sanity check
RUN ls -lah public/build || true

# clear cache aman
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT