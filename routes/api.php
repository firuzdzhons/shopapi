<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//api auth
Route::post('login', 'Auth\LoginController@login');
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('me', 'Auth\LoginController@me');
});

//clients route
Route::get('categories', 'CategoriesController@index');

Route::group(['prefix' => 'products'], function(){
    Route::get('/', 'ProductsController@index');
    Route::get('/show/{product}', 'ProductsController@show');
});

//adminpanel routes
Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function(){
    Route::apiResource('categories', 'Admin\CategoriesController');
    Route::apiResource('products', 'Admin\ProductsController');
});
