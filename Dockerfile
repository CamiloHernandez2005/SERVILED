# Imagen base: PHP 8.3 (CLI) — sin Apache, así evitamos los problemas de MPM
FROM php:8.3-cli

# Dependencias del sistema y extensiones de PHP que usa el proyecto
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mysqli zip gd bcmath exif \
    && rm -rf /var/lib/apt/lists/*

# El servidor integrado de PHP atiende varias peticiones a la vez
ENV PHP_CLI_SERVER_WORKERS=4

# Composer (copiado desde la imagen oficial)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el proyecto e instalar dependencias de producción
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Script de arranque (usa el $PORT de Railway)
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]