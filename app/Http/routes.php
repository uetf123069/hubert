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

	Route::get('/userDetails','UserapiController@user_details');

	Route::post('/updateProfile', 'UserapiController@update_profile');

	Route::post('/forgotpassword', 'UserapiController@forgot_password');

	Route::post('/changePassword', 'UserapiController@change_password');

	Route::get('/tokenRenew', 'UserapiController@token_renew');

	// Service Types Handle

	Route::post('/serviceList', 'UserapiController@service_list');

	Route::post('/singleService', 'UserapiController@single_service');

	// Payment modes 

	Route::get('/getPaymentModes' , 'UserapiController@get_payment_modes');

	// Request Handle

	Route::post('/guestProviderList', 'UserapiController@guest_provider_list');

	// Automated request
	Route::post('/sendRequest', 'UserapiController@send_request');

	// Manual request
	Route::post('/manual_create_request', 'UserapiController@manual_create_request');


	Route::post('/cancelRequest', 'UserapiController@cancel_request');

	Route::post('/waitingRequestCancel' ,'UserapiController@waiting_request_cancel');

	Route::post('/requestStatusCheck', 'UserapiController@request_status_check');

	Route::post('/payment' , 'UserapiController@paynow');

	Route::post('/paybypaypal', 'UserapiController@paybypaypal');

	Route::post('/rateProvider', 'UserapiController@rate_provider');

	Route::post('/history' , 'UserapiController@history');

	Route::post('/singleRequest' , 'UserapiController@single_request');

	// Favourite Providers

	Route::post('/addFavProvider' , 'UserapiController@add_fav_provider');

	Route::get('/favProviders' , 'UserapiController@fav_providers');

	Route::post('/deleteFavProvider' , 'UserapiController@delete_fav_provider');

	// Cards 

	Route::post('/getUserPaymentModes', 'UserapiController@get_user_payment_modes');

	Route::post('/PaymentModeUpdate', 'UserapiController@payment_mode_update');

	Route::post('/addCard', 'UserapiController@add_card');

	Route::post('/defaultCard', 'UserapiController@default_card');

	Route::post('/deleteCard', 'UserapiController@delete_card');


});


Route::group(['prefix' => 'providerApi'], function(){

	Route::post('/register','ProviderApiController@register');

	Route::post('/login','ProviderApiController@login');

	
	Route::get('/userdetails','ProviderApiController@profile');

	Route::post('/updateProfile', 'ProviderApiController@update_profile');

	Route::post('/forgotpassword', 'ProviderApiController@forgot_password');

	Route::post('/changePassword', 'ProviderApiController@changePassword');

	Route::get('/tokenRenew', 'ProviderApiController@tokenRenew');

	Route::post('locationUpdate' , 'ProviderApiController@location_update');

	Route::get('checkAvailableStatus' , 'ProviderApiController@check_available');

	Route::post('availableUpdate' , 'ProviderApiController@available_update');


	Route::post('/serviceAccept', 'ProviderApiController@service_accept');

	Route::post('/serviceReject', 'ProviderApiController@service_reject');

	Route::post('/providerStarted', 'ProviderApiController@providerstarted');

	Route::post('/arrived', 'ProviderApiController@arrived');

	Route::post('/serviceStarted', 'ProviderApiController@servicestarted');

	Route::post('/serviceCompleted', 'ProviderApiController@servicecompleted');

	Route::post('/rateUser', 'ProviderApiController@rate_user');

	Route::post('/cancelrequest', 'ProviderApiController@cancelrequest');

	Route::post('/history', 'ProviderApiController@history');

	Route::post('/singleRequest' , 'ProviderApiController@single_request');

	Route::post('/incomingRequest', 'ProviderApiController@get_incoming_request');

	Route::post('/requestStatusCheck', 'ProviderApiController@request_status_check');


});

Route::get('/assign_next_provider_cron' , 'ApplicationController@assign_next_provider_cron');









