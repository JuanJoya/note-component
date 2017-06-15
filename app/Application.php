<?php

namespace Note;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Note\Http\Controllers\HomeController;
use Note\Http\Responses\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Application
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Router
     */
    private $router;

    public function __construct(Container $container, Request $request, Router $router)
    {
        $this->container = $container;
        $this->request = $request;
        $this->router = $router;
    }

    public static function build(Container $container, Request $request, Router $router)
    {
        (new Application($container, $request, $router))->run();
    }

    public function run()
    {
        $this->setRoutes($this->router);
        try {
            $response = $this->router->dispatch($this->request);
        } catch (NotFoundHttpException $e) {
            $response = (new View('NotFound', ['exception' => $e], false))->render();
        } finally {
            $response->send();
        }
    }

    /**
     * Routes de la app
     * @param Router $route
     */
    private function setRoutes(Router $route)
    {
        $route->get('/', HomeController::class . '@index');
        $route->get('/create', HomeController::class . '@create');
        $route->post('/create', HomeController::class . '@store');
        $route->get('/find', HomeController::class . '@find');
        $route->post('/find', HomeController::class . '@show');
        $route->get('/update/{id}', HomeController::class . '@update');
        $route->post('/update', HomeController::class . '@save');
        $route->get('/delete/{id}', HomeController::class . '@delete');
        $route->get('/search', HomeController::class . '@search');
        $route->post('/search', HomeController::class . '@check');
    }
}
