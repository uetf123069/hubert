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
		$this->middleware('ProviderApiVal' , ['except' => ['register' , 'login' , 'forgot_password']]);
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

	public function service_decline(Request $request)
	{
		$validator = Validator::make(
				Input::all(),
				array(
						'request_id' => 'required|integer|exists:requests,id',
				));
			
		if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
			$response_array = array(
                'success' => false,
                'error' => get_error_message(101),
                'error_code' => 101,
                'error_messages' => $error_messages
            );
		} else {
			$provider = Provider::find($request->id);
			$request_id = $request->request_id;
            $requests = Requests::find($request_id);
            //Check whether the request is cancelled by user.
            if($requests->status == REQUEST_CANCELLED) {
                $response_array = array(
                    'success' => false,
                    'error' => get_error_message(117),
                    'error_code' => 117
                );
            }else {
                // Verify if request was indeed offered to this provider
                $request_meta = RequestMeta::where('request_id', '=', $request_id)
                    ->where('provider_id', '=', $provider->id)
                    ->where('status', '=', REQUEST_SEND)->first();

                if (!$request_meta) {
                    // This request has not been offered to this provider. Abort.
                    $response_array = array(
                        'success' => false,
                        'error' => get_error_message(101),
                        'error_code' => 101);
                } else {
                    // Decline this offer
                    $request_meta->status = REQUEST_CANCELLED;
                    $request_meta->save();

                    $provider->available = PROVIDER_IS_AVAILABLE;
                    $provider->save();

                    $response_array = array('success' => true);

                    //Select the new provider who is in the next position.
                    $request_meta_next = RequestMeta::where('request_id', '=', $request_id)->where('status', REQUEST_META_NONE)
                                        ->leftJoin('provider', 'provider.id', '=', 'request_meta.provider_id')
                                        ->where('provider.is_active',DEFAULT_TRUE)
                                        ->where('provider.available',DEFAULT_TRUE)
                                        ->select('request_meta.id','request_meta.status')
                                        ->orderBy('request_meta.created_at')->first();
                    if($request_meta_next){
                        //Assign the next provider.
                        $request_meta_next->status = REQUEST_SEND;
                        $request_meta_next->save();
                        //Update the request start time in request table
                        Requests::where('id', '=', $request->id)->update( array('request_start_time' => date("Y-m-d H:i:s")) );
                    }

                }
            }
		}
		
		$response = Response::json($response_array, 200);
		return $response;
	}
	
	public function service_accept(Request $request)
	{
		$validator = Validator::make(
				Input::all(),
				array(
						'request_id' => 'required|integer|exists:requests,id'
				));
			
		if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
			$response_array = array(
                'success' => false,
                'error' => get_error_message(101),
                'error_code' => 101,
                'error_messages' => $error_messages
            );
		} else {
			$provider = Provider::find($request->id);
			$request_id = $request->request_id;
            $requests = Requests::find($request_id);
            //Check whether the request is cancelled by user.
		    if($requests->status == REQUEST_CANCELLED) {
                $response_array = array(
                    'success' => false,
                    'error' => get_error_message(117),
                    'error_code' => 117
                );
            }else{
                // Verify if request was indeed offered to this provider
                $request_meta = RequestMeta::where('request_id', '=', $request_id)
                    ->where('provider_id', '=', $provider->id)
                    ->where('status', '=', REQUEST_SEND)->first();

                if (!$request_meta) {
                    // This request has not been offered to this provider. Abort.
                    $response_array = array(
                        'success' => false,
                        'error' => get_error_message(101),
                        'error_code' => 101);
                } else {
                    // Accept the offer
                    $requests->confirmed_provider = $provider->id;
                    $requests->status = REQUEST_INPROGRESS;
                    $requests->provider_status = PROVIDER_ACCEPTED;
                    $requests->save();

                    $provider->available = PROVIDER_NOT_AVAILABLE;
                    $provider->save();

                    /*Send Push Notification to User*/
                    send_push_notification($requests->user_id, USER, 'Service Accepted', 'The Service is accepted by provider.');

                    // No longer need request specific rows from RequestMeta
                    RequestMeta::where('request_id', '=', $request_id)->delete();

                    $requestData = array(
                        'request_id' => $requests->id,
                        'user_id' => $requests->user_id,
                        'request_type' => $requests->request_type,
                    );
                    $response_array = array(
                        'success' => true,
                        'data' => $requestData);
                }
            }
		}
		// Send Notification to User
		
		$response = Response::json($response_array, 200);
		return $response;
	}

	public function providerstarted(Request $request)
	{
        $provider = Provider::find($request->id);
		$validator = Validator::make(
            Input::all(),
            array(
                'request_id' => 'required|integer|exists:request,id,confirmed_provider,'.$provider->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to provider:'.$provider->id
            )
        );
		
		if ($validator->fails()) 
		{
            $error_messages = $validator->messages()->all();
            $response_array = array(
                'success' => false,
                'error' => get_error_message(101),
                'error_code' => 101,
                '$error_messages' => $error_messages
            );
            Log::info('Input Error::'.print_r($error_messages,true));
		} 
		else 
		{

			$request_id = $request->request_id;
			$current_state = PROVIDER_STARTED;

			$requests = Requests::where('id', '=', $request_id)
								->where('confirmed_provider', '=', $provider->id)
								->first();

			// Current state being validated in order to prevent accidental change of state
			if ($requests && intval($requests->provider_status) != $current_state ) 
			{
	            $requests->status = REQUEST_INPROGRESS;
	            $requests->provider_status = PROVIDER_STARTED;
    			$requests->save();
	            /*Send Push Notification to User*/
	            send_push_notification($requests->user_id, USER, 'Provider Started', 'Provider started from location');
           
				$response_array = array(
						'success' => true,
						'new_state' => $new_state
				);
			} else {
				$response_array = array('success' => false, 'error' => get_error_message(101), 'error_code' => 101);
                Log::info('Provider status Error:: Old state='.$requests->provider_status.' and current state='.$current_state);
			}
		}

		$response = Response::json($response_array, 200);
		return $response;
	}

	public function arrived(Request $request)
	{
        $provider = Provider::find($request->id);
		$validator = Validator::make(
            Input::all(),
            array(
                'request_id' => 'required|integer|exists:request,id,confirmed_provider,'.$provider->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to provider:'.$provider->id
            )
        );
		
		if ($validator->fails()) 
		{
            $error_messages = $validator->messages()->all();
            $response_array = array(
                'success' => false,
                'error' => get_error_message(101),
                'error_code' => 101,
                '$error_messages' => $error_messages
            );
            Log::info('Input Error::'.print_r($error_messages,true));
		} 
		else 
		{

			$request_id = $request->request_id;
			$current_state = PROVIDER_ARRIVED;

			$requests = Requests::where('id', '=', $request_id)
								->where('confirmed_provider', '=', $provider->id)
								->first();

			// Current state being validated in order to prevent accidental change of state
			if ($requests && intval($requests->provider_status) != $current_state ) 
			{
	            $requests->status = REQUEST_INPROGRESS;
	            $requests->provider_status = PROVIDER_ARRIVED;
    			$requests->save();
	            /*Send Push Notification to User*/
	            send_push_notification($requests->user_id, USER, 'Provider Arrived', 'Provider arrived to your location');
           
				$response_array = array(
						'success' => true,
						'new_state' => $new_state
				);
			} else {
				$response_array = array('success' => false, 'error' => get_error_message(101), 'error_code' => 101);
                Log::info('Provider status Error:: Old state='.$requests->provider_status.' and current state='.$current_state);
			}
		}

		$response = Response::json($response_array, 200);
		return $response;
	}

	public function servicestarted(Request $request)
	{
        $provider = Provider::find($request->id);
		$validator = Validator::make(
            Input::all(),
            array(
                'request_id' => 'required|integer|exists:request,id,confirmed_provider,'.$provider->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to provider:'.$provider->id
            )
        );
		
		if ($validator->fails()) 
		{
            $error_messages = $validator->messages()->all();
            $response_array = array(
                'success' => false,
                'error' => get_error_message(101),
                'error_code' => 101,
                '$error_messages' => $error_messages
            );
            Log::info('Input Error::'.print_r($error_messages,true));
		} 
		else 
		{

			$request_id = $request->request_id;
			$current_state = PROVIDER_SERVICE_STARTED;

			$requests = Requests::where('id', '=', $request_id)
								->where('confirmed_provider', '=', $provider->id)
								->first();

			// Current state being validated in order to prevent accidental change of state
			if ($requests && intval($requests->provider_status) != $current_state ) 
			{
				if($request->hasFile('before_image'))
				{
					$image = $request->file('before_image');
					$requests->before_image = Helper::upload_picture($image);
				}
				$requests->start_time = date("Y-m-d H:i:s");
	            $requests->status = REQUEST_INPROGRESS;
	            $requests->provider_status = PROVIDER_SERVICE_STARTED;
    			$requests->save();
	            /*Send Push Notification to User*/
	            send_push_notification($requests->user_id, USER, 'Provider Service Started', 'Provider service Started');
           
				$response_array = array(
						'success' => true,
						'new_state' => $new_state
				);
			} else {
				$response_array = array('success' => false, 'error' => get_error_message(101), 'error_code' => 101);
                Log::info('Provider status Error:: Old state='.$requests->provider_status.' and current state='.$current_state);
			}
		}

		$response = Response::json($response_array, 200);
		return $response;
	}

	public function servicecompleted(Request $request)
	{
        $provider = Provider::find($request->id);
		$validator = Validator::make(
            Input::all(),
            array(
                'request_id' => 'required|integer|exists:request,id,confirmed_provider,'.$provider->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to provider:'.$provider->id
            )
        );
		
		if ($validator->fails()) 
		{
            $error_messages = $validator->messages()->all();
            $response_array = array(
                'success' => false,
                'error' => get_error_message(101),
                'error_code' => 101,
                '$error_messages' => $error_messages
            );
            Log::info('Input Error::'.print_r($error_messages,true));
		} 
		else 
		{

			$request_id = $request->request_id;
			$current_state = PROVIDER_SERVICE_COMPLETED;

			$requests = Requests::where('id', '=', $request_id)
								->where('confirmed_provider', '=', $provider->id)
								->first();

			// Current state being validated in order to prevent accidental change of state
			if ($requests && intval($requests->provider_status) != $current_state ) 
			{
				if($request->hasFile('after_image'))
				{
					$image = $request->file('after_image');
					$requests->before_image = Helper::upload_picture($image);
				}
	            $request->status = REQUEST_COMPLETE_PENDING;
	            $request->end_time = date("Y-m-d H:i:s");
	            $requests->provider_status = PROVIDER_SERVICE_COMPLETED;
    			$requests->save();

    			// Invoice details

    			//Get base price from admin panel

    			//Get price per minute detials from admin panel

    			// Calculate price 

    			// get payment mode from user table.
	            

	            //Update provider availability
	            $provider = Provider::find($request->confirmed_provider);
	            $provider->available = PROVIDER_AVAILABLE;
	            $provider->save();

	            /*Send Push Notification to User*/

	            //Invoice details to Provider as well
	           
				$response_array = array(
						'success' => true,
				);
			} else {
				$response_array = array('success' => false, 'error' => get_error_message(101), 'error_code' => 101);
                Log::info('Provider status Error:: Old state='.$requests->provider_status.' and current state='.$current_state);
			}
		}

		$response = Response::json($response_array, 200);
		return $response;
	}
}




