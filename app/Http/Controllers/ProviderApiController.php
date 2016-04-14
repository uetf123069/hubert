<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use Log;

use App\User;

use App\Provider;


define('DEFAULT_FALSE', 0);
define('DEFAULT_TRUE', 1);

class ProviderApiController extends Controller
{
    public function __construct()
	{
		$this->beforeFilter(function(Request $request) {
				
			$validator = Validator::make(
					$request->all(),
					array(
							'token' => 'required|min:5',
							'id' => 'required|integer'
					));
				
			if ($validator->fails()) {
                $error_messages = $validator->messages()->all();
				$response = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
				return $response;
			} else {
				$token = $request->token;
				$provider_id = $request->id;
					
				if (! is_token_valid(PROVIDER, $provider_id, $token, $error)) {
					$response = Response::json($error, 200);
					return $response;
				}
			}
		}, array('except' => array(
				'register',
				'login',
                'forgot_password')
		));
	}

	public function register(Request $request)
	{
		$validator = Validator::make(
				$request->all(),
				array(
						'name' => 'required|max:255',
						'phone' => 'required|digits_between:6,13',
						'password' => 'required|min:6',
						'picture' => 'mimes:jpeg,bmp,png',
						'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
						'device_token' => 'required'
				));
		$email_validator = Validator::make(
				$request->all(),
				array(
						'email' => 'required|email|unique:provider,email|max:255'
				));
		if ($email_validator->fails()) {
			$response_array = array('success' => false, 'error' => Helper::get_error_message(102), 'error_code' => 102);
		} else if ($validator->fails()) {
			$response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101);
		} else {
			$first_name = $request->name;
			$email = $request->email;
			$phone = $request->phone;
			$password = $request->password;
			$picture = $request->file('picture');
			$device_token = $request->device_token;
			$device_type = $request->device_type;
			$login_by = $request->login_by;				
				
			$provider = new Provider;
			$provider->name = $name;
			$provider->email = $email;
			$provider->phone = $phone;
			$provider->password = Hash::make($password);
			
			$provider->is_approved = FALSE;
			$provider->is_activated = FALSE;
			$provider->is_email_activated = FALSE;
			$provider->email_activation_code = uniqid();
			
			$provider->token = generate_token();
			$provider->token_expiry = generate_token_expiry();
			$provider->device_token = $device_token;
			$provider->device_type = $device_type;
				
			// Upload picture
			$provider->picture = Helper::upload_picture($picture);
				
			$provider->save();
				
			// Send welcome email to the new provider
			Helper::send_provider_welcome_email($provider);
			
			Log::info("New provider registration: ".print_r($provider, true));
			$response_array = array('success' => true);
		}
	
		$response = response()->json($response_array, 200);
		return $response;
	}

	public function login(Request $request)
	{
		$validator = Validator::make(
				$request->all(),
				array(
						'email' => 'required|email',
						'password' => 'required',
						'device_token' => 'required',
						'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
				));
	
		if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
		} else {
			$email = $request->email;
			$password = $request->password;
			$device_token = $request->device_token;
			$device_type = $request->device_type;
				
			// Validate the provider credentials
			if ($provider = Provider::where('email', '=', $email)->first()) {
				if ($provider->is_email_activated) {
					if (Hash::check($password, $provider->password)) {
						// Generate new tokens
						$provider->token = Helper::generate_token();
						$provider->token_expiry = Helper::generate_token_expiry();
						
						// Save device details
						$provider->device_token = $device_token;
						$provider->device_type = $device_type;
							
						$provider->save();
							
						// Respond with provider details
						$response_array = array(
                            'success' => true,
                            'id' => $provider->id,
                            'name' => $provider->name,
                            'phone' => $provider->phone,
                            'email' => $provider->email,
                            'picture' => $provider->picture,
                            'token' => $provider->token,
                            'token_expiry' => $provider->token_expiry,
                            'active' => boolval($provider->is_activated)
						);
						$response_array = Helper::null_safe($response_array);
					} else {
						$response_array = array(
								'success' => false,
								'error' => Helper::get_error_message(105),
								'error_code' => 105
						);
					}
				} else {
					$response_array = array(
							'success' => false,
							'error' => Helper::get_error_message(111),
							'error_code' => 111
					);
				}
			} else {
				$response_array = array(
						'success' => false,
						'error' => Helper::get_error_message(105),
						'error_code' => 105
				);
			}
				
		}
	
		$response = $response()->json($response_array, 200);
		return $response;
	}

    public function forgot_password()
    {
        $email = $request->email;
        $provider_data = Provider::where('email',$email)->first();
        if($provider_data)
        {
            $provider = Provider::find($provider_data->id);
            $new_password = Helper::generate_password();
            $provider->password = Hash::make($new_password);
            $provider->save();

            $subject = "Your New Password";
            $email_data = array();
            $email_data['password']  = $new_password;
            Helper::send_provider_forgot_email($provider->email,$email_data,$subject);

            $response_array = array();
            $response_array['success'] = true;
            $response_code = 200;
            $response = response()->json($response_array, $response_code);
            return $response;

        }
        else{
            $response_array = array('success' => false, 'error' => 'This Email is not registered', 'error_code' => 425);
            $response_code = 200;
            $response = Response::json($response_array, $response_code);
            return $response;
        }
    }
	
	public function details_fetch()
	{

		$provider = Provider::find($request->id);

        // Generate new tokens
        $provider->token = Helper::generate_token();
        $provider->token_expiry = Helper::generate_token_expiry();
        $provider->token_refresh = Helper::generate_token();
        $provider->save();

		$response_array = array(
            'success' => true,
            'id' => $provider->id,
            'name' => $provider->name,
            'phone' => $provider->phone,
            'email' => $provider->email,
            'picture' => $provider->picture,
            'token' => $provider->token,
            'token_expiry' => $provider->token_expiry,
            'timezone' => $provider->timezone,
            'active' => boolval($provider->is_activated)
		);
		$response_array = Helper::null_safe($response_array);
	
		$response = response()->json($response_array, 200);
		return $response;
	}
	
	public function details_save()
	{
		$validator = Validator::make(
				Input::all(),
				array(
						'name' => 'required|max:255',
						'phone' => 'required|digits_between:6,13',
						'picture' => 'mimes:jpeg,bmp,png',
				));
			
		if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response_array = array(
                'success' => false,
                'error' => Helper::get_error_message(101),
                'error_code' => 101,
                'error_messages' => $error_messages
            );
		} else {
			$provider = Provider::find($request->id);
					
			$name = $request->name;
			$phone = $request->phone;
			$picture = $request->file('picture');

			$provider->name = $name;
			if ($phone != "")
				$provider->phone = $phone;

			// Upload picture
            if ($picture != ""){
                //deleting old image if exists
                File::delete( public_path() . "/uploads/" . basename($provider->picture) );
                $provider->picture = upload_picture($picture);
            }

            // Generate new tokens
            $provider->token = Helper::generate_token();
            $provider->token_expiry = Helper::generate_token_expiry();
			$provider->save();

            $response_array = array(
                'success' => true,
                'id' => $provider->id,
                'name' => $provider->name,
                'phone' => $provider->phone,
                'email' => $provider->email,
                'picture' => $provider->picture,
                'token' => $provider->token,
                'token_expiry' => $provider->token_expiry,
            );

            $response_array = Helper::null_safe($response_array);
		}
			
		$response = Response::json($response_array, 200);
		return $response;
	}
	
	function renew_token()
	{
		$validator = Validator::make(
				Input::all(),
				array(
						'id' => 'required|integer',
						'token_refresh' => 'required'
				));
	
		if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
		} else {
			$provider_id = $request->id;
			$token_refresh = $request->token_refresh;
				
			// Check if refresher token is valid
			if ($provider = Provider::where('id', '=', $provider_id)->first()) {
	
				// Generate new tokens
				$provider->token = Helper::generate_token();
				$provider->token_expiry = Helper::generate_token_expiry();
				$provider->token_refresh = Helper::generate_token();
	
				$provider->save();
	
				$response_array = array(
						'success' => true,
						'token' => $provider->token,
				);
			} else {
				$response_array = array(
						'success' => false,
						'error' => Helper::get_error_message(115),
						'error_code' => 115
				);
			}
		}
	
		$response = response()->json($response_array, 200);
		return $response;
	}
	
	public function location_update()
	{
		$validator = Validator::make(
				Input::all(),
				array(
						'latitude' => 'required',
						'longitude' => 'required'
				));
			
		if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response_array = array(
                'success' => false,
                'error' => Helper::get_error_message(101),
                'error_code' => 101,
                'error_messages' => $error_messages
            );
		} else {
			$provider = Provider::find($request->id);
			
			$provider->latitude = $request->latitude;
			$provider->longitude = $request->longitude;
			$provider->save();

			$response_array = array(
                'success' => true,
                'latitude' => $provider->latitude,
                'longitude' => $provider->longitude
            );
		}
	
		$response = response()->json($response_array, 200);
		return $response;
	}

    public function status()
    {
        $provider = Provider::find($request->id);
        $active = $provider->is_activated;

        $response_array = array(
            'success' => true,
            'active' => $active
        );

        $response = response()->json($response_array, 200);
        return $response;
    }

	public function status_update()
	{

        $provider = Provider::find($request->id);
        $activeState = $provider->is_active;
        $activeState = $activeState ? DEFAULT_FALSE : DEFAULT_TRUE;
        $provider->is_activated = $activeState;
        $provider->save();

        $response_array = array(
                'success' => true,
                'active' => $provider->is_activated
        );

		$response = response()->json($response_array, 200);
		return $response;
	}
}
