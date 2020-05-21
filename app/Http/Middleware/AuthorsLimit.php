<?php

declare(strict_types=1);

namespace Note\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Note\Src\Auth\Authenticator;
use Tamtamchik\SimpleFlash\Flash;
use Illuminate\Routing\Redirector;
use Note\Domain\Services\Author\AuthorService;

class AuthorsLimit
{
    /**
     * Cantidad maxima de autores permitida por usuario.
     */
    public const AMOUNT = 3;

    /**
     * @var AuthorService
     */
    private $author;

    /**
     * @var Authenticator
     */
    private $auth;

    /**
     * @var Redirector
     */
    private $redirect;

    /**
     * @var Flash
     */
    private $flash;

    /**
     * @param AuthorService $author
     * @param Redirector $redirect
     * @param Flash $flash
     */
    public function __construct(AuthorService $author, Authenticator $auth, Redirector $redirect, Flash $flash)
    {
        $this->author = $author;
        $this->auth = $auth;
        $this->redirect = $redirect;
        $this->flash = $flash;
    }
    
    /**
     * Limita el acceso según la cantidad maxima de autores que puede tener un usuario.
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authors = $this->author->byUser(
            $this->auth->user()->getId()
        );
        if ($authors->count() >= self::AMOUNT) {
            $this->flash->warning('You can only have ' . self::AMOUNT . ' authors per user.');
            return $this->redirect->route('home');
        }
        return $next($request);
    }
}
