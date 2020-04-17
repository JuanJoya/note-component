<?php

declare(strict_types=1);

namespace Note\Http;

use Note\Src\Core\HttpKernel;

/**
 * Un Middleware permite filtrar un Request antes o después de retornar un Response,
 * esta clase permite registrar los Middleware de la aplicación.
 */
class Kernel extends HttpKernel
{
    /**
     * Middleware que se pueden aplicar mediante un 'alias' en cualquier ruta.
     * @return array
     */
    public function getRouteMiddleware(): array
    {
        return [
            'auth'  => \Note\Http\Middleware\Authenticate::class,
            'guest' => \Note\Http\Middleware\RedirectIfAuthenticated::class,
            'csrf'  => \Note\Src\Middleware\VerifyCsrfToken::class
        ];
    }

    /**
     * Middleware que se aplican de forma global en la aplicación.
     * @return array
     */
    protected function getGlobalMiddleware(): array
    {
        return [];
    }
}
