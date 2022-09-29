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
$router->group(['prefix' => 'api/v1'], function($router)
{
    $router->post('category/index','\App\Http\Controllers\CategoryController@index');
    $router->post('category/create','\App\Http\Controllers\CategoryController@create');
});
