<?php
/**
 * Container de Laravel para inyecci�n de dependencias
 */
use Illuminate\Container\Container;
use Note\Application;

/**
 * Permite habilitar o deshabilitar la notificaci�n de errores
 */
ini_set('display_errors', 'on');
error_reporting(E_ALL);

/**
 * constantes utilizadas en la app
 * ROOT = ruta del directorio en el servidor, apunta a la carpeta public
 * URL = ruta http de la aplicaci�n utilizada para generar 'routes'
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath( __DIR__ ).DS);
define('URL', "http://localhost/proyectos/Note%20Component/public");

/**
 * llama el autoload de composer bajo el est�ndar psr-4
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../app/Helpers/Helper.php';



$app = new Application(
    new Container()
);

$app->run();
