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
    return "URL API ".url('/')."<br/>Document : <a href='https://documenter.getpostman.com/view/8754350/SW7XZ949?version=latest'>API Directory</a>";
});

$router->post('provinces','ProvincesController@index');
$router->post('regencies', 'RegenciesController@index');
$router->post('districts', 'DistrictsController@index');
$router->post('villages', 'VillagesController@index');