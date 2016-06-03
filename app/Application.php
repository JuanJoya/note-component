<?php
namespace Note;

use Illuminate\Contracts\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Note\Http\Controllers\HomeController;

class Application
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

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

        $response = $router->dispatch(Request::capture());

        $response->send();
    }
}