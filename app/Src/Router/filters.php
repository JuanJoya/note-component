<?php

/**
 * Este archivo incluye algunos filtros básicos para limitar el acceso
 * a las rutas de la aplicación. Los filtros funcionan como un middleware
 * primitivo, permiten interrumpir el ciclo Request-Response y se pueden
 * llamar antes o después (before|after) de despachar una ruta.
 */

declare(strict_types=1);

use Illuminate\Session\TokenMismatchException;
use Note\Src\Auth\Auth;

/**
 * Limita el acceso a un recurso si el usuario no ha iniciado sesión, en
 * tal caso se hace redirección a la ruta de login.
 */
$router->filter('auth', function () {
    if (Auth::guest()) {
        return redirect()->to('/auth/login');
    }
});

/**
 * Se limita el acceso si el usuario ha iniciado sesión en la aplicación.
 */
$router->filter('guest', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
});

/**
 * Se verifica que el Request incluya el token CSRF y se compara con el
 * token generado internamente, con el fin de evitar ataques CSRF. En
 * el caso que coincidan, se genera un nuevo token.
 */
$router->filter('csrf', function ($route, $request) {
    if (session()->get('_token') != $request->get('_token')) {
        throw new TokenMismatchException();
    } else {
        session()->set('_token', str_random(40));
    }
});
