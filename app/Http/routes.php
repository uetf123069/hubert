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
	
	Route::post('/login','UserapiController@login');

	Route::get('/userDetails','UserapiController@userDetails');

	Route::post('/updateProfile', 'UserapiController@updateProfile');

	Route::post('/forgotpassword', 'UserapiController@forgot_password');

	Route::post('/changePassword', 'UserapiController@changePassword');

	Route::get('/tokenRenew', 'UserapiController@tokenRenew');

	Route::post('/serviceList', 'UserapiController@serviceList');

	Route::post('/singleService', 'UserapiController@singleService');

	Route::post('/sendRequest', 'UserapiController@sendRequest');

	Route::post('/cancelRequest', 'UserapiController@cancelRequest');

	Route::get('/paybypaypal', 'UserapiController@paybypaypal');

	Route::get('/requestStatusCheck', 'UserapiController@requestStatusCheck');

	Route::get('/history' , 'UserapiController@history');

	Route::get('/favProviders' , 'UserapiController@fav_providers');

	Route::post('/deleteFavProvider' , 'UserapiController@deleteFavProvider');

	Route::post('/feedback', 'UserapiController@feedback');

});


Route::group(['prefix' => 'providerApi'], function(){

	Route::post('/register','ProviderApiController@register');

	Route::post('/login','ProviderApiController@login');
	
	Route::get('/userdetails','ProviderApiController@details_fetch');

	Route::post('/updateProfile', 'ProviderApiController@details_save');

	Route::post('/forgotpassword', 'ProviderApiController@forgot_password');

	Route::post('/changePassword', 'ProviderApiController@changePassword');

	Route::get('/tokenRenew', 'ProviderApiController@tokenRenew');

	Route::post('/serviceaccept', 'ProviderApiController@service_accept');

	Route::post('/servicedecline', 'ProviderApiController@service_decline');

	Route::post('/providerstarted', 'ProviderApiController@providerstarted');

	Route::post('/arrived', 'ProviderApiController@arrived');

	Route::post('/servicestarted', 'ProviderApiController@servicestarted');

	Route::post('/servicecompleted', 'ProviderApiController@servicecompleted');

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

Route::group([], function(){

    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    Route::get('/', 'UserController@index')->name('user.dashboard');

});