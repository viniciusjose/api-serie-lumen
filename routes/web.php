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

/** @var Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'serie'], function () use ($router) {
        $router->get('', 'SeriesController@index');
        $router->get('{id}/episodios', 'EpisodioController@episodiosPorSerie');
        $router->post('', 'SeriesController@store');
        $router->get('{id}', 'SeriesController@show');
        $router->put('{id}', 'SeriesController@update');
        $router->delete('{id}', 'SeriesController@destroy');
    });
    
    $router->group(['prefix' => 'episodio'], function () use ($router) {
        $router->get('', 'EpisodioController@index');
        $router->post('', 'EpisodioController@store');
        $router->get('{id}', 'EpisodioController@show');
        $router->put('{id}', 'EpisodioController@update');
        $router->delete('{id}', 'EpisodioController@destroy');
    });
});

$router->post('api/login', 'TokenController@gerarToken');