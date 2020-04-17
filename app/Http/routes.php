<?php

/**
 * En este archivo se registran los EndPoints de la aplicación.
 * @var \Illuminate\Routing\Router $router
 */

use Illuminate\Routing\Router;
use Note\Http\Controllers\Auth\AuthController;
use Note\Http\Controllers\HomeController;
use Note\Http\Controllers\Registered\NotesController;

//Guest
$router->get('/', HomeController::class . '@index')->name('home');
$router->get('author/{slug}', HomeController::class . '@show')->name('author.notes');
$router->get('search', HomeController::class . '@search')->name('search');
$router->get('check', HomeController::class . '@check');

//Authentication
$router->group(['prefix' => 'auth', 'middleware' => 'guest'], function (Router $router) {
    $router->get('login', AuthController::class . '@getLogin');
    $router->post('login', AuthController::class . '@postLogin')->middleware('csrf');
    $router->get('register', AuthController::class . '@getRegister');
    $router->post('register', AuthController::class . '@postRegister');
});
$router->get('auth/logout', AuthController::class . '@getLogout')->middleware('auth');

//Registered
$router->group(['prefix' => 'notes', 'middleware' => 'auth'], function (Router $router) {
    $router->patterns(['author' => '0*[1-9][0-9]*', 'note' => '0*[1-9][0-9]*']);
    $router->get('create', NotesController::class . '@create')->name('notes.create');
    $router->post('/', NotesController::class . '@store')->name('notes.store');
    $router->get('find', NotesController::class . '@find')->name('notes.find');
    $router->get('author/{author}', NotesController::class . '@show')->name('notes.show');
    $router->get('{note}/edit', NotesController::class . '@edit')->name('notes.edit');
    $router->put('{note}', NotesController::class . '@update')->name('notes.update');
    $router->delete('{note}', NotesController::class . '@destroy')->name('notes.destroy');
});

$router->group(['prefix' => 'users'], function (Router $router) {
    $router->get('/', function () {
        return 'users';
    });
});
