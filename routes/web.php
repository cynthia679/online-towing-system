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

$router->group(['prefix' => 'api/v1/client/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\ClientController@findById');
    $router->post('create','\App\Http\Controllers\Client@create');
    $router->post('update','\App\Http\Controllers\ClientController@update');
    $router->post('delete','\App\Http\Controllers\ClientLocationController@deleteById');
    $router->post('findById','\App\Http\Controllers\ClientController@findById');

});
$router->group(['prefix' => 'api/v1/product/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\ProductController@findById');
    $router->post('create','\App\Http\Controllers\ProductController@create');
    $router->post('update','\App\Http\Controllers\ProductController@update');
    $router->post('delete','\App\Http\Controllers\ProductController@deleteById');
    $router->post('findById','\App\Http\Controllers\ProductController@findById');

});
$router->group(['prefix' => 'api/v1/transaction/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\TransactionController@findById');
    $router->post('create','\App\Http\Controllers\Transaction@create');
    $router->post('update','\App\Http\Controllers\TransactionController@update');
    $router->post('delete','\App\Http\Controllers\TransactionLocationController@deleteById');
    $router->post('findById','\App\Http\Controllers\TransactionController@findById');

});
$router->group(['prefix' => 'api/v1/user/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\UserController@findById');
    $router->post('create','\App\Http\Controllers\User@create');
    $router->post('update','\App\Http\Controllers\UserController@update');
    $router->post('delete','\App\Http\Controllers\UserController@deleteById');
    $router->post('findById','\App\Http\Controllers\UserController@findById');

});
$router->group(['prefix' => 'api/v1/setting/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\SettingController@findById');
    $router->post('create','\App\Http\Controllers\Setting@create');
    $router->post('update','\App\Http\Controllers\SettingController@update');
    $router->post('delete','\App\Http\Controllers\SettingLocationController@deleteById');
    $router->post('findById','\App\Http\Controllers\SettingController@findById');

});

$router->group(['prefix' => 'api/v1/CustomerRequest/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\CustomerRequestController@findById');
    $router->post('create','\App\Http\Controllers\CustomerRequest@create');
    $router->post('update','\App\Http\Controllers\CustomerRequestController@update');
    $router->post('delete','\App\Http\Controllers\CustomerRequestLocationController@deleteById');
    $router->post('findById','\App\Http\Controllers\CustomerRequestController@findById');

});
$router->group(['prefix' => 'api/v1/Order/'], function($router)
{
    $router->post('findById','\App\Http\Controllers\OrderController@findById');
    $router->post('create','\App\Http\Controllers\Order@create');
    $router->post('update','\App\Http\Controllers\OrderController@update');
    $router->post('delete','\App\Http\Controllers\OrderController@deleteById');
    $router->post('findById','\App\Http\Controllers\OrderController@findById');

});



