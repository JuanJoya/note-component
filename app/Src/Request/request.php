<?php

/**
 * Este archivo permite configurar el objeto Request de la aplicación.
 * @see https://laravel.com/api/6.x/Illuminate/Http/Request.html
 */

declare(strict_types=1);

use Illuminate\Http\Request;

/**
 * Se crea el objeto Request desde las variables globales del servidor.
 */
$request = Request::capture();

/**
 * Se agrega el objeto Session para obtenerlo con la instancia del Request.
 * @var Symfony\Component\HttpFoundation\Session\Session $session
 */
$request->setSession($session);

/**
 * Se agrega la instancia al contenedor de dependencias para compartir el mismo
 * Request por toda la aplicación.
 * @var \Illuminate\Container\Container $container
 */
$container->instance(Request::class, $request);
