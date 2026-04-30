FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# 🔥 WAJIB: bikin folder sebelum composer install
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache

# 🔥 permission dulu sebelum composer
RUN chmod -R 775 bootstrap/cache storage

RUN composer install --no-dev --optimize-autoloader

# Vite build copy
COPY --from=node /app/public/build /app/public/build

# safety clear
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT