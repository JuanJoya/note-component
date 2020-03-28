<?php

/**
 * Este archivo permite configurar el objeto de sesiones de la aplicación.
 * @see https://symfony.com/doc/current/components/http_foundation/sessions.html
 */

declare(strict_types=1);

use Note\Src\Session\SimpleFlash\DismissibleTemplate;
use Symfony\Component\HttpFoundation\Session\{Session, SessionInterface, Storage\NativeSessionStorage};
use Tamtamchik\SimpleFlash\Flash;

/**
 * Se deshabilita la lectura de cookies desde JavaScript para evitar Session Hijacking.
*/
$session_storage = new NativeSessionStorage(['cookie_httponly' => '1']);
$session = new Session($session_storage);

/**
 * Reemplaza la función nativa de PHP session_start(), importante para el componente
 * de autenticación, mensajes flash...
 */
$session->start();

/**
 * Se establece un token para validar request POST contra ataques CSRF.
 */
$session->has('_token') ?: $session->set('_token', str_random(40));

/**
 * Se agrega la instancia al contenedor de dependencias para compartir la misma sesión
 * por toda la aplicación.
 * @var \Illuminate\Container\Container $container.
 */
$container->instance(SessionInterface::class, $session);

/**
 * Componente alternativo para gestionar sesiones flash.
 * @see https://github.com/tamtamchik/simple-flash
 */
$container->instance(Flash::class, new Flash(new DismissibleTemplate()));
