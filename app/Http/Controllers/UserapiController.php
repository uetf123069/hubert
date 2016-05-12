<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use Log;

use Hash;

use Validator;

use File;

use App\User;


define('DEFAULT_FALSE', 0);
define('DEFAULT_TRUE', 1);

define('DEVICE_ANDROID', 'android');
define('DEVICE_IOS', 'ios');

class UserapiController extends Controller
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
    		$user_id = $request->id;

    		if (! Helper::is_token_valid('USER', $user_id, $token, $error)) {
    			$response = response()->json($error, 200);
    			return $response;
    		}
    	}
	}

	public function register(Request $request)
	{
        // dd($request->all());
        $response_array = array();
        $operation = false;
        /*validate basic field*/
        $basicValidator = Validator::make(
            $request->all(),
            array(
                'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
                'device_token' => 'required',
                'login_by' => 'required|in:manual,facebook,google',
            )
        );

        if($basicValidator->fails()){
            $error_messages = $basicValidator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
            Log::info('Registration basic validation failed');
        }else{

            $login_by = $request->login_by;
            $allowedSocialLogin = array('facebook','google');
            /*check login-by*/
            if(in_array($login_by,$allowedSocialLogin)){

                /*validate social registration fields*/
                $socialValidator = Validator::make(
                    $request->all(),
                    array(
                        'social_unique_id' => 'required',
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'phone' => 'digits_between:6,13',
                        'picture' => 'mimes:jpeg,jpg,bmp,png',
                    )
                );

                /*validate social_unique_id and email existence */
                $socialEmailValidator = Validator::make(
                    $request->all(),
                    array(
                        'social_unique_id' => 'unique:users,social_unique_id',
                        'email' => 'unique:users,email'
                    )
                );

                if($socialValidator->fails()){
                    $error_messages = $socialValidator->messages()->all();
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration social validation failed');
                }elseif($socialEmailValidator->fails()){
                    $error_messages = $socialEmailValidator->messages()->all();
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual email validation failed');

                }else{
                    Log::info('Registration passed social validation');
                    $operation = true;
                }

            }else{

                /*validate manual registration fields*/
                $manualValidator = Validator::make(
                    $request->all(),
                    array(
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'phone' => 'required|digits_between:6,13',
                        'password' => 'required|min:6',
                        'picture' => 'mimes:jpeg,jpg,bmp,png',
                    )
                );

                /*validate email existence */
                $emailValidator = Validator::make(
                    $request->all(),
                    array(
                        'email' => 'unique:users,email'
                    )
                );

                if($manualValidator->fails()){
                    $error_messages = $manualValidator->messages()->all();
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual validation failed');
                }elseif($emailValidator->fails()){
                    $error_messages = $emailValidator->messages()->all();
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual email validation failed');
                }else{
                    Log::info('Registration passed manual validation');
                    $operation = true;
                }
            }

            if($operation){
                /*creating the user*/
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone;
                $password = $request->password;
                $picture = $request->file('picture');
                $device_token = $request->device_token;
                $device_type = $request->device_type;
                $login_by = $request->login_by;
                $social_unique_id = $request->social_unique_id;

                $user = new User;
                $user->name = $name;
                $user->email = $email;
                $user->mobile = $phone!=NULL ? $phone : '';
                $user->password = $password!=NULL ? Hash::make($password) : '';
                

                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();
                $user->device_token = $device_token;
                $user->device_type = $device_type;
                $user->login_by = $login_by;
                $user->social_unique_id = $social_unique_id!=NULL ? $social_unique_id : '';

                // Upload picture
                $user->picture = Helper::upload_picture($picture);

                $user->save();

                // Send welcome email to the new user:
                // Helper::send_user_welcome_email($user);

                // Response with registered user details:
                $response_array = array(
                    'success' => true,
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->mobile,
                    'email' => $user->email,
                    'picture' => $user->picture,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry,
                    'login_by' => $user->login_by,
                    'social_unique_id' => $user->social_unique_id,
                );
                $response_array = Helper::null_safe($response_array);
                Log::info('Registration completed');
            }

        }

        $response = response()->json($response_array, 200);
        return $response;
	}

	public function login(Request $request)
	{
        $response_array = array();
        $operation = false;

        $basicValidator = Validator::make(
            $request->all(),
            array(
                'device_token' => 'required',
                'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
                'login_by' => 'required|in:manual,facebook,google',
            )
        );

        if($basicValidator->fails()){
            $error_messages = $basicValidator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
        }else{

            $login_by = $request->login_by;
            if($login_by == 'manual'){

                /*validate manual login fields*/
                $manualValidator = Validator::make(
                    $request->all(),
                    array(
                        'email' => 'required|email',
                        'password' => 'required',
                    )
                );

                if ($manualValidator->fails()) {
                    $error_messages = $manualValidator->messages()->all();
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                } else {

                    $email = $request->email;
                    $password = $request->password;

                    // Validate the user credentials
                    if($user = User::where('email', '=', $email)->first()){
                        if(Hash::check($password, $user->password)){

                            /*manual login success*/
                            $operation = true;

                        }else{
                            $response_array = array( 'success' => false, 'error' => Helper::get_error_message(105), 'error_code' => 105 );
                        }

                    } else {
                        $response_array = array( 'success' => false, 'error' => Helper::get_error_message(105), 'error_code' => 105 );
                    }

                }

            }else{
                /*validate social login fields*/
                $socialValidator = Validator::make(
                    $request->all(),
                    array(
                        'social_unique_id' => 'required',
                    )
                );

                if ($socialValidator->fails()) {
                    $error_messages = $socialValidator->messages()->all();
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                } else {

                    $social_unique_id = $request->social_unique_id;
                    if ($user = User::where('social_unique_id', '=', $social_unique_id)->first()) {

                        /*social login success*/
                        $operation = true;

                    }else{
                        $response_array = array('success' => false, 'error' => Helper::get_error_message(125), 'error_code' => 125);
                    }

                }
            }

            if($operation){

                $device_token = $request->device_token;
                $device_type = $request->device_type;

                // Generate new tokens
                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();
                

                // Save device details
                $user->device_token = $device_token;
                $user->device_type = $device_type;
                $user->login_by = $login_by;

                $user->save();

                // Respond with user details
                $response_array = array(
                    'success' => true,
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->mobile,
                    'email' => $user->email,
                    'picture' => $user->picture,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry,
                    'login_by' => $user->login_by,
                    'social_unique_id' => $user->social_unique_id
                );
                $response_array = Helper::null_safe($response_array);

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

    		$user_data = User::where('email',$email)->first();

    		if($user_data)
    		{
    			$user = User::find($user_data->id);
    			$new_password = Helper::generate_password();
    			$user->password = Hash::make($new_password);
    			$user->save();

    			$subject = "Your New Password";
    			$email_data = array();
    			$email_data['password']  = $new_password;

    			$email_send = Helper::send_user_forgot_email($user->email,$email_data,$subject);

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

    			$response_array = array('success' => false, 'error' => Helper::get_error_message(124), 'error_code' => 124);
    			$response_code = 200;
    		}
        }

        $response = response()->json($response_array, $response_code);
        return $response;
	}

    public function details_fetch(Request $request)
    {
        $user = User::find($request->id);

        // Check Condition

        // Generate new tokens
        $user->token = Helper::generate_token();
        $user->token_expiry = Helper::generate_token_expiry();

        $user->save();

        // Respond with user details
        $response_array = array(
            'success' => true,
            'id' => $user->id,
            'first_name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'picture' => $user->picture,
            'token' => $user->token,
            'token_expiry' => $user->token_expiry,
            'login_by' => $user->login_by,
            'social_unique_id' => $user->social_unique_id
        );
        $response_array = Helper::null_safe($response_array);

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function details_save(Request $request)
    {
        $user_id = $request->id;
        $validator = Validator::make(
            $request->all(),
            /*The param names are changed to match the param names in api doc and email validation added to check email existence in db other than the current user */
            array(
                    'device_token' => 'required',
                    'id' => 'required',
                    'name' => 'required|max:255',
                    'email' => 'required|email|unique:users,email,'.$user_id.'|max:255',
                    'mobile' => 'required|digits_between:6,13',
                    'picture' => 'mimes:jpeg,bmp,png',
            ));

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all(); /*Error messages added in response for debugging*/
            $response_array = array(
                    'success' => false,
                    'error' => Helper::get_error_message(101),
                    'error_code' => 101,
                    'error_messages' => $error_messages
            );
        } else {
            //$user_id = $request->id; /*Moved to up to overcome the scope problem*/
            $name = $request->name;
            $email = $request->email;
            $mobile = $request->mobile;
            $picture = $request->file('picture');

            $user = User::find($user_id);
            $user->name = $name;
            $user->email = $email;
            if ($mobile != "")
                $user->mobile = $mobile;

            // Upload picture
            if ($picture != ""){
                //deleting old image if exists
                //if( $user->picture != "" && file_exists( parse_url($user->picture, PHP_URL_PATH) ) )
                    File::delete( public_path() . "/uploads/" . basename($user->picture) );
                $user->picture = Helper::upload_picture($picture);
            }

            // Generate new tokens
            $user->token = Helper::generate_token();
            $user->token_expiry = Helper::generate_token_expiry();
            
            $user->save();

            $response_array = array(
                'success' => true,
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'picture' => $user->picture,
                'token' => $user->token,
                'token_expiry' => $user->token_expiry,
                'login_by' => $user->login_by,
                'social_unique_id' => $user->social_unique_id
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
                    'token' => 'required'
                ));

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {
            $user_id = $request->id;
            $token_refresh = $request->token;

            // Check if refresher token is valid
            if ($user = User::where('id', '=', $user_id)->where('token', '=', $token_refresh)->first()) {

                // Generate new tokens
                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();

                $user->save();

                $response_array = Helper::null_safe(array(
                        'success' => true,
                        'token' => $user->token,
                        'token_refresh' => $user->token_refresh
                ));
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

    public function serviceList(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                array(
                    'id' => 'required|integer',
                    'token' => 'required'
                ));

        if ($validator->fails()) 
        {
            $error_messages = $validator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        }
        else 
        {
            if($serviceList = ServiceType::all())
            {
                $response_array = array(
                            'success' => true,
                            'services' => $serviceList,
                    );
            } 
            else 
            {
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

    public function singleService(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                array(
                    'id' => 'required|integer',
                    'token' => 'required',
                    'service_id' => 'required',
                ));

        if ($validator->fails()) 
        {
            $error_messages = $validator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        }
        else 
        {
            if($serviceList = ServiceType::find($request->id))
            {
                $providerList = ProviderService::where('service_type_id',$request->id)->get();
                $provider_details = array();
                $provider_details_data = array();

                foreach ($providerList as $provider_details) 
                {
                    $provider = Provider::find($provider_details->id);
                    $provider_details['id'] = $provider->id;
                    $provider_details['name'] = $provider->name;
                    $provider_details['latiude'] = $provider->latiude;
                    $provider_details['longitude'] = $provider->longitude;
                    $provider_details_data[] = $provider_details;
                    $provider_details = array();
                }
                $response_array = array(
                            'success' => true,
                            'provider_details' => $provider_details_data,
                    );
                $response_array = null_safe($response_array);
            } 
            else 
            {
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

    public function sendRequest(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                array(
                    'id' => 'required|integer',
                    'token' => 'required',
                    'source_lat' => 'required|numeric',
                    'source_long' => 'required|numeric',
                    'service_id' => 'required|numeric',
                    'amount' => 'required|numeric',
                ));

        if ($validator->fails()) 
        {
            $error_messages = $validator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        }
        else 
        {
            Log::info('Create request start');

            $service_type = $request->service_id;
            $s_latitude = $request->source_lat;
            $s_longitude = $request->source_long;
            $request_start_time = time();
            if ($request_after != REQUEST_NOW) {
                $request_start_time = time() + ($request_after * 60);
            }

            /*Get default search radius*/
            $settings = Setting::where('key', 'search_radius')->first();
            $distance = $settings->value;

            $latitude = $s_latitude;
            $longitude = $s_longitude;

            /*Search delivery boys*/
            $available = 1;
            $query = "SELECT providers.id, 1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance
                  FROM provider
                  WHERE available IN ($available) AND is_activated = 1 AND is_approved = 1
                        AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                  ORDER BY distance";

            $providers = DB::select(DB::raw($query));
            Log::info("Search query: " . $query);
            


            if ($providers) 
            {
                
                $amount = $request->amount;

                /*Create delivery*/
                $requests = new Requests;
                $requests->user_id = $user->id;
                $requests->request_type = $service_type;
                $requests->status = REQUEST_NEW;
                $requests->confirmed_provider = NONE;
                $requests->request_start_time = date("Y-m-d H:i:s", $requests_start_time);
                $requests->provider_status = PROVIDER_NONE;
                if($requests->s_address)
                {
                    $requests->s_address = $request->s_address;
                }
                if($requests->d_address)
                {
                    $requests->d_address = $request->d_address;
                }
                $requests->latitude = $s_latitude;
                $requests->longitude = $s_longitude;
                $requests->d_latitude = $d_latitude;
                $requests->d_longitude = $d_longitude;

                $requests->amount = $amount != NULL ? $amount : 0;
                
                $requests->save();

                    /*Assign providers*/
                    $first_provider_id = 0;
                    foreach ($providers as $provider) {
                        $request_meta = new RequestMeta;
                        $request_meta->request_id = $request->id;
                        $request_meta->provider_id = $provider->id;

                        if ($first_provider_id == 0) {
                            $first_provider_id = $provider->id;
                            $request_meta->status = REQUEST_META_OFFERED;
                            $request->status = REQUEST_WAITING;
                            $request->save();
                        }
                        $request_meta->save();
                    }

                    /*Push Start*/
                    $settings = Setting::where('key', 'provider_select_timeout')->first();
                    $provider_timeout = $settings->value;
                    //$request_offered_provider = Provider::find($first_provider_id);
                    $service = ServiceType::find($requests->request_type);

                    $push_data = array();
                    $push_data['request_id'] = $requests->id;
                    $push_data['service_type'] = $requests->request_type;
                    $push_data['request_start_time'] = $requests->request_start_time;
                    $push_data['status'] = $requests->status;
                    $push_data['amount'] = $requests->amount;
                    $push_data['user_name'] = $user->name;
                    $push_data['user_picture'] = $user->picture;
                    $push_data['source_address'] = $requests->s_address;
                    $push_data['desti_address'] = $requests->d_address;
                    $push_data['source_lat'] = $requests->latitude;
                    $push_data['source_long'] = $requests->longitude;
                    $push_data['desti_lat'] = $requests->d_latitude;
                    $push_data['desti_long'] = $requests->d_longitude;
                    $push_data['user_rating'] = DB::table('ratings')->where('user_id', $user->id)->avg('rating') ?: 0;
                    $push_data['time_left_to_respond'] = $provider_timeout - (time() - strtotime($request->request_start_time));

                    $title = "New Request";
                    $push_msg = "You got a new request from ".$user->name;
                    $push_message = array(
                        'success' => true,
                        'msg' => $push_msg,
                        'data' => array((object) $push_data)
                    );
                    /* Send Push Notification to Provider */
                    send_push_notification($first_provider_id, PROVIDER, $title, $push_message);
                    Log::info(print_r($push_message,true));
                    /*Push End*/

                    // Add the pickup and drop addresses to the user's favourite 20
                    
                

                $response_array = array(
                    'success' => true,
                    'source_address' => $request->s_address,
                    'desti_address' => $request->d_address,
                    'source_lat' => $request->latitude,
                    'source_long' => $request->longitude,
                    'desti_lat' => $request->d_latitude,
                    'desti_long' => $request->d_longitude,
                    'service_id' => $request->service_id,
                    'request_id' => $request->id,
                );
                $response_array = null_safe($response_array);

                Log::info('Create request end');

            } else {
                /*No provider found*/
                Log::info("No Provider Found");
                //send_notifications($user->id, "user", 'No Provider Found', 'No provider found for the selected service in your area currently');
                /*Send Push Notification to User*/
                send_push_notification($user->id, USER, 'No Provider Available', 'No provider available to take the Service.');
                $response_array = array('success' => false, 'error' => get_error_message(112), 'error_code' => 112);
            }
        }

    }

}






