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

Route::get('/assign_next_provider_cron' , 'ApplicationController@assign_next_provider_cron');

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

	// Request Handle

	Route::post('/sendRequest', 'UserapiController@send_request');

	Route::post('/cancelRequest', 'UserapiController@cancel_request');

	Route::get('/paybypaypal', 'UserapiController@paybypaypal');

	Route::post('/requestStatusCheck', 'UserapiController@request_status_check');

	Route::post('/rateProvider', 'UserapiController@rate_provider');

	Route::post('/history' , 'UserapiController@history');

	Route::post('/singleRequest' , 'UserapiController@single_request');

	// Favourite Providers

	Route::get('/favProviders' , 'UserapiController@fav_providers');

	Route::post('/deleteFavProvider' , 'UserapiController@delete_fav_provider');

	// Cards 

	Route::post('/getCards', 'UserapiController@get_cards');

	Route::post('/addCard', 'UserapiController@add_card');

	Route::post('/defaultCard', 'UserapiController@default_card');

	Route::post('/deleteCard', 'UserapiController@delete_card');


});


Route::group(['prefix' => 'providerApi'], function(){

	Route::post('/register','ProviderApiController@register');

	Route::post('/login','ProviderApiController@login');
	
	Route::get('/userdetails','ProviderApiController@details_fetch');

	Route::post('/updateProfile', 'ProviderApiController@details_save');

	Route::post('/forgotpassword', 'ProviderApiController@forgot_password');

	Route::post('/changePassword', 'ProviderApiController@changePassword');

	Route::get('/tokenRenew', 'ProviderApiController@tokenRenew');

	Route::post('/serviceAccept', 'ProviderApiController@service_accept');

	Route::post('/serviceReject', 'ProviderApiController@service_reject');

	Route::post('/providerStarted', 'ProviderApiController@providerstarted');

	Route::post('/arrived', 'ProviderApiController@arrived');

	Route::post('/serviceStarted', 'ProviderApiController@servicestarted');

	Route::post('/serviceCompleted', 'ProviderApiController@servicecompleted');

	Route::post('/rateUser', 'ProviderApiController@rate_user');

	Route::post('/cancelrequest', 'ProviderApiController@cancelrequest');

	Route::post('/history', 'ProviderApiController@history');

	Route::post('/incomingRequest', 'ProviderApiController@get_incoming_request');

	Route::post('/requestStatusCheck', 'ProviderApiController@request_status_check');


});

// Admin Routes

Route::group(['prefix' => 'admin'], function(){

    Route::get('login', 'Auth\AdminAuthController@showLoginForm')->name('admin.login.form');
    Route::post('login', 'Auth\AdminAuthController@login')->name('admin.login.post');
    Route::get('logout', 'Auth\AdminAuthController@logout')->name('admin.logout');

    // Registration Routes...
    Route::get('register', 'Auth\AdminAuthController@showRegistrationForm');
    Route::post('register', 'Auth\AdminAuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\AdminPasswordController@showResetForm');
    Route::post('password/email', 'Auth\AdminPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\AdminPasswordController@reset');

    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    Route::get('/settings', 'AdminController@settings')->name('admin.settings');

    //Documents

    Route::get('/documents', 'AdminController@documents')->name('adminDocuments');

    Route::get('/adddocument', 'AdminController@adddocument')->name('adminAddDocument');

    Route::post('/adddocumentProcess', 'AdminController@adddocumentProcess')->name('adminAddDocumentProcess');

    Route::get('/editdocument/{id}', 'AdminController@editDocument')->name('adminDocumentEdit');

    Route::get('/deletedocument/{id}', 'AdminController@deleteDocument')->name('adminDocumentDelete');

    //Service Types

    Route::get('/serviceTypes', 'AdminController@serviceTypes')->name('adminServices');

    Route::get('/addServiceType', 'AdminController@addServiceType')->name('adminAddServices');

    Route::post('/addServiceProcess', 'AdminController@addServiceProcess')->name('adminAddServiceProcess');

    Route::get('/editService/{id}', 'AdminController@editService')->name('adminServiceEdit');

    Route::get('/deleteService/{id}', 'AdminController@deleteService')->name('adminServiceDelete');

    //Reviews & Ratings

    Route::get('/userReviews', 'AdminController@userReviews')->name('adminUserReviews');

    Route::get('/providerReviews', 'AdminController@providerReviews')->name('adminProviderReviews');

    Route::get('/providerReviewDelete/{id}', 'AdminController@deleteProviderReviews')->name('adminProviderReviewDelete');

    Route::get('/userReviewDelete/{id}', 'AdminController@deleteUserReviews')->name('adminUserReviewDelete');

    Route::get('/payment', 'AdminController@settings')->name('admin.settings');

    Route::get('/requests', 'AdminController@requests')->name('adminRequests');


    //User Routes
    Route::get('/users', 'AdminController@users')->name('admin.user');

    Route::get('/addUser', 'AdminController@addUser')->name('admin.adduser');

    Route::get('/editUser/{id}', 'AdminController@editUser')->name('adminUserEdit');

    Route::get('/deleteUser/{id}', 'AdminController@deleteUser')->name('adminUserDelete');

    Route::get('/UserHistory/{id}', 'AdminController@UserHistory')->name('adminUserHistory');

    Route::post('/addUserProcess', 'AdminController@addUserProcess')->name('admin.addUserProcess');

    //Provider Routes
    Route::get('/providers', 'AdminController@providers')->name('admin.provider');

    Route::get('/addProvider', 'AdminController@addProvider')->name('admin.addprovider');

    Route::get('/editProvider/{id}', 'AdminController@editProvider')->name('adminProviderEdit');

    Route::get('/deleteProvider/{id}', 'AdminController@deleteProvider')->name('adminProviderDelete');

    Route::get('/ProviderHistory/{id}', 'AdminController@ProviderHistory')->name('adminProviderHistory');

    Route::post('/addProviderProcess', 'AdminController@addProviderProcess')->name('adminaddProviderProcess');

    Route::get('/ProviderApprove/{id}/{status}', 'AdminController@ProviderApprove')->name('adminProviderApprove');

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

