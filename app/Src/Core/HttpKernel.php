<?php

declare(strict_types=1);

namespace Note\Src\Core;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\{Router, Pipeline};
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\Response;

abstract class HttpKernel
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param Container $container
     * @param Router $router
     */
    public function __construct(Container $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
        $this->resolveRouteMiddleware();
    }

    /**
     * Se envía el Request a través de los Middleware  y se obtiene un
     * Response desde el Router.
     * @param Request $request
     * @return Response
     */
    public function sendRequestThroughRouter(Request $request): Response
    {
        return (new Pipeline($this->container))
            ->send($request)
            ->through($this->getGlobalMiddleware())
            ->then($this->dispatchToRouter());
    }

    /**
     * Callback que envía el Request (después de resolver cada Middleware) al Router.
     * @return Closure
     */
    private function dispatchToRouter(): Closure
    {
        return function ($request) {
            return $this->router->dispatch($request);
        };
    }

    /**
     * Se añade cada Middleware y su respectivo alias al Router, de esta forma
     * el Router sabe como resolver el método middleware().
     */
    private function resolveRouteMiddleware()
    {
        foreach ($this->getRouteMiddleware() as $key => $middleware) {
            $this->router->aliasMiddleware($key, $middleware);
        }
    }

    /**
     * Middleware que se pueden aplicar mediante un 'alias' en cualquier ruta.
     * @return array
     */
    abstract protected function getRouteMiddleware(): array;

    /**
     * Middleware que se aplican de forma global en la aplicación.
     * @return array
     */
    abstract protected function getGlobalMiddleware(): array;
}
