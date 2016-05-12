<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use Log;

use Hash;

use Validator;

use File;

use DB;

use App\User;

use App\ProviderService;

use App\Requests;

use App\RequestsMeta;

use App\ServiceType;

define('DEFAULT_FALSE', 0);
define('DEFAULT_TRUE', 1);

define('DEVICE_ANDROID', 'android');
define('DEVICE_IOS', 'ios');

define('NONE', 0);

define('PROVIDER_NONE' , 0);

define('REQUEST_NEW' , 1);

define('REQUEST_SEND' , 2);

define('REQUEST_ACCEPT_PROVIDER' , 3);

define('REQUEST_REJECT_PROVIDER' , 4);

define('REQUEST_STARTED' , 5);

define('REQUEST_ARRIVED' , 6);

define('SERVICE_STARTED' , 7);

define('REQUEST_COMPLETED' , 8);

define('REQUEST_CANCEL_PROVIDER' , 9);

define('REQUEST_CANCEL_USER' , 10);

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
                    'source_latitude' => 'required|numeric',
                    'source_longitude' => 'required|numeric',
                    'service_type' => 'numeric',
                    // 'amount' => 'required|numeric',
                ));

        if ($validator->fails()) 
        {
            $error_messages = $validator->messages()->all();
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        }
        else 
        {
            Log::info('Create request start');

            // Check already request exists 

            $check_status = array(REQUEST_CANCEL_USER,REQUEST_CANCEL_PROVIDER,REQUEST_REJECT_PROVIDER);

            $check_requests = Requests::where('user_id' , $request->id)->whereNotIn('status' , $check_status)->get();


            if(count($check_requests) == 0) {

                $service_type = $request->service_type; // Get the service type 

                $s_latitude = $latitude = $request->source_latitude;
                $s_longitude = $longitude = $request->source_longitude;

                $d_latitude = $request->d_latitude;
                $d_longitude = $request->d_longitude;

                $request_start_time = time();

                /*Get default search radius*/

                // $settings = Setting::where('key', 'search_radius')->first();
                // $distance = $settings->value;

                $distance = 100;

                // Search Providers

                $available = 1;

                $providers = array();   // Initialize providers variable

                // Check the service type value 

                if($service_type) {

                    // Get the providers based on the selected service types

                    $service_providers = ProviderService::where('service_type_id' , $service_type)->get();

                    $list_service_ids = array();    // Initialize list_service_ids

                    $list_service_ids = array();    // Initialize list_service_ids

                    if($service_providers) {

                        foreach ($service_providers as $sp => $service_provider) {

                            if($service_provider->provider_id != $request->id)

                                $list_service_ids[] = $service_provider->provider_id;

                        }

                        $list_service_ids = implode(',', $list_service_ids);

                    }

                    if($list_service_ids) {

                        $query = "SELECT providers.id, 1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance FROM providers
                                WHERE id IN ($list_service_ids) AND is_available = 1 AND is_activated = 1 AND is_approved = 1
                                AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                                ORDER BY distance";

                        $providers = DB::select(DB::raw($query));

                        Log::info("Search query: " . $query);
                    } 

                } else {

                    $query = "SELECT providers.id, 1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance FROM providers
                            WHERE is_available = 1 AND is_activated = 1 AND is_approved = 1
                            AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                            ORDER BY distance";

                    $providers = DB::select(DB::raw($query));

                    Log::info("Search query: " . $query);
                
                }

                Log::info('List of providers'." ".print_r($providers));

                if ($providers) 
                {
                    $user = User::find($request->id);

                    // Create Requests
                    $requests = new Requests;
                    $requests->user_id = $user->id;

                    if($service_type)
                        $requests->request_type = $service_type;

                    $requests->status = REQUEST_NEW;
                    $requests->confirmed_provider = NONE;
                    $requests->request_start_time = date("Y-m-d H:i:s", $request_start_time);

                    $requests->s_address = $request->s_address ? $request->s_address : "";
                    
                    $requests->d_address = $request->d_address ? $request->d_address : "";

                    if($s_latitude)
                        $requests->s_latitude = $s_latitude;

                    if($s_longitude)
                        $requests->s_longitude = $s_longitude;

                    if($d_latitude)
                        $requests->d_latitude = $d_latitude;

                    if($d_longitude)
                        $requests->d_longitude = $d_longitude;
                    
                    $requests->save();

                    if($requests) {

                        $first_provider_id = 0;

                        foreach ($providers as $provider) 
                        {
                            $request_meta = new RequestsMeta;
                            $request_meta->request_id = $request->id;
                            $request_meta->provider_id = $provider->id;

                            if ($first_provider_id == 0) {

                                $first_provider_id = $provider->id;
                                $request_meta->status = REQUEST_SEND;

                                $requests->status = REQUEST_SEND;
                                $requests->current_provider = $provider->id;
                                $requests->save();

                                 // Push notification start

                                // $settings = Setting::where('key', 'provider_select_timeout')->first();
                                // $provider_timeout = $settings->value;

                                $provider_timeout = 60;

                                 if($service_type)
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
                                $push_data['source_lat'] = $requests->s_latitude;
                                $push_data['source_long'] = $requests->s_longitude;
                                $push_data['desti_lat'] = $requests->d_latitude;
                                $push_data['desti_long'] = $requests->d_longitude;
                                // $push_data['user_rating'] = DB::table('ratings')->where('user_id', $user->id)->avg('rating') ?: 0;
                                $push_data['time_left_to_respond'] = $provider_timeout - (time() - strtotime($request->request_start_time));

                                $title = "New Request";
                                $message = "You got a new request from ".$user->name;
                                $push_message = array(
                                    'success' => true,
                                    'message' => $message,
                                    'data' => array((object) Helper::null_safe($push_data))
                                );

                                // Send Push Notification to Provider

                                //send_push_notification($first_provider_id, PROVIDER, $title, $push_message);
                                Log::info(print_r($push_message,true));

                                // Push End
                            }

                            $request_meta->save();
                        }

                        $response_array = array(
                            'success' => true,
                            'source_address' => $requests->s_address,
                            'desti_address' => $requests->d_address,
                            'source_lat' => $requests->s_latitude,
                            'source_long' => $requests->s_longitude,
                            'desti_lat' => $requests->d_latitude,
                            'desti_long' => $requests->d_longitude,
                            'service_id' => $requests->service_id,
                            'request_id' => $requests->id,
                        );


                        $response_array = Helper::null_safe($response_array);

                        Log::info('Create request end');

                    } else {

                        $response_array = array('success' => false , 'error' => Helper::get_error_message(126) , 'error_code' => 126 );
                    }

                } else {

                    // No provider found

                    Log::info("No Provider Found");

                    // Send push notification to User

                    send_push_notification($user->id, USER, Helper::get_push_message(601), Helper::get_push_message(602));
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(112), 'error_code' => 112);
                
                }

            } else  {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(127) , 'error_code' => 127);
            }
        }

        $response = response()->json($response_array, 200);
        return $response;

    }

}






