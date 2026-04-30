FROM node:18 AS node-builder

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 🔥 COPY FULL PROJECT SEKALI SAJA
COPY . .

# 🔥 OVERWRITE VITE BUILD DI PALING AKHIR
COPY --from=node-builder /app/public/build /app/public/build

RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear || true
RUN php artisan view:clear || true

EXPOSE 8080
CMD ["php", "-S", "0.0.0.0", "8080", "-t", "public"]

RUN ls -lah public/build || true