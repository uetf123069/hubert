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
	
	Route::get('/userdetails','UserapiController@details_fetch');

	Route::post('/login','UserapiController@login');

	Route::post('/updateProfile', 'UserapiController@details_save');

	Route::post('/forgotpassword', 'UserapiController@forgot_password');

});


Route::group(['prefix' => 'providerApi'], function(){

	Route::post('/register','ProviderApiController@register');
	
	Route::get('/userdetails','ProviderApiController@details_fetch');

	Route::post('/login','ProviderApiController@login');

	Route::post('/updateProfile', 'ProviderApiController@details_save');

	Route::post('/forgotpassword', 'ProviderApiController@forgot_password');

});









