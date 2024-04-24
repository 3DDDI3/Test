# Используем образ с Nginx и PHP-FPM
FROM php:8.1-fpm

# Устанавливаем Nginx
RUN apt-get update && apt-get install -y nginx

# Копируем конфигурационные файлы
# COPY nginx.conf /etc/nginx/nginx.conf
# COPY default.conf /etc/nginx/conf.d/default.conf

# Устанавливаем Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0

WORKDIR /var/www/html

# Копируем файлы проекта в образ
COPY . .

# Устанавливаем зависимости
RUN composer install

# Указываем директиву для работы с Laravel
COPY default.conf /etc/nginx/conf.d/default.conf

# Очищаем кэш
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Определяем порты
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]