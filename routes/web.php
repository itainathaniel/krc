<?php

Route::get('/', 'PagesController@index')->name('homepage');
Route::get('member/{member}/{slug?}', ['uses' => 'MembersController@show', 'as' => 'member']);

Auth::routes();

Route::get('/home', 'HomeController@index');

// Route::get('krcbotman', 'ChatController@show');

Route::group([
		'middleware' => ['auth', 'admin'],
		'namespace' => 'Admin',
		'prefix' => 'admin',
		'as' => 'admin.'
	], function ()  {
		Route::get('admin', ['as' => 'dashboard', 'uses' => 'PagesController@index']);
		Route::resource('member', 'MembersController', ['except' => ['destroy']]);
	});
