<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

class UserapiController extends Controller
{
    public function __construct()
	{
		$this->beforeFilter(function() {

			$validator = Validator::make(
					Input::all(),
					array(
							'token' => 'required|min:5',
							'id' => 'required|integer'
					));

			if ($validator->fails()) {
                $error_messages = $validator->messages()->all();
				$response = array('success' => false, 'error' => get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
				return $response;
			} else {
				$token = Input::get('token');
				$user_id = Input::get('id');

				if (! Helper::is_token_valid(USER, $user_id, $token, $error)) {
					$response = Response::json($error, 200);
					return $response;
				}
			}
		}, array('except' => array(
				'register',
				'login','forgot_password')
		));
	}
}
