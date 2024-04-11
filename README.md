### Инструкция для развертывания ###

Для корректной работы необходимо выполнить следующие шаги:
1. Создать пользователя для mysql:
   ```
     docker-compose exec -it mysql mysql -u root -p'root'
     grant all privileges on *.* to 'laravel'@'%';
     flush privileges;
     exit;
   ```
2. Создать базу:
   ```
    docker-compose exec -it mysql mysql -u root -p'root'
    create database laravel character set utf8 collate utf8_general_ci;
    exit;
   ```
3. 
   
