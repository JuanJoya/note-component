<?php

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Note\Application;
use Note\Http\Controllers\BaseController;

/**
 * llama el autoload de composer bajo el estándar psr-4
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Permite habilitar o deshabilitar la notificación de errores
 */
ini_set('display_errors', 'on');
error_reporting(E_ALL);

/**
 * URL = url utilizada para servir archivos estáticos
 */
define('URL', "http://localhost/Proyectos/note-component/public");

$container  = new Container();
$dispatcher = new \Illuminate\Events\Dispatcher($container);
$router     = new \Illuminate\Routing\Router($dispatcher, $container);
$request    = Request::capture();
BaseController::setRequest($request);

Application::build($container, $request, $router);
