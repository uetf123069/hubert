<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use Log;

use Hash;

use Validator;

use App\User;

use App\Provider;


define('DEFAULT_FALSE', 0);
define('DEFAULT_TRUE', 1);

define('DEVICE_ANDROID', 'android');
define('DEVICE_IOS', 'ios');

class ProviderApiController extends Controller
{
    public function __construct(Request $request)
	{
					
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
				
			if (! Helper::is_token_valid('PROVIDER', $provider_id, $token, $error)) {
				$response = Response::json($error, 200);
				return $response;
			}
		}
		
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
						'email' => 'required|email|unique:providers,email|max:255'
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
			$provider->name = $first_name;
			$provider->email = $email;
			$provider->mobile = $phone;
			$provider->password = Hash::make($password);
			
			$provider->is_approved = FALSE;
			$provider->is_activated = FALSE;
			$provider->is_email_activated = FALSE;
			$provider->email_activation_code = uniqid();

			$provider->login_by = $login_by;
			
			$provider->token = Helper::generate_token();
			$provider->token_expiry = Helper::generate_token_expiry();
			$provider->device_token = $device_token;
			$provider->device_type = $device_type;
				
			// Upload picture
			if($request->hasFile('picture'))
				$provider->picture = Helper::upload_picture($picture);
				
			$provider->save();
				
			// Send welcome email to the new provider
			$check_mail = Helper::send_provider_welcome_email($provider);

			Log::info('Provider welcome status check'." ".$check_mail);
			
			Log::info("New provider registration: ".print_r($provider, true));

			$response_array = array(
								'success' => true ,
								'message' => $provider ? Helper::get_message(105) : Helper::get_error_message(126),
								'id' 	=> $provider->id,
			                    'name' 	=> $provider->name,
			                    'phone' => $provider->mobile,
			                    'email' => $provider->email,
			                    'picture' => $provider->picture,
			                    'token' => $provider->token,
			                    'token_expiry' => $provider->token_expiry,
			                    'login_by' => $provider->login_by,
			                    'social_unique_id' => $provider->social_unique_id,
								);
		}
	
		$response = response()->json($response_array, 200);
		return $response;
	}

	public function login(Request $request)
	{
		// Social Login Pending

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

				// Check the email is activated
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
	
		$response = response()->json($response_array, 200);
		return $response;
	}

    public function forgot_password(Request $request)
    {
        $email = $request->email;
         // Validate the email field

        $validator = Validator::make(
            $request->all(),
            array(
                'email' => 'required|email',
            )
        );

        if ($validator->fails()) {

            $error_messages = $validator->messages()->all();
            $response_code = 200;
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);

        } else {

	        $provider_data = Provider::where('email',$email)->first();

	        if($provider_data)
	        {
	            $provider = $provider_data;

	            $new_password = Helper::generate_password();
	            $provider->password = Hash::make($new_password);
	            $provider->save();

	            $subject = "Your New Password";
	            $email_data = array();
	            $email_data['password']  = $new_password;

	            $email_send = Helper::send_provider_forgot_email($provider->email,$email_data,$subject);

	            $response_array = array();

                if($email_send == Helper::get_message(106)) {

                    $response_array['success'] = true;
                    $response_array['message'] = $email_send;
                    
                } else {
                    $response_array['success'] = false;
                    $response_array['message'] = $email_send;
                }

                $response_code = 200;

	        } else {

	            $response_array = array('success' => false, 'error' => Helper::get(125), 'error_code' => 125);
	            $response_code = 200;
	            
	        }

	        $response = response()->json($response_array, $response_code);
	        return $response;
	    }
    
    }
	
	public function details_fetch(Request $request)
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
            'mobile' => $provider->mobile,
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
	
	public function details_save(Request $request)
	{
		$validator = Validator::make(
				$request->all(),
				array(
						'name' => 'required|max:255',
						'mobile' => 'required|digits_between:6,13',
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
			$mobile = $request->phone;
			$picture = $request->file('picture');

			$provider->name = $name;
			if ($mobile != "")
				$provider->mobile = $mobile;

			// Upload picture
            if ($picture != ""){

                //deleting old image if exists

                Helper::delete_picture($provider->picture);

                $provider->picture = Helper::upload_picture($picture);
            }

            // Generate new tokens
            $provider->token = Helper::generate_token();
            $provider->token_expiry = Helper::generate_token_expiry();
			$provider->save();

            $response_array = array(
                'success' => true,
                'id' => $provider->id,
                'name' => $provider->name,
                'mobile' => $provider->mobile,
                'email' => $provider->email,
                'picture' => $provider->picture,
                'token' => $provider->token,
                'token_expiry' => $provider->token_expiry,
            );

            $response_array = Helper::null_safe($response_array);
		}
			
		$response = response()->json($response_array, 200);
		return $response;
	}
	
	public function tokenRenew(Request $request)
	{
		$validator = Validator::make(
				$request->all(),
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




