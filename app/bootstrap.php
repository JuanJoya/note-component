<?php

/**
 * Este archivo contiene toda la lógica del front-end controller.
 */

declare(strict_types=1);

/**
 * @var bool APP_DEBUG permite habilitar el error handler.
 */
define('APP_DEBUG', true);

/**
 * @var string ROOT_PATH directorio raíz de la aplicación.
 */
define('ROOT_PATH', dirname(__DIR__));

/**
 * @var string URL absoluta al directorio 'public'.
 */
define('URL', str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']));

/**
 * Permite deshabilitar cualquier error|exception output.
 */
ini_set('display_errors', APP_DEBUG ? 'on' : 'off');

/**
 * Permite establecer la zona horaria de la aplicación.
 */
date_default_timezone_set('America/Bogota');

/**
 * Composer PSR-4 Autoload.
 */
require_once ROOT_PATH . '/vendor/autoload.php';

/**
 * Lógica del error handler.
 */
require __DIR__ . '/Src/Debug/error_handler.php';

/**
 * Definición del contenedor de dependencias.
 */
require __DIR__ . '/Src/container.php';

/**
 * Se obtiene el objeto response al despachar el request(route), luego se
 * envían las cabeceras http y el contenido del response al Browser|Ajax|Fetch.
 * @var \Illuminate\Routing\Router $router.
 * @var \Illuminate\Http\Request $request.
 * @var \Illuminate\Http\Response $response.
 */
$response = $router->dispatch($request);
$response->send();
