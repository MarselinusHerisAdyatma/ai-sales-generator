FROM php:8.2-cli

WORKDIR /app

# install dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# install & build frontend (Vite)
RUN npm install && npm run build

# permission fix
RUN chmod -R 775 storage bootstrap/cache

# expose port Render
EXPOSE 10000

# run Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000