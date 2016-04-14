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
	
	Route::post('/socialSignup','UserapiController@socialSignup');

	Route::post('/login','UserapiController@login');

	Route::get('/profile', 'UserapiController@profile');

	Route::post('/updateProfile', 'UserapiController@updateProfile');

	Route::get('/forgotpassword', 'UserapiController@Forgotpassword');

});