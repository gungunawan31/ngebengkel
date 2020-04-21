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
Route::post('login','userController@login')->name('login');
Route::post('register','userController@register')->name('register');
Route::post('book','userController@booking')->name('book');
Route::get('validate/{id}','userController@validateUser')->name('register');
Route::get('history/{id}','userController@history')->name('register');
Route::get('mecanic','userController@getMecanic')->name('mecanic');
Route::get('cek/{id}','userController@cekDone')->name('cek');
Route::get('detailHistory/{id}','userController@detailHistory')->name('detailHistory');
Route::get('insrate/{id}/{rate}','userController@addRating')->name('insrate');
