FROM php:8.4-cli

# Dependencias PHP
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpng-dev \
    libonig-dev libxml2-dev curl \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Composer
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Vite
RUN npm install
RUN npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
