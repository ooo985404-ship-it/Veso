FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install gd zip

RUN a2enmod rewrite

COPY . /var/www/html/

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/storage/uploads \
    /var/www/html/storage/processed \
    /var/www/html/storage/temp \
    && chmod -R 777 /var/www/html/storage

EXPOSE 80
