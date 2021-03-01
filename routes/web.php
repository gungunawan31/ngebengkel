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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/','Auth\LoginController@login')->name('login');

Auth::routes();
Route::get('/home','GeneralController@dashboard')->name('home');
Route::get('/getLabel','GeneralController@label')->name('home');
Route::get('/mechanic','GeneralController@mechanic')->name('mechanic');
Route::post('/insertMechanic','GeneralController@addMechanic')->name('insertMechanic');
Route::get('/getMechanic','GeneralController@getAllMechanic')->name('getMechanic');
Route::get('/UpdateStatusMechanic/{id}/{status}','GeneralController@StatusMechanic')->name('UpdateStatusMechanic');
Route::get('/deleteMecanic/{id}','GeneralController@deleteMecanic')->name('deleteMecanic');
Route::get('/getDataMecanicById/{id}','GeneralController@getMecanic')->name('getDataMecanicById');
Route::post('/UpdateMechanic','GeneralController@updateMechanic')->name('UpdateMechanic');

// mangement time
Route::get('/time','TimeController@index')->name('time');
Route::post('/insertTime','TimeController@addTime')->name('insertTime');
Route::post('/UpdateTime','TimeController@UpdateTime')->name('UpdateTime');
Route::get('/deleteTime/{id}','TimeController@DeleteTime')->name('deleteTime');
Route::get('/getTime','TimeController@getAllTime')->name('getTime');
Route::get('/getDataTimeById/{id}','TimeController@getTime')->name('getDataTimeById');
Route::get('/UpdateStatusTime/{id}/{status}','TimeController@StatusTime')->name('UpdateStatusTime');

//management service
Route::get('/service','ServiceController@index')->name('service');
Route::get('/getService','ServiceController@show')->name('getService');
Route::get('/getDetailServiceById/{id}','ServiceController@detail')->name('getService');
Route::get('/deleteService/{id}','ServiceController@destroy')->name('deleteService');
Route::get('/updateCar/{id}/{status}','ServiceController@updateCar')->name('updateCar');
Route::post('/insertTimeService','ServiceController@update')->name('insertTimeService');

//managemenrt barang
Route::get('/barang','BarangController@index')->name('barang');
Route::get('/getBarang','BarangController@show')->name('getBarang');
Route::get('/UpdateStatusBarang/{id}/{status}','BarangController@StatusBarang')->name('UpdateStatusBarang');
Route::get('/deleteBarang/{id}','BarangController@deleteBarang')->name('deleteBarang');
Route::post('/insertBarang','BarangController@addBarang')->name('insertBarang');
Route::post('/UpdateBarang','BarangController@updateBarang')->name('UpdateBarang');
Route::get('/getDataBarangById/{id}','BarangController@getBarang')->name('getDataBarangById');

//management produk
Route::get('/produk','ProdukController@index')->name('produk');
Route::post('/insertProduk/create','ProdukController@create')->name('insertProduk');
Route::get('/produk/{id}/edit','ProdukController@edit')->name('editproduk');
Route::post('produk/{id}/update', 'ProdukController@update')->name('updateproduk');
Route::get('produk/{id}/delete', 'ProdukController@delete')->name('deleteproduk');
Route::get('produk/{id}/profile', 'ProdukController@profile')->name('profileproduk');

// Route::get('/test','GeneralController@test')->name('jamban');
