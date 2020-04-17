# Note Component

Este proyecto es una prueba de conceptos, parte de una sencilla aplicación para la gestión de notas, la idea es construir un entorno para testear las vulnerabilidades típicas en una aplicación web (SQL Injection, XSS, CSRF). También se pone en practica conceptos básicos de un framework (Auth, Error Handler, IoC Container, Request, Response, Router, Middleware, Sessions, Template Engine, Validation).

---
Project Dependencies:
```sh
$ composer install
```
PSR12 Validate:
```sh
$ ./vendor/bin/phpcs --colors --report=code --standard=psr12  app/
```
HTTP Server:
```sh
$ cd public/
$ php -S localhost:8000
#or
$ php -S localhost:8000 -t public/ server.php
#or
$ ./run.sh
```
