<?php

declare(strict_types=1);

namespace Note\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Note\Src\Auth\Authenticator;

class RedirectIfAuthenticated
{
    /**
     * @var Authenticator
     */
    private $auth;

    /**
     * @var Redirector
     */
    private $redirect;

    /**
     * @param Authenticator $auth
     * @param Redirector $redirect
     */
    public function __construct(Authenticator $auth, Redirector $redirect)
    {
        $this->auth = $auth;
        $this->redirect = $redirect;
    }

    /**
     * Limita el acceso si el usuario ha iniciado sesión en la aplicación.
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->check()) {
            return $this->redirect->route('home');
        }
        return $next($request);
    }
}
