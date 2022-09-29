<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
$router->group(['prefix' => 'api/v1/category/'], function($router)
{
    $router->post('index','\App\Http\Controllers\CategoryController@index');
    $router->post('create','\App\Http\Controllers\CategoryController@create');
    $router->post('update','\App\Http\Controllers\CategoryController@update');
    $router->post('delete','\App\Http\Controllers\CategoryController@deleteById');
    $router->post('findById','\App\Http\Controllers\CategoryController@findById');
});

$router->group(['prefix' => 'api/v1/location/'], function($router)
{
    $router->post('index','\App\Http\Controllers\LocationController@index');
    $router->post('create','\App\Http\Controllers\LocationController@create');
    $router->post('update','\App\Http\Controllers\LocationController@update');
    $router->post('delete','\App\Http\Controllers\LocationController@deleteById');
    $router->post('findById','\App\Http\Controllers\LocationController@findById');
});
