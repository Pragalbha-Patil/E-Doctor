<?php

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
    return view('index');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Route::get('completepayment', 'PayController@index');
Route::post('pay', 'PayController@pay');
Route::get('pay-success', 'PayController@success');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/appointments', 'HomeController@view')->name('appointments');
Route::get('/appointments/{id}', 'HomeController@deleteById')->name('delete');
Route::post('/doctor', 'HomeController@freeDateTime')->name('datetimeinput');
