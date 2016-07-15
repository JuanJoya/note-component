<?php
namespace Note;

use Illuminate\Contracts\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Note\Http\Controllers\HomeController;

class Application
{
    /**
     * @var Container de Laravel para inyección de dependencias
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Routes de la aplicación
     */
    public function run()
    {
        $router = new Router(
            new Dispatcher($this->container),
            $this->container
        );

        //routes
        $router->get('/', HomeController::class . '@index');
        $router->get('/create', HomeController::class . '@create');
        $router->post('/create', HomeController::class . '@store');
        $router->get('/find', HomeController::class . '@find');
        $router->post('/find', HomeController::class . '@show');
        $router->get('/update/{id}', HomeController::class . '@update');
        $router->post('/update', HomeController::class . '@save');
        $router->get('/delete/{id}', HomeController::class . '@delete');
        $router->get('/search', HomeController::class . '@search');
        $router->post('/search', HomeController::class . '@check');

        $response = $router->dispatch(Request::capture());

        $response->send();
    }
}