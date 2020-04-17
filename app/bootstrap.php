<?php

/**
 * Este archivo contiene toda la lógica del front-end controller.
 */

declare(strict_types=1);

/**
 * @var string ROOT_PATH directorio raíz de la aplicación.
 */
define('ROOT_PATH', dirname(__DIR__));

/**
 * @var string URL absoluta al directorio 'public'.
 */
define('URL', str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']));

/**
 * Permite establecer la zona horaria de la aplicación.
 */
date_default_timezone_set('America/Bogota');

/**
 * Composer PSR-4 Autoload.
 */
require_once ROOT_PATH . '/vendor/autoload.php';

/**
 * Lógica del Parser para variables de entorno.
 */
require __DIR__ . '/Src/Core/environment.php';

/**
 * Lógica del error handler.
 */
require __DIR__ . '/Src/Debug/error_handler.php';

/**
 * Definición del contenedor de dependencias.
 */
require __DIR__ . '/Src/Core/container.php';

/**
 * @var \Illuminate\Container\Container $container
 * @var \Illuminate\Routing\Router $router
 */
$kernel = new \Note\Http\Kernel($container, $router);

/**
 * @var \Illuminate\Http\Request $request
 */
$response = $kernel->sendRequestThroughRouter($request);

/**
 * Se envían las cabeceras HTTP y el contenido del Response al Web Browser.
 */
$response->send();
