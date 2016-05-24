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

use App\Provider;

use App\Settings;

use App\FavouriteProvider;

use App\UserRating;

use App\ProviderRating;

use App\Cards;


define('USER', 0);

define('PROVIDER',1);


define('NONE', 0);


define('DEFAULT_FALSE', 0);

define('DEFAULT_TRUE', 1);

// Request table status

define('REQUEST_NEW',        0);
define('REQUEST_WAITING',      1);
define('REQUEST_INPROGRESS',    2);
define('REQUEST_COMPLETE_PENDING',  3);
define('REQUEST_RATING',      4);                                                                      
define('REQUEST_COMPLETED',      5);
define('REQUEST_CANCELLED',      6);
define('REQUEST_NO_PROVIDER_AVAILABLE',7);
define('REQUEST_CANCEL_USER',8);
define('REQUEST_CANCEL_PROVIDER',9);

define('PROVIDER_NOT_AVAILABLE', 0);
define('PROVIDER_AVAILABLE', 1);

// Request table provider_status

define('PROVIDER_NONE', 0);
define('PROVIDER_ACCEPTED', 1);
define('PROVIDER_STARTED', 2);
define('PROVIDER_ARRIVED', 3);
define('PROVIDER_SERVICE_STARTED', 4);
define('PROVIDER_SERVICE_COMPLETED', 5);
define('PROVIDER_RATED', 6);

define('REQUEST_META_NONE',   0);
define('REQUEST_META_OFFERED',   1);
define('REQUEST_META_TIMEDOUT', 2);
define('REQUEST_META_DECLINED', 3);

define('WAITING_TO_RESPOND', 1);
define('WAITING_TO_RESPOND_NORMAL',0);

define('RATINGS', '1,2,3,4,5');


define('DEVICE_ANDROID', 'android');

define('DEVICE_IOS', 'ios');


class UserapiController extends Controller
{

    public function __construct(Request $request)
	{
        $this->middleware('UserApiVal' , array('except' => ['register' , 'login' , 'forgot_password']));
	}

	public function register(Request $request)
	{
        $response_array = array();
        $operation = false;

        // validate basic field

        $basicValidator = Validator::make(
            $request->all(),
            array(
                'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
                'device_token' => 'required',
                'login_by' => 'required|in:manual,facebook,google',
            )
        );

        if($basicValidator->fails()) {

            $error_messages = implode(',', $basicValidator->messages()->all());

            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);

            Log::info('Registration basic validation failed');

        } else {

            $login_by = $request->login_by;
            $allowedSocialLogin = array('facebook','google');

            // check login-by

            if(in_array($login_by,$allowedSocialLogin)){

                // validate social registration fields

                $socialValidator = Validator::make(
                            $request->all(),
                            array(
                                'social_unique_id' => 'required',
                                'first_name' => 'required|max:255',
                                'last_name' => 'required|max:255',
                                'email' => 'email|max:255',
                                'mobile' => 'digits_between:6,13',
                                'picture' => 'mimes:jpeg,jpg,bmp,png',
                            )
                        );

                // validate social_unique_id and email existence 

                $socialEmailValidator = Validator::make(
                    $request->all(),
                    array(
                        'social_unique_id' => 'unique:users,social_unique_id',
                        'email' => 'unique:users,email'
                    )
                );

                if($socialValidator->fails()) {

                    $error_messages = implode(',', $socialValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);

                    Log::info('Registration social validation failed');

                } elseif($socialEmailValidator->fails()) {

                    $error_messages = implode(',', $socialEmailValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual email validation failed');

                } else {
                    Log::info('Registration passed social validation');
                    $operation = true;
                }

            } else {

                // Validate manual registration fields

                $manualValidator = Validator::make(
                    $request->all(),
                    array(
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'mobile' => 'required|digits_between:6,13',
                        'password' => 'required|min:6',
                        'picture' => 'mimes:jpeg,jpg,bmp,png',
                    )
                );

                // validate email existence 

                $emailValidator = Validator::make(
                    $request->all(),
                    array(
                        'email' => 'unique:users,email'
                    )
                );

                if($manualValidator->fails()) {

                    $error_messages = implode(',', $manualValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual validation failed');

                } elseif($emailValidator->fails()) {

                    $error_messages = implode(',', $emailValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual email validation failed');

                } else {
                    Log::info('Registration passed manual validation');
                    $operation = true;
                }
            }

            if($operation) {

                // Creating the user

                $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
                $mobile = $request->mobile;
                $password = $request->password;
                $picture = $request->file('picture');
                $device_token = $request->device_token;
                $device_type = $request->device_type;
                $login_by = $request->login_by;
                $social_unique_id = $request->social_unique_id;

                $user = new User;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->email = $email;
                $user->mobile = $mobile!=NULL ? $mobile : '';
                $user->password = $password!=NULL ? Hash::make($password) : '';
                

                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();
                $user->device_token = $device_token;
                $user->device_type = $device_type;
                $user->login_by = $login_by;
                $user->social_unique_id = $social_unique_id!=NULL ? $social_unique_id : '';

                // Upload picture
                $user->picture = Helper::upload_picture($picture);

                $user->is_activated = 1;
                $user->is_approved = 1;

                // Settings table - COD Check is enabled 

                // Save the default payment method

                $user->payment_mode = 1;


                $user->save();

                $payment_mode_status = $user->payment_mode ? $user->payment_mode : 0;

                // Send welcome email to the new user:
                // Helper::send_user_welcome_email($user);

                // Response with registered user details:

                $response_array = array(
                    'success' => true,
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                    'picture' => $user->picture,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry,
                    'login_by' => $user->login_by,
                    'social_unique_id' => $user->social_unique_id,
                    'payment_mode_status' =>  $payment_mode_status,
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
            $error_messages = implode(',',$basicValidator->messages()->all());
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
                    $error_messages = implode(',',$manualValidator->messages()->all());
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
                    $error_messages = implode(',',$socialValidator->messages()->all());
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

                $payment_mode_status = $user->payment_mode ? $user->payment_mode : 0;

                // Respond with user details

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
                    'social_unique_id' => $user->social_unique_id,
                    'payment_mode_status' => $payment_mode_status,
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
                'email' => 'required|email|exists:users,email',
            )
        );
        if ($validator->fails()) {
            $error_messages = implode(',',$validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
        } 
        else 
        {
			$user = User::find($user_data->id);
			$new_password = Helper::generate_password();
			$user->password = Hash::make($new_password);
			
			$subject = "Your New Password";
			$email_data = array();
			$email_data['password']  = $new_password;
			$email_send = Helper::send_user_forgot_email($user->email,$email_data,$subject);

			$response_array = array();

            if($email_send == Helper::get_message(106)) {
                $response_array['success'] = true;                
                $user->save();
                
            } else {
                $response_array['success'] = false;
            }

            $response_array['message'] = $email_send;

        }

        $response = response()->json($response_array, 200);
        return $response;
	}

    public function change_password(Request $request) {

        $old_password = $request->old_password;
        $new_password = $request->password;
        $confirm_password = $request->confirm_password;
        
        $validator = Validator::make($request->all(), [              
                'password' => 'required|confirmed',
                'old_password' => 'required',
            ]);

        if($validator->fails()) {
            $error_messages = implode(',',$validator->messages()->all());
            $response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages );
            $response_code = 200;
        } else {
            $user = User::find($request->id);

            if(Hash::check($old_password,$user->password))
            {
                $user->password = Hash::make($new_password);
                $user->save();

                $response_array = array('success' => true , 'message' => Helper::get_message(102));
                
            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(131), 'error_code' => 131);
            }

        }

        $response = response()->json(Helper::null_safe($response_array),200);
        return $response;
    
    }

    public function user_details(Request $request)
    {
        $user = User::find($request->id);

        $response_array = array(
            'success' => true,
            'id' => $user->id,
            'first_name' => $user->name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'picture' => $user->picture,
            'token' => $user->token,
            'token_expiry' => $user->token_expiry,
            'login_by' => $user->login_by,
            'social_unique_id' => $user->social_unique_id
        );
        $response = response()->json(Helper::null_safe($response_array), 200);
        return $response;
    }

    public function update_profile(Request $request)
    {
        $user_id = $request->id;

        $validator = Validator::make(
            $request->all(),
            array(
                    'device_token' => 'required',
                    'id' => 'required',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'email|unique:users,email,'.$user_id.'|max:255',
                    'mobile' => 'required|digits_between:6,13',
                    'picture' => 'mimes:jpeg,bmp,png',
            ));

        if ($validator->fails()) {
            // Error messages added in response for debugging
            $error_messages = implode(',',$validator->messages()->all()); 
            $response_array = array(
                    'success' => false,
                    'error' => Helper::get_error_message(101),
                    'error_code' => 101,
                    'error_messages' => $error_messages
            );
        } else {

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
            if ($picture != "") {
                Helper::delete_picture($user->picture); // Delete the old pic
                $user->picture = Helper::upload_picture($picture);
            }

            // Generate new tokens
            $user->token = Helper::generate_token();
            $user->token_expiry = Helper::generate_token_expiry();
            
            $user->save();

            $payment_mode_status = $user->payment_mode ? $user->payment_mode : "";

            $response_array = array(
                'success' => true,
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'picture' => $user->picture,
                'token' => $user->token,
                'token_expiry' => $user->token_expiry,
                'login_by' => $user->login_by,
                'social_unique_id' => $user->social_unique_id,
                'payment_mode_status' => $payment_mode_status
            );
            $response_array = Helper::null_safe($response_array);
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function token_renew(Request $request)
    {
       
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
            ));
        
        } else {
            $response_array = array(
                    'success' => false,
                    'error' => Helper::get_error_message(115),
                    'error_code' => 115
            );
        
        }

        $response = response()->json($response_array, 200);
        return $response;
    
    }

    public function service_list(Request $request)
    {
        if($serviceList = ServiceType::all())
        {
            $response_array = array(
                        'success' => true,
                        'services' => $serviceList,
                );
        } else {
            $response_array = array(
                    'success' => false,
                    'error' => Helper::get_error_message(115),
                    'error_code' => 115
            );
        }

        $response = response()->json(Helper::null_safe($response_array), 200);
        return $response;

    }

    // Not using now
    public function single_service(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                array(
                    'service_id' => 'required',
                ));

        if ($validator->fails()) 
        {
            $error_messages = implode(',', $validator->messages()->all());
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

    public function send_request(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                array(
                    's_latitude' => 'required|numeric',
                    's_longitude' => 'required|numeric',
                    'service_type' => 'numeric|exists:service_types,id',
                ));

        if ($validator->fails()) 
        {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        }
        else 
        {
            Log::info('Create request start');

            // Check the user filled the payment details

            $user = User::find($request->id);

            if(!$user->payment_mode) {
                Log::info('Payment Mode is not available');
                $response_array = array('success' => false , 'error' => Helper::get_error_message(134) , 'error_code' => 134);
            } else {

                // Check already request exists 
                $check_status = array(REQUEST_CANCEL_USER,REQUEST_NO_PROVIDER_AVAILABLE,REQUEST_CANCELLED,REQUEST_CANCEL_PROVIDER,REQUEST_COMPLETED);

                $check_requests = Requests::where('user_id' , $request->id)->whereNotIn('status' , $check_status)->count();

                if($check_requests == 0) {

                    Log::info('Previous requests check is done');
            
                    $service_type = $request->service_type; // Get the service type 

                    // Initialize the variable
                    $list_fav_providers = array(); $first_provider_id = 0; $list_fav_provider = array();

                    /** Fav Providers SEARCH started */

                    $favProviders = Helper::get_fav_providers($service_type,$request->id);

                    // Check Favourite Providers list is not empty

                    if($favProviders) {

                        foreach ($favProviders as $key => $favProvider) {

                            $list_fav_provider['id'] = $favProvider->provider_id;
                            $list_fav_provider['waiting'] = $favProvider->waiting;
                            $list_fav_provider['distance'] = 0;

                            // Assign value to the first_provider_id to send push notifications
                            if($first_provider_id == 0) {
                                if($favProvider->waiting == 0) {
                                    $first_provider_id = $favProvider->provider_id;
                                }
                            }

                            array_push($list_fav_providers, $list_fav_provider);
                        }                
                    }

                    // Log::info('List Of Favourite Providers' .print_r($list_fav_providers, true));

                    /** Fav providers end */

                    $latitude = $request->s_latitude;
                    $longitude = $request->s_longitude;

                    $request_start_time = time();

                    /*Get default search radius*/
                    $settings = Settings::where('key', 'search_radius')->first();
                    $distance = $settings->value;

                    // Search Providers

                    $providers = array();   // Initialize providers variable

                    // Check the service type value to search the providers based on the nearby location

                    if($service_type) {

                        Log::info('Location Based search started - service_type');

                        // Get the providers based on the selected service types

                        $service_providers = ProviderService::where('service_type_id' , $service_type)->where('is_available' , 1)->select('provider_id')->get();

                        $list_service_ids = array();    // Initialize list_service_ids

                        if($service_providers) {
                            foreach ($service_providers as $sp => $service_provider) {

                                    $list_service_ids[] = $service_provider->provider_id;

                            }
                            $list_service_ids = implode(',', $list_service_ids);

                        }

                        if($list_service_ids) {

                            $query = "SELECT providers.id,providers.waiting_to_respond as waiting, 1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance FROM providers
                                    WHERE id IN ($list_service_ids) AND is_available = 1 AND is_activated = 1 AND is_approved = 1
                                    AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                                    ORDER BY distance";

                            $providers = DB::select(DB::raw($query));

                            Log::info("Search query: " . $query);
                        
                        } 

                    } else {

                        Log::info('Location Based search started - without service_type');

                        $query = "SELECT providers.id,providers.waiting_to_respond as waiting, 1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance FROM providers
                                WHERE is_available = 1 AND is_activated = 1 AND is_approved = 1
                                AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                                ORDER BY distance";

                        $providers = DB::select(DB::raw($query));

                        Log::info("Search query: " . $query);
                    
                    }

                    // Log::info('List of providers'." ".print_r($providers));

                    $merge_providers = array();

                    if ($providers) 
                    {
                        // Initialize Final list of provider variable

                        $search_providers = array();
                        $search_provider = array();

                        foreach ($providers as $provider) 
                        {
                            // Check the first_provider_id has already value , because if the user have fav providers means the first_provider_id will be assign over there itself

                            if(!$first_provider_id) {
                                $first_provider_id = $provider->id;
                            }

                            // $search_providers[] = $provider->id;
                            $search_provider['id'] = $provider->id;
                            $search_provider['waiting'] = $provider->waiting;
                            $search_provider['distance'] = $provider->distance;
                            
                            array_push($search_providers, $search_provider);
                        }

                    } else {
                        // No provider found
                        Log::info("No Provider Found");
                        // Send push notification to User
                        // Helper::send_push_notification($user->id, USER, Helper::get_push_message(601), Helper::get_push_message(602));
                        $response_array = array('success' => false, 'error' => Helper::get_error_message(112), 'error_code' => 112);
                    }

                    // Merge the favourite providers and search providers
                    $merge_providers = array_merge($list_fav_providers,$search_providers);

                    $final_providers = Helper::sort_waiting_providers($merge_providers);            

                    // Create Requests
                    $requests = new Requests;
                    $requests->user_id = $user->id;

                    if($service_type)
                        $requests->request_type = $service_type;

                    $requests->status = REQUEST_NEW;
                    $requests->confirmed_provider = NONE;
                    $requests->request_start_time = date("Y-m-d H:i:s", $request_start_time);

                    $requests->s_address = $request->s_address ? $request->s_address : "";
                        
                    if($latitude)
                        $requests->s_latitude = $latitude;

                    if($longitude)
                        $requests->s_longitude = $longitude;
                        
                    $requests->save();

                    if($requests) {

                        $requests->status = REQUEST_WAITING;

                        //No need fo current provider state
                        $requests->current_provider = $first_provider_id;
                        $requests->save();

                        if ($first_provider_id) {

                            // Availablity status change 

                            if($current_provider = Provider::find($first_provider_id)) {

                                $current_provider->waiting_to_respond = WAITING_TO_RESPOND;
                                $current_provider->save();
                            }

                            // Push notification start

                            $settings = Settings::where('key', 'provider_select_timeout')->first();
                            $provider_timeout = $settings->value;

                            if($service_type)
                                $service = ServiceType::find($requests->request_type);

                            $push_data = array();
                            $push_data['request_id'] = $requests->id;
                            $push_data['service_type'] = $requests->request_type;
                            $push_data['request_start_time'] = $requests->request_start_time;
                            $push_data['status'] = $requests->status;
                            $push_data['user_name'] = $user->name;
                            $push_data['user_picture'] = $user->picture;
                            $push_data['s_address'] = $requests->s_address;
                            $push_data['s_latitude'] = $requests->s_latitude;
                            $push_data['s_longitude'] = $requests->s_longitude;
                            $push_data['user_rating'] = ProviderRating::where('provider_id', $first_provider_id)->avg('rating') ?: 0;
                            $push_data['time_left_to_respond'] = $provider_timeout - (time() - strtotime($requests->request_start_time));

                            $title = "New Request";
                            $message = "You got a new request from ".$user->name;
                            $push_message = array(
                                'success' => true,
                                'message' => $message,
                                'data' => array((object) Helper::null_safe($push_data))
                            );

                            // Send Push Notification to Provider

                            //send_push_notification($first_provider_id, PROVIDER, $title, $push_message);
                            // Log::info(print_r($push_message,true));

                            // Push End
                            
                        }

                        // Save all the final providers

                        if($final_providers) {

                            foreach ($final_providers as $key => $final_provider) {

                                $request_meta = new RequestsMeta;

                                if($first_provider_id == $final_provider) {

                                    $request_meta->status = REQUEST_META_OFFERED;  // Request status change

                                    // Availablity status change 

                                    if($current_provider = Provider::find($first_provider_id)) {

                                        $current_provider->waiting_to_respond = WAITING_TO_RESPOND;
                                        $current_provider->save();
                                    }
                                }

                                $request_meta->request_id = $requests->id;
                                $request_meta->provider_id = $final_provider; 
                                $request_meta->save();

                            }

                        }
                        
                        $response_array = array(
                            'success' => true,
                            'source_address' => $requests->s_address,
                            's_latitude' => $requests->s_latitude,
                            's_longitude' => $requests->s_longitude,
                            'service_id' => $requests->service_id,
                            'request_id' => $requests->id,
                        );

                        $response_array = Helper::null_safe($response_array);

                        Log::info('Create request end');

                    } else {
                        $response_array = array('success' => false , 'error' => Helper::get_error_message(126) , 'error_code' => 126 );
                    }     
                } else {
                    $response_array = array('success' => false , 'error' => Helper::get_error_message(127) , 'error_code' => 127);
                }

            }
        }
        $response = response()->json($response_array, 200);
        return $response;
    }

    public function cancel_request(Request $request)
    {
        $user_id = $request->id;

        $validator = Validator::make(
            $request->all(),
            array(
                'request_id' => 'required|numeric|exists:requests,id,user_id,'.$user_id,
            ));

        if ($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
        }else
        {
            $request_id = $request->request_id;
            $requests = Requests::find($request_id);
            $requestStatus = $requests->status;
            $providerStatus = $requests->provider_status;
            $allowedCancellationStatuses = array(
                PROVIDER_NONE,
                PROVIDER_ACCEPTED,
                PROVIDER_STARTED,
            );

            /*Check whether request cancelled previously*/
            if($requestStatus != REQUEST_CANCELLED)
            {
                /*Check whether request eligible for cancellation*/
                if( in_array($providerStatus, $allowedCancellationStatuses) )
                {
                    /*Update status of the request to cancellation*/
                    $requests->status = REQUEST_CANCELLED;
                    $requests->save();

                    /*Send Push Notification to User*/
                    // send_push_notification($requests->user_id, USER, 'Service Cancelled', 'The service is cancelled.');

                    /*If request has confirmed provider then release him to available status*/
                    if($request->confirmed_provider != DEFAULT_FALSE){
                        $provider = Provider::find( $requests->confirmed_provider );
                        $provider->is_available = PROVIDER_AVAILABLE;
                        $provider->save();
                        /*Send Push Notification to Provider*/
                        // send_push_notification($requests->confirmed_provider, PROVIDER, 'Service Cancelled', 'The service is cancelled by user.');
                    }

                    // No longer need request specific rows from RequestMeta
                    RequestsMeta::where('request_id', '=', $request_id)->delete();

                    $response_array = array(
                        'success' => true,
                        'request_id' => $request->id,
                    );
                }
                else
                {
                    $response_array = array( 'success' => false, 'error' => Helper::get_error_message(114), 'error_code' => 114 );
                }

            } else {
                $response_array = array( 'success' => false, 'error' => Helper::get_error_message(113), 'error_code' => 113 );
            }

            $response_array = Helper::null_safe($response_array);
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function request_status_check(Request $request) {

        $requests = Requests::where('requests.user_id', '=', $request->id)
                            ->where('requests.status', '!=', REQUEST_COMPLETED)
                            ->where('requests.status', '!=', REQUEST_CANCELLED)
                            ->where('requests.status', '!=', REQUEST_NO_PROVIDER_AVAILABLE)
                            ->where('provider_status', '!=', PROVIDER_RATED)
                            ->leftJoin('users', 'users.id', '=', 'requests.user_id')
                            ->leftJoin('service_types', 'service_types.id', '=', 'requests.request_type')
                            ->orderBy('provider_status','desc')
                            ->select('requests.id as request_id', 'requests.request_type as request_type', 'service_types.name as service_type_name', 'request_start_time as request_start_time', 'requests.status', 'requests.provider_status', 'requests.amount', DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_name'), 'users.picture as user_picture', 'users.id as user_id','requests.s_latitude', 'requests.s_longitude')
                            ->get()->toArray();

        $requests_data = array();

        $response_array = array(
            'success' => true,
            'data' => $requests
        );
    
        $response = response()->json(Helper::null_safe($response_array), 200);
        return $response;
    } 

    public function paybypaypal(Request $request) {

        $user = User::find($request->id);

        $validator = Validator::make($request->all() , 
            array(
                'amount' => "required",
                'is_paid' => "required",
                'request_id' => "required|integer|exists:requests,id,user_id,".$request->id,
            ),array(
                'exists' => 'The :attribute doesn\'t belong to user:'.$user->firstname.' '.$user->last_name,
            )
            );


        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);

        } else {


                $requests = Requests::find($request->request_id);
                // Check the status is completed

                if($requests->status == REQUEST_COMPLETED) {

                    if($requests->status == REQUEST_COMPLETE_PENDING) {

                        // Save the payment details 

                        $requests->is_paid = 1;

                        $requests->amount = $request->amount;

                        $requests->save();

                        $user = User::find($request->id);


                        // Send push notification to provider

                        if($user)
                            $title =  "The"." ".$user->name." done the payment";
                        else
                            $title = "Payment done";

                        $message = Helper::get_push_message(603);

                        // Helper::send_notifications($requests->confirmed_provider, PROVIDER , $title , $message );

                        // Send push notification to provider

                        // Helper::send_notifications($requests->user_id, USER , $user_title , $user_message );

                        // Send Response

                        $response_array =  array('success' => true , 'message' => Helper::get_message(107));

                    } else {
                        $response_array = array('success' => 'false' , 'error' => Helper::get_error_message(137) , 'error_code' => 137);
                    }
                } else {
                        $response_array = array('success' => 'false' , 'error' => Helper::get_error_message(136) , 'error_code' => 136);
                }


        }

        return response()->json(Helper::null_safe($response_array),200);

    }

    public function fav_providers(Request $request) {

        $fav_providers = FavouriteProvider::where('user_id' , $request->id)->get();

        $provider_data = array();
        $provider_dataa = array();

        if($fav_providers) {

            foreach ($fav_providers as $f => $fav_provider) {
                # code...
                $provider_data['favourite_id'] = $fav_provider->id;
                $provider_data['user_id'] = $fav_provider->user_id;
                $provider_data['provider_id'] = $fav_provider->provider_id;

                if($provider = Provider::find($fav_provider->provider_id)) {
                    $provider_data['provider_name'] = $provider->name;
                    $provider_data['provider_picture'] = $provider->picture;
                } else {
                    $provider_data['provider_name'] = "";
                    $provider_data['provider_picture'] = "";
                }

                array_push($provider_dataa, $provider_data);
            }

            $response_array = array('success' => true , 'providers' => $provider_dataa);

        } else {

            $response_array = array('success' => false , 'error' => Helper::get_error_message(132) , 'error_code' => 132);

        }
        return response()->json(Helper::null_safe($response_array),200);
    
    }

    public function deleteFavProvider(Request $request) {

        $fav_id = $request->fav_id;

        $validator = Validator::make($request->all() , 
            array(
                'fav_id' => "required|exists:favourite_providers,id",
            ));
        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {

            if($provider = Provider::find($favourite->provider_id)) {

                $fav_delete = FavouriteProvider::find($request->fav_id)->delete();

                $response_array = array('success' => true , 'message' => Helper::get_message(108));

            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(132) ,'error_code' =>132);
            }

        }

        return response()->json(Helper::null_safe($response_array) , 200);

    }

    public function history(Request $request) 
    {
        // Get the completed request details 

        $requests = Requests::where('user_id', '=', $request->id)
                            ->where('status', '=', REQUEST_COMPLETED)
                            ->leftJoin('providers', 'providers.id', '=', 'requests.confirmed_provider')
                            ->leftJoin('users', 'users.id', '=', 'requests.user_id')
                            ->orderBy('request_start_time','desc')
                            ->select('requests.id', 'requests.request_type as request_type', 'request_start_time as date',
                                    DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_name'), 'users.picture',
                                    'requests.amount')
                                    ->get()
                                    ->toArray();

        $response_array = array(
                'success' => true,
                'requests' => $requests
        );

        return response()->json(Helper::null_safe($response_array) , 200);
    }

    public function single_request(Request $request) {
    }

    public function rate_provider(Request $request)
    {
        $user = User::find($request->id);

        $validator = Validator::make(
            $request->all(),
            array(
                'request_id' => 'required|integer|exists:requests,id,user_id,'.$user->id.'|unique:user_ratings,request_id',
                'rating' => 'required|integer|in:'.RATINGS,
                'comments' => 'max:255'
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to user:'.$user->id,
                'unique' => 'The :attribute already rated.'
            )
        );
    
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
        
        } else {

            $request_id = $request->request_id;
            $comment = $request->comment;

            $req = Requests::find($request_id);
            //Save Rating
            $rev_user = new UserRating();
            $rev_user->provider_id = $req->confirmed_provider;
            $rev_user->user_id = $req->user_id;
            $rev_user->request_id = $req->id;
            $rev_user->rating = $request->rating;
            $rev_user->comment = $comment ? $comment: '';
            $rev_user->save();

            $req->status = REQUEST_COMPLETED;
            $req->save();

            // Send Push Notification to Provider
            // send_push_notification($req->confirmed_provider, PROVIDER, 'User Rated', 'The user rated your service.');

            $response_array = array(
                'success' => true
            );

        }

        $response = response()->json(Helper::null_safe($response_array), 200);
        return $response;
    } 

    public function provider_list(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'
            ));

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response_array = array('success' => false, 'error' => get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            /*Get default search radius*/
            $settings = Settings::where('key', 'search_radius')->first();
            $distance = $settings->value;
            $available = 1;

            $query = "SELECT providers.id,first_name,last_name,latitude,longitude,
                            1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance
                      FROM providers
                      WHERE is_available IN ($available) AND is_activated = 1 AND is_approved = 1
                            AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                      ORDER BY distance";

            $providers = DB::select(DB::raw($query));

            $response_array = array(
                'success' => true,
                'providers' => $providers
            );
        }

        return response()->json(Helper::null_safe($response_array) , 200);
    }

    public function get_cards(Request $request) {

        $user_cards = Cards::where('user_id' , $request->id)->get();

        $data = array(); $card_data = array();

        if($user_cards) {
            foreach ($user_cards as $c => $card) {

                $data['id'] = $card->id;
                $data['customer_id'] = $card->customer_id;
                $data['card_id'] = $card->card_token;
                $data['last_four'] = $data->last_four;
                $data['is_default']= $data->is_default;

                array_push($card_data, $data);
            
            }

            $response_array = array('success' => true ,'cards' => $card_data);

        } else{
            $response_array = array('success' => false , 'error' => Helper::get_error_message(130) , 'error_code' => 130);
        }
        return response()->json(Helper::null_safe($response_array) , 200);
    }

    public function add_card(Request $request)
    {

        $user = User::find($request->id);

        $payment_token = $request->payment_token;
        $last_four = $request->last_four;

        $validator = Validator::make(
                    $request->all(),
                    array(
                        'last_four' => 'required',
                        'payment_token' => 'required',
                    )
                );

        if ($validator->fails())
        {
           $error_messages = implode(',', $validator->messages()->all());
           $response_array = array('success' => false , 'error' => Helper::get_error_message(101) , 'error_code' => 101 , 'error_messages' => $error_messages);

        } else {   

            try{

                // Get the key from settings table

                $settings = Settings::where('key' , 'stripe_secret_key')->first();

                $stripe_secret_key = $settings->value;
                
                \Stripe\Stripe::setApiKey($stripe_secret_key);

                $customer = \Stripe\Customer::create(array(
                              "card" => $payment_token,
                              "description" => $user->email)
                            );

                Log::info('customer = '.print_r($customer, true));

                if($customer){

                    $customer_id = $customer->id;

                    $cards = new Cards;
                    $cards->user_id = $request->id;
                    $cards->customer_id = $customer_id;
                    $cards->last_four = $last_four;
                    $cards->card_token = $customer->sources->data[0]->id;

                    // Check is any default is available
                    $check_card = Cards::where('user',$request->id)->first();

                    if($check_card ) 
                        $cards->is_default = 0;
                    else
                        $cards->is_default = 1;
                    
                    $cards->save();

                    $response_array = array('success' => true);
                    $response_code = 200;
                
                } else {
                    $response_array = array('success' => false , 'error' => 'Could not create client ID' , 'error_code' => 450);
                    $response_code = 200;
                }
                
                
            } catch(Exception $e) {
                $response_array = array('success' => false , 'error' => $e , 'error_code' => 101);
                $response_code = 200;
            
            }
            
        }
    
        $response = response()->json(Helper::null_safe($response_array) ,200);
        return $response; 
    }

    public function delete_card(Request $request)
    {
        $card_id = $request->card_id;

        $validator = Validator::make(
            $request->all(),
            array(
                'card_id' => 'required|integer|exists:cards,id,user_id,'.$request->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to user:'.$request->id
            )
        );

        if ($validator->fails())
        {
           $error_messages = implode(',', $validator->messages()->all());

           $response_array = array('success' => false , 'error' => Helper::get_error_message(101) , 'error_code' => 101 , 'error_messages' => $error_messages);

           $response_code = 200;
        } else {

            Cards::where('id',$card_id)->delete();
            $response_array = array('success' => true );
        }
    
        return response()->json(Helper::null_safe($response_array) , 200);
       
    }
    public function default_card(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'card_id' => 'required|integer|exists:cards,id,user_id,'.$request->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to user:'.$request->id
            )
        );

        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {
            
            $old_default = Cards::where('user_id' , $request->id)->where('is_default', DEFAULT_TRUE)->update(array('is_default' => DEFAULT_FALSE));

            $card = Cards::where('id' , $request->card_id)->update(array('is_default' => DEFAULT_TRUE));


            if($card) {
                $response_array = array('success' => true);
            } else {
                $response_array = array('success' => false , 'error' => 'Something went wrong');
            }
        }
        return response()->json(Helper::null_safe($response_array) , 200);
    
    }


}






