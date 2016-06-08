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

    Route::get('/mapview', 'AdminController@mapview')->name('admin.mapmapview');

    Route::get('/profile', 'AdminController@profile')->name('adminProfile');

    Route::post('/profileProcess', 'AdminController@profileProcess')->name('adminProfileProcess');

    Route::get('/settings', 'AdminController@settings')->name('admin.settings');

    Route::get('/payment', 'AdminController@payment')->name('adminPayment');

    Route::post('/settingsProcess', 'AdminController@settingsProcess')->name('adminSettingProcess');

    Route::get('/help', 'AdminController@help')->name('admin.help');

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

    Route::get('/providerDocuments', 'AdminController@providerDocuments')->name('adminProviderDocument');

    Route::get('/requests', 'AdminController@requests')->name('adminRequests');

    Route::get('/viewRequest/{id}', 'AdminController@ViewRequest')->name('adminViewRequest');


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

Route::get('/', 'UserController@index')->name('user.dashboard');

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

    Route::get('/services', 'UserController@services')->name('user.services.list');

    Route::get('favorite', 'UserController@favorite_provider_list')->name('user.favorite.provider.list');
    Route::delete('favorite', 'UserController@favorite_provider_delete')->name('user.favorite.provider.del');

    Route::get('/request', 'UserController@request_form')->name('user.services.request');
    Route::post('/request', 'UserController@request_submit')->name('user.services.request.submit');
    Route::delete('/request', 'UserController@request_cancel')->name('user.services.request.cancel');
    Route::get('/request/updates', 'UserController@request_updates')->name('user.services.updates');
    Route::post('/request/payment', 'UserController@request_payment')->name('user.services.request.payment');
    Route::post('/request/review', 'UserController@request_review')->name('user.services.request.review');

    Route::get('/profile', 'UserController@profile_form')->name('user.profile.form');
    Route::post('/profile', 'UserController@profile_save')->name('user.profile.save');
    Route::post('/profile/password', 'UserController@profile_save_password')->name('user.profile.password');

    Route::get('/payment', 'UserController@payment_form')->name('user.payment.form');
    Route::post('/payment', 'UserController@payment_card_add')->name('user.payment.card.add');
    Route::patch('/payment', 'UserController@payment_card_def')->name('user.payment.card.def');
    Route::delete('/payment', 'UserController@payment_card_del')->name('user.payment.card.del');
    Route::post('/payment/paypal', 'UserController@payment_update_paypal')->name('user.payment.paypal');
    Route::get('/paypal/{id}','PaypalController@pay')->name('paypal');

    Route::get('/user/payment/status','PaypalController@getPaymentStatus')->name('paypalstatus');

    Route::get('/test', 'UserController@test')->name('user.test');

});


Route::group(['prefix' => 'provider'], function(){

    Route::get('login', 'Auth\ProviderAuthController@showLoginForm')->name('provider.login.form');
    Route::post('login', 'Auth\ProviderAuthController@login')->name('provider.login.post');
    Route::get('logout', 'Auth\ProviderAuthController@logout')->name('provider.logout');

    // Registration Routes...
    Route::get('register', 'Auth\ProviderAuthController@showRegistrationForm');
    Route::post('register', 'Auth\ProviderAuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\ProviderPasswordController@showResetForm');
    Route::post('password/email', 'Auth\ProviderPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ProviderPasswordController@reset');

    Route::get('/', 'ProviderController@index')->name('provider.dashboard');

    Route::get('/history', 'ProviderController@history')->name('provider.history');
    Route::get('/ongoing', 'ProviderController@ongoing')->name('provider.ongoing');
    Route::get('/documents', 'ProviderController@documents')->name('provider.documents');
    Route::get('/profile', 'ProviderController@profile')->name('provider.profile');
    Route::post('/profile', 'ProviderController@profile_save')->name('provider.profile.save');

    Route::post('/profile/password', 'ProviderController@password')->name('provider.password');
    Route::post('/change/state', 'ProviderController@change_state')->name('provider.change.state');
    Route::post('/update/location', 'ProviderController@update_location')->name('provider.update.location');
    Route::post('/upload/documents', 'ProviderController@upload_documents')->name('provider.upload.documents');
    Route::get('/document/{document_id}', 'ProviderController@delete_document')->name('provider.delete.document');

    Route::get('/incoming_request', 'ProviderController@incoming_request')->name('provider.incoming.request');
    Route::get('/request/accept', 'ProviderController@accept_request')->name('provider.request.accept');
    Route::get('/request/decline', 'ProviderController@decline_request')->name('provider.request.decline');
    Route::post('/switch/state', 'ProviderController@switch_state')->name('provider.switch.state');
    Route::post('/submit/review', 'ProviderController@submit_review')->name('provider.submit.review');
    Route::post('/cancel/service', 'ProviderController@cancel_service')->name('provider.cancel.service');


});




