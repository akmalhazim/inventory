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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function() {
    Route::post('/inventory', 'Admin\InventoryController@store');
});

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ($router) {

    Route::post('inventory', 'Admin\InventoryController@store');

});


Route::get('/categories', 'CategoryController@index');
Route::get('/inventories', 'Admin\InventoryController@index');
Route::delete('/inventory/{id}', 'Admin\InventoryController@destroy');
Route::post('/inventory', 'Admin\InventoryController@update');
Route::get('/inventory/{id}', 'Admin\InventoryController@show');
Route::get('/borrower/{id}', 'Admin\InventoryController@getBorrower');
Route::put('/borrower/{id}', 'Admin\BorrowerController@toggleReturn');
Route::delete('/borrower/{id}', 'Admin\BorrowerController@destroy');