<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('me', 'AuthController@me');

        $router->group(['prefix' => 'pelajaran'], function () use ($router) {
            $router->get('/', 'MatpelController@getAll');
            $router->get('/{kode}', 'MatpelController@getOne');
            $router->post('/', 'MatpelController@add');
            $router->delete('/{kode}', 'MatpelController@delete');
        });
    });
});
