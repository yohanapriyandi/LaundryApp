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

    Route::resource('/couriers', 'API\UserController')->except(['create', 'show', 'update']);
    Route::post('/couriers/{id}', 'API\UserController@update')->name('couriers.update');

    Route::resource('/products', 'API\ProductController')->except(['create', 'show']);
    Route::get('/products/laundry-type', 'API\ProductController@getLaundryType');
    Route::post('/products/laundry-type', 'API\ProductController@storeLaundryType');

    Route::get('roles', 'API\RolePermissionController@getAllRole')->name('roles');
    Route::get('permissions', 'API\RolePermissionController@getAllPermission')->name('permission');
    Route::post('role-permission', 'API\RolePermissionController@getRolepermission')->name('role_permission');
    Route::post('set-role-permission', 'API\RolePermissionController@setRolePermission')->name('set_role_permission');
    Route::post('set-role-user', 'API\RolePermissionController@setRoleUser')->name('user.set_role');
    Route::get('user-authenticated', 'API\UserController@getUserLogin')->name('user.authenticated');
    Route::get('user-lists', 'API\UserController@userLists')->name('user.index');

    Route::resource('/expenses', 'API\ExpensesController')->except(['create', 'show']);
    Route::post('/expenses/accept', 'API\ExpensesController@accept')->name('expenses.accept');
    Route::post('/expenses/cancel', 'API\ExpensesController@cancelRequest')->name('expenses.cancel');
    Route::resource('/notification', 'API\NotificationController')->except(['create', 'destroy']);

    Route::resource('/customer', 'API\CustomerController')->except(['create', 'show']);

    Route::resource('/transaction', 'API\TransactionController')->except(['create', 'show']);
    Route::post('/transaction/complete-item', 'API\TransactionController@completeItem');
    Route::post('/transaction/payment', 'API\TransactionController@makePayment');

    Route::get('/chart', 'API\DashboardController@chart');
    Route::get('/export', 'API\DashboardController@exportData');


    





});