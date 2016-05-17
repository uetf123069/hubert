<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/register', 'UserapiController@register');

Route::group(['prefix' => 'userApi'], function(){

	Route::post('/register','UserapiController@register');
	
	Route::get('/userdetails','UserapiController@details_fetch');

	Route::post('/login','UserapiController@login');

	Route::post('/updateProfile', 'UserapiController@details_save');

	Route::post('/forgotpassword', 'UserapiController@forgot_password');

	Route::get('/tokenRenew', 'UserapiController@tokenRenew');

	Route::post('/serviceList', 'UserapiController@serviceList');

	Route::post('/singleService', 'UserapiController@singleService');

	Route::post('/sendRequest', 'UserapiController@sendRequest');

	Route::post('/cancelRequest', 'UserapiController@cancelRequest');

	Route::get('/paybypaypal', 'UserapiController@paybypaypal');

	Route::get('/requestStatusCheck', 'UserapiController@requestStatusCheck');

	Route::get('/history' , 'UserapiController@history');

	Route::post('/feedback', 'UserapiController@feedback');

});


Route::group(['prefix' => 'providerApi'], function(){

	Route::post('/register','ProviderApiController@register');

	Route::post('/login','ProviderApiController@login');
	
	Route::get('/userdetails','ProviderApiController@details_fetch');

	Route::post('/updateProfile', 'ProviderApiController@details_save');

	Route::post('/forgotpassword', 'ProviderApiController@forgot_password');

	Route::get('/tokenRenew', 'ProviderApiController@tokenRenew');

	Route::post('/acceptRequest', 'ProviderApiController@acceptRequest');

	Route::post('/cancelRequest', 'ProviderApiController@cancelRequest');

	Route::post('/startRequest', 'ProviderApiController@startRequest');

	Route::post('/arrived', 'ProviderApiController@arrived');

	Route::post('/startedRequest', 'ProviderApiController@startRequest');

	Route::post('/endRequest', 'ProviderApiController@endRequest');

	Route::post('/completed', 'ProviderApiController@completed');

	Route::post('/feedback', 'ProviderApiController@feedback');


});

// Admin Routes

Route::group(['prefix' => 'admin'], function(){

    Route::get('login', 'Auth\AdminAuthController@showLoginForm');
    Route::post('login', 'Auth\AdminAuthController@login');
    Route::get('logout', 'Auth\AdminAuthController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AdminAuthController@showRegistrationForm');
    Route::post('register', 'Auth\AdminAuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\AdminPasswordController@showResetForm');
    Route::post('password/email', 'Auth\AdminPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\AdminPasswordController@reset');

    Route::get('/', 'AdminController@index')->name('admin.dashboard');

});