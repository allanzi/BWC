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

Route::pattern('id', '[0-9]+');

Route::group(['prefix' => 'vehicles', 'as' => 'vehicles.'], function () {
    Route::get('/find', ['as' => 'search', 'uses' => 'VehicleController@search']);
});
Route::resource('vehicles', 'VehicleController');
