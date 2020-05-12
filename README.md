# Note Component

Este proyecto es una prueba de conceptos, parte de una sencilla aplicación para la gestión de notas, la idea es construir un entorno para testear las vulnerabilidades típicas en una aplicación web (SQL Injection, XSS, CSRF). También se pone en practica conceptos básicos de un framework (Auth, Error Handler, IoC Container, Middleware, Request, Response, Router, Sessions, Template Engine, Validation).

---
#### Project Dependencies
```sh
composer install
```
#### PSR12 Validate
```sh
vendor/bin/phpcs -n -p --colors --report=summary --standard=psr12 app/
```
#### HTTP Server
PHP built-in server.
```sh
cd public/
php -S localhost:8000
#or
php -S localhost:8000 -t public/ server.php
#or
./run.sh
```
#### Interactive Debugger
```sh
vendor/bin/psysh
```
Use this function as a breakpoint (only works with PHP built-in server).
```php
eval(debug());
```
#### Database Migrations
Validate your environment data in *phinx.php*, create project database and run:
```sh
vendor/bin/phinx migrate  
```
#### Database Seeding
```sh
vendor/bin/phinx seed:run -v
```
