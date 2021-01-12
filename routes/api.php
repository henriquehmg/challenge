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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/pastel')->group(function(){
    Route::get('/', 'App\Http\Controllers\PastelController@index')->name('get_all_pastel');
    Route::get('/{id}', 'App\Http\Controllers\PastelController@show')->name('get_sigle_pastel');
    Route::post('/', 'App\Http\Controllers\PastelController@store')->name('new_pastel');
    Route::put('/{id}', 'App\Http\Controllers\PastelController@update')->name('update_pastel');
    Route::delete('/{id}', 'App\Http\Controllers\PastelController@delete')->name('delete_pastel');
});
