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

Route::get('/', 'GuzzleController@index')->name('index');
Route::get('/testaccounts', 'PageController@index');
Route::get('/detail/{name}', 'GuzzleController@detail');

Auth::routes();