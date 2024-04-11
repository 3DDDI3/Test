FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip

RUN apt-get update && \
     apt-get install -y \
         libzip-dev \
         && docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql pcntl

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl 

WORKDIR /var/www/laravel