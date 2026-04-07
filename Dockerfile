FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip xml ctype fileinfo \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction \
    && touch database/database.sqlite

EXPOSE 8000

CMD bash -c "php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"
