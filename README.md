### Инструкция для развертывания ###

Для корректной работы необходимо выполнить следующие шаги:
1. Запустить `docker контейнер`:
   ```console
      docker-compose up -d
   ```
3. Создать пользователя для mysql:
   ```console
     docker-compose exec -it mysql mysql -u root -p'root'
     grant all privileges on *.* to 'laravel'@'%';
     flush privileges;
     exit;
   ```
4. Создать базу:
   ```console
    docker-compose exec -it mysql mysql -u root -p'root'
    create database laravel character set utf8 collate utf8_general_ci;
    exit;
   ```
5. Загрузить папку vendor:
   ```console
      docker-compose run --rm composer install
   ```
6. Копировать файл `.env.example`, изменив его название на `.env` и изменив в нем подключение к бд:
   ```env
      DB_CONNECTION=mysql
      DB_HOST=mysql
      DB_PORT=3306
      DB_DATABASE=laravel
      DB_USERNAME=laravel
      DB_PASSWORD=laravel
   ```
7. Генерация ключа приложения
   ```console
      docker-compose run --rm artisan key:generate
   ```
8. Изменить права доступа:
   ```console
      docker-compose exec -it php chmod -R 777 .
   ```
9. Запустить миграции:
   ```console
      docker-compose run --rm artisan migrate
   ```
10. Создать символические ссылки
   ```console
      docker-compose run --rm artisan storage:link
   ```
   
⚠️Фильтрация в таблице осуществляется путем клика на заголовок таблицы (название изображения/время загрузки).⚠️
⚠️Загрузка изображения происходит при нажатии на кнопку "Выберите файл" (ограничение 5 файлов).⚠️
⚠️Скачивание zip архива происходит при нажатии иконки zip архива⚠️
