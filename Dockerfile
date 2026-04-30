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

# copy project
COPY . .

# install php deps
RUN composer install --no-dev --optimize-autoloader

# 🔥 penting: copy hasil Vite build
COPY --from=node /app/public/build /app/public/build

# 🔥 FIX LARAVEL RUNTIME FOLDER (INI WAJIB)
RUN mkdir -p \
    storage/framework/{sessions,views,cache} \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# optional tapi aman
RUN php artisan config:clear || true
RUN php artisan view:clear || true
RUN php artisan cache:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT