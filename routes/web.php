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

$router->get('/', ['as' => 'index', 'uses' => 'HomeController@help']);

$router->get('/languages', ['as' => 'languages', 'uses' => 'ReposController@all']);
$router->get('/languages/{language}', ['as' => 'language', 'uses' => 'ReposController@get']);
