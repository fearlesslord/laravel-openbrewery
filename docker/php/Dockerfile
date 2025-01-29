FROM php:8.3-fpm

# Installa estensioni necessarie
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Installa Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

# Copia il file php.ini se serve personalizzazione
# COPY php.ini /usr/local/etc/php/

# Esegue composer install se serve (in alternativa si fa nella docker-compose)
