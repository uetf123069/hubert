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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register','UserapiController@register');

Route::group(['prefix' => 'userApi'], function(){

	Route::post('/register','UserapiController@register');
	
	Route::post('/login','UserapiController@login');

	Route::get('/userDetails','UserapiController@userDetails');

	Route::post('/updateProfile', 'UserapiController@updateProfile');

	Route::post('/forgotpassword', 'UserapiController@forgotPassword');

	Route::post('/changePassword', 'UserapiController@changePassword');

	Route::get('/tokenRenew', 'UserapiController@tokenRenew');

	// Service Types Handle

	Route::post('/serviceList', 'UserapiController@serviceList');

	Route::post('/singleService', 'UserapiController@singleService');

	// Request Handle

	Route::post('/sendRequest', 'UserapiController@sendRequest');

	Route::post('/cancelRequest', 'UserapiController@cancelRequest');

	Route::get('/paybypaypal', 'UserapiController@paybypaypal');

	Route::get('/requestStatusCheck', 'UserapiController@requestStatusCheck');

	Route::post('/rateProvider', 'UserapiController@rateProvider');

	Route::get('/history' , 'UserapiController@history');

	// Favourite Providers

	Route::get('/favProviders' , 'UserapiController@fav_providers');

	Route::post('/deleteFavProvider' , 'UserapiController@deleteFavProvider');

	// Cards 

	Route::post('/getCards', 'UserapiController@getCards');

	Route::post('/addCard', 'UserapiController@addCard');

	Route::post('/defaultCard', 'UserapiController@defaultCard');

	Route::post('/deleteCard', 'UserapiController@deleteCard');


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

	Route::post('/rateuser', 'ProviderApiController@rate_user');

	Route::post('/cancelrequest', 'ProviderApiController@cancelrequest');

	Route::post('/history', 'ProviderApiController@history');

	Route::post('/incomingrequest', 'ProviderApiController@get_incoming_request');

	Route::post('/requeststatuscheck', 'ProviderApiController@request_status_check');


});









