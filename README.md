# Тестовое задание [SE]
Проект разбит на две папки `server` и `client`, где:
- server - laravel;
- client - react.

## Инструкция для backend
Порядок написания команд в терминале из корневого каталога:
1. `cd server`
2. `composer install`
3. `php artisan migrate`
4. `php artisan passport:install`
5. `php artisan db:seed`

После чего можно протестировать, как отрабатывают методы по пути `<домен>/api/documentation`.

> Хотелось бы ещё прикрутить frontend вместе с unit-тестами, но на улице уже 1:20, поэтому всем хороших снов :)
