<?php

use Note\Http\Controllers\Auth\AuthController;
use Note\Http\Controllers\HomeController;
use Note\Http\Controllers\Registered\NotesController;

//Guest
$router->get('/', ['as' => 'home', 'uses' => HomeController::class . '@index']);
$router->get('author/{slug}', ['as' => 'author.notes', 'uses' => HomeController::class . '@show']);
$router->get('search', ['as' => 'search', 'uses' => HomeController::class . '@search']);
$router->get('check', HomeController::class . '@check');

//Authentication
$router->group(['prefix' => 'auth', 'before' => 'guest'], function () use ($router) {
    $router->get('login', AuthController::class . '@getLogin');
    $router->post('login', AuthController::class . '@postLogin')->before('csrf');
    $router->get('register', AuthController::class . '@getRegister');
    $router->post('register', AuthController::class . '@postRegister');
});
$router->get('auth/logout', AuthController::class . '@getLogout')->before('auth');

//Registered
$router->group(['prefix' => 'notes', 'before' => 'auth'], function () use ($router) {
    $router->get('create', ['as' => 'notes.create', 'uses' => NotesController::class . '@create']);
    $router->post('/', ['as' => 'notes.store', 'uses' => NotesController::class . '@store']);
    $router->get('find', ['as' => 'notes.find', 'uses' => NotesController::class . '@find']);
    $router->get('author/{author}', ['as' => 'notes.show', 'uses' => NotesController::class . '@show']);
    $router->get('{note}/edit', ['as' => 'notes.edit', 'uses' => NotesController::class . '@edit']);
    $router->put('{note}', ['as' => 'notes.update', 'uses' => NotesController::class . '@update']);
    $router->delete('{note}', ['as' => 'notes.destroy', 'uses' => NotesController::class . '@destroy']);
});

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', function () {
        return 'users';
    });
});

$router->patterns([
    'author' => '0*[1-9][0-9]*',
    'note'   => '0*[1-9][0-9]*'
]);
