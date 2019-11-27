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

use Illuminate\Support\Facades\Auth;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('me', 'AuthController@me');
        $router->get('nilai', 'NilaiController@get');
        $router->get('nilai/{siswa_id}', 'NilaiController@getSiswa');
        $router->get('logout', function () {
            Auth::logout(true);
        });

        $router->group(['prefix' => 'pelajaran'], function () use ($router) {
            $router->get('/', 'MatpelController@getAll');
            $router->get('/{kode}', 'MatpelController@getOne');
            $router->post('/', 'MatpelController@add');
            $router->delete('/{kode}', 'MatpelController@delete');
        });

        $router->group(['prefix' => 'soal'], function () use ($router) {
            $router->get('/', 'SoalController@getAll');
            $router->get('/pelajaran/{kode_matpel}', 'SoalController@GetAllWithMatpel');
            $router->get('/{id}', 'SoalController@GetOne');
            $router->post('/', 'SoalController@add');
            $router->delete('/{id}', 'SoalController@delete');

            $router->group(['prefix' => '{soal_id}/pilihan'], function () use ($router) {
                $router->get('/', 'PilihanController@get');
                $router->post('/', 'PilihanController@add');
                $router->delete('/{id}', 'PilihanController@delete');
            });

            $router->group(['prefix' => '{soal_id}/kunci'], function () use ($router) {
                $router->get('/', 'KunciController@get');
                $router->post('/', 'KunciController@add');
                $router->delete('/{id}', 'KunciController@delete');
            });
        });

        $router->group(['prefix' => 'siswa'], function () use ($router) {
            $router->get('/soal/{matpel_id}', 'Siswa\SoalController@getSoal');
            $router->post('/soal/{soal_id}', 'Siswa\SoalController@saveJawaban');
        });
    });
});
