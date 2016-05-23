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
    Route::get('/', 'AdminController@settings')->name('admin.settings');


    //User Routes
    Route::get('/users', 'AdminController@users')->name('admin.user');
    Route::get('/addUser', 'AdminController@addUser')->name('admin.adduser');

    //Provider Routes
    Route::get('/providers', 'AdminController@providers')->name('admin.provider');
    Route::get('/addProvider', 'AdminController@addProvider')->name('admin.addprovider');

});

Route::group([], function(){

    Route::get('login', 'Auth\AuthController@showLoginForm')->name('user.login.form');
    Route::post('login', 'Auth\AuthController@login')->name('user.login.post');
    Route::get('logout', 'Auth\AuthController@logout')->name('user.logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm')->name('user.register.form');
    Route::post('register', 'Auth\AuthController@register')->name('user.register.post');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    Route::get('/', 'UserController@index')->name('user.dashboard');

    Route::get('/services', 'UserController@services')->name('user.services.list');
    Route::get('/request', 'UserController@request')->name('user.services.request');
    Route::get('/profile', 'UserController@profile')->name('user.profile');

});

