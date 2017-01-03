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

Route::get('/', 'PagesController@index')->name('homepage');
Route::get('be-right-back', 'PagesController@brb')->name('brb');
Route::get('member/{member}/{slug?}', ['uses' => 'MembersController@show', 'as' => 'member']);

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group([
		'middleware' => ['auth', 'admin'],
		'namespace' => 'Admin',
		'prefix' => 'admin',
		'as' => 'admin.'
	], function ()  {
		Route::get('admin', ['as' => 'dashboard', 'uses' => 'PagesController@index']);
		Route::resource('member', 'MembersController', ['except' => ['destroy']]);
	});
