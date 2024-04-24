FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
  zip \
  unzip 

RUN apt-get update && \
  apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libwebp-dev

RUN docker-php-ext-configure pcntl --enable-pcntl && \
  docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN docker-php-ext-install gd\
  pdo\ 
  pdo_mysql\
  pcntl

WORKDIR /var/www/laravel