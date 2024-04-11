### Инструкция для развертывания ###

Для корректной работы необходимо выполнить следующие шаги:
1. Запустить `docker контейнер`:
   ```console
      docker-compose up -d
   ```
2. Создать пользователя для mysql:
   ```console
     docker-compose exec -it mysql mysql -u root -p'root'
     grant all privileges on *.* to 'laravel'@'%';
     flush privileges;
     exit;
   ```
3. Создать базу:
   ```console
    docker-compose exec -it mysql mysql -u root -p'root'
    create database laravel character set utf8 collate utf8_general_ci;
    exit;
   ```
4. Загрузить папку vendor:
   ```console
      docker-compose run --rm composer install
   ```
5. Копировать файл `.env.example`, изменив его название на `.env` и изменив в нем подключение к бд:
   ```env
      DB_CONNECTION=mysql
      DB_HOST=mysql
      DB_PORT=3306
      DB_DATABASE=laravel
      DB_USERNAME=laravel
      DB_PASSWORD=laravel
   ```
6. Генерация ключа приложения
   ```console
      docker-compose run --rm artisan key:generate
   ```
7. Изменить права доступа:
   ```console
      docker-compose exec -it php chmod -R 777 .
   ```
8. Запустить миграции:
   ```console
      docker-compose run --rm artisan migrate
   ```
9. Создать символические ссылки
   ```console
      docker-compose run --rm artisan storage:link
   ```
   
⚠️Фильтрация в таблице осуществляется путем клика на заголовок таблицы (название изображения/время загрузки).⚠️   
⚠️Загрузка изображения происходит при нажатии на кнопку "Выберите файл" (ограничение 5 файлов).⚠️   
⚠️Скачивание zip архива происходит при нажатии иконки zip архива⚠️   
