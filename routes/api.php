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


Route::prefix('/client')->group(function(){
    Route::get('/', 'App\Http\Controllers\ClientController@index')->name('get_all_Client');
    Route::get('/{id}', 'App\Http\Controllers\ClientController@show')->name('get_sigle_Client');
    Route::post('/', 'App\Http\Controllers\ClientController@store')->name('new_Client');
    Route::put('/{id}', 'App\Http\Controllers\ClientController@update')->name('update_Client');
    Route::delete('/{id}', 'App\Http\Controllers\ClientController@delete')->name('delete_Client');
});

Route::prefix('/pedido')->group(function(){
    Route::get('/', 'App\Http\Controllers\PedidoController@index')->name('get_all_Pedido');
    Route::get('/{id}', 'App\Http\Controllers\PedidoController@show')->name('get_sigle_Pedido');
    Route::post('/', 'App\Http\Controllers\PedidoController@store')->name('new_Pedido');
    Route::put('/{id}', 'App\Http\Controllers\PedidoController@update')->name('update_Pedido');
    Route::delete('/{id}', 'App\Http\Controllers\PedidoController@delete')->name('delete_Pedido');
});
