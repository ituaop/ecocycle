FROM php:8.4-fpm

# Instalar dependencias del sistema, herramientas de compresión y libpq para Postgres
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ajustamos el WORKDIR para que coincida con el volumen del docker-compose y Nginx
WORKDIR /var/www

# Aseguramos permisos para que PHP pueda escribir (logs/cache) si fuera necesario
RUN chown -R www-data:www-data /var/www