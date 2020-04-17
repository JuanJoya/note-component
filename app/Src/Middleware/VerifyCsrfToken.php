<?php

declare(strict_types=1);

namespace Note\Src\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VerifyCsrfToken
{
    /**
     * @param SessionInterface $session
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Se verifica que el Request incluya el token CSRF y se compara con el
     * token generado internamente, con el fin de evitar ataques CSRF. En
     * el caso que coincidan, se genera un nuevo token.
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->session->get('_token') != $request->get('_token')) {
            throw new TokenMismatchException();
        } else {
            $this->session->set('_token', Str::random(40));
        }
        return $next($request);
    }
}
