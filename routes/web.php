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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth', 'admin'], 'namespace' => 'Admin'], function () {
	Route::get('admin', 'PagesController@index');
	Route::resource('members', 'MembersController', ['except' => ['destroy']]);
});
