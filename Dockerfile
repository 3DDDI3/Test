FROM nginx:stable-alpine

FROM php:8.1-fpm as php

COPY configs/nginx.conf /etc/nginx/conf.d/default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.4.0

COPY src /var/www/laravel/

WORKDIR /var/www/laravel

EXPOSE 80
EXPOSE 9000

