# Php Component Test

Para generar el proyecto:
````
composer install
````
Para correr los tests
````
phpunit --bootstrap vendor/autoload.php tests
````
Para servir archivos estáticos
````
Utilizar apache, configurar constante de directorio en public/index.php
````
Para correr el server
````
php -S localhost:8000 public\index.php
````
Parámetros de configuración:
````
URL - constante en public/index.php
variables de conexión con la DB en app/Infrastructure/Database
````
