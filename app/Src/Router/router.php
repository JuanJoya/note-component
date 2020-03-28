<?php

/**
 * En este archivo se incluye la lógica asociada a la construcción del Router,
 * las rutas y sus filtros.
 * @see https://laravel.com/api/5.1/Illuminate/Routing/Router.html
 */

declare(strict_types=1);

use Illuminate\Events\Dispatcher;
use Illuminate\Routing\{Redirector, Router, UrlGenerator};

/**
 * El objeto Dispatcher se utiliza (en laravel) básicamente para registrar y
 * disparar un evento asociado a su respectivo listener, el objeto Router lo
 * utiliza para despachar|ejecutar un Request y obtener un Response.
 * @see https://laravel.com/api/5.1/Illuminate/Events/Dispatcher.html
 * @var \Illuminate\Container\Container $container.
 */
$dispatcher = new Dispatcher($container);

/**
 * El Router utiliza el Container para resolver las dependencias de los
 * Controllers|Callbacks asociados a una ruta.
 */
$router = new Router($dispatcher, $container);
 
/**
 * El archivo 'routes.php' contiene la definición de las rutas de la aplicación,
 * se incluye dentro de una función anónima para limitar el scope del 'require'
 * a solo el objeto $router.
 */
(function () use ($router) {
    require ROOT_PATH . '/app/Http/routes.php';
})();

/**
 * El archivo 'filters.php' contiene la definición de los filtros asociados a las
 * rutas de la aplicación, un filtro es una version primitiva de un middleware.
 */
(function () use ($router) {
    require __DIR__ . '/filters.php';
})();

/**
 * Este objeto es de utilidad a la hora de manipular las rutas de la aplicación.
 * @see https://laravel.com/api/5.1/Illuminate/Routing/UrlGenerator.html
 */
$url = new UrlGenerator($router->getRoutes(), $request);

/**
 * El objeto Redirector permite crear diferentes tipos de redirección en base
 * a las rutas de la aplicación.
 * @see https://laravel.com/api/5.1/Illuminate/Routing/Redirector.html
 */
$redirect = new Redirector($url);

/**
 * Se añaden las instancias de ambos objetos al Container, de esta forma
 * cuando se inyecten en alguna parte de la aplicación, no hay que lidiar
 * con las dependencias.
 */
$container->instance(UrlGenerator::class, $url);
$container->instance(Redirector::class, $redirect);
