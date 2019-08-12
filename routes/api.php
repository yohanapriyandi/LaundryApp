<?php

use Illuminate\Http\Request;

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

Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('/outlets', 'API\OutletController')->except(['show']);
    // Route::get('/outlets', ['as' => 'outlet.index', 'uses' => 'API\OutletController@index']);
    // Route::post('/outlets', ['as' => 'outlet.store', 'uses' => 'API\OutletController@store']);
    // Route::post('/outletss/{id}', 'API\UserController@update')->name('couriers.update');
});