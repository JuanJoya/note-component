<?php

/**
 * En este archivo se definen las dependencias del contenedor IoC, en términos
 * simples, se le explica como resolver una dependencia.
 * @see http://fabien.potencier.org/what-is-dependency-injection.html
 * Documentación del contenedor.
 * @see https://laravel.com/api/6.x/Illuminate/Container/Container.html
 */

declare(strict_types=1);

use Illuminate\Container\Container;
use Note\Src\Auth\{Authenticator, BasicAuth};

$container = new Container();

/**
 * Solo debe haber una instancia del contenedor, con este método se obtiene
 * la instancia desde cualquier parte de la aplicación.
 */
Container::setInstance($container);

/**
 * Configuración del objeto Session.
 */
require dirname(__DIR__) . '/Session/session.php';

/**
 * Definición del objeto Request.
 */
require dirname(__DIR__) . '/Request/request.php';

/**
 * Definición del router de la aplicación.
 */
require dirname(__DIR__) . '/Router/router.php';

/**
 * Configuración del Template Engine.
 */
require dirname(__DIR__) . '/Template/template.php';

/**
 * Configuración del sistema de validación.
 */
require dirname(__DIR__) . '/Validation/Factory.php';

/**
 * Este método le indica al container que implementación debe utilizar.
 */
$container->bind(Authenticator::class, BasicAuth::class);

/**
 * Dependencias del dominio de la aplicación.
 */
(function () use ($container) {
    require ROOT_PATH . '/app/Contracts/dependencies.php';
})();
