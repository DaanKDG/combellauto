<?php

use App\Events\TestEvent;

Route::get('/', 'PageController@index')->name('index');
Route::get('/create', 'PageController@create')->name('create');
Route::get('/create/account', 'ApiController@create')->name('api.create');
Route::get('/accounts/status','PageController@status')->name('status');
Auth::routes();