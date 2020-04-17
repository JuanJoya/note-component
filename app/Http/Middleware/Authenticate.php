<?php

declare(strict_types=1);

namespace Note\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Note\Src\Auth\Authenticator;

class Authenticate
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
     */
    public function __construct(Authenticator $auth, Redirector $redirect)
    {
        $this->auth = $auth;
        $this->redirect = $redirect;
    }
    
    /**
     * Limita el acceso a un recurso si el usuario no ha iniciado sesión, en
     * tal caso se hace redirección a la ruta de login.
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guest()) {
            return $this->redirect->to('/auth/login');
        }
        return $next($request);
    }
}
