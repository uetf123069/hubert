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

use App\FavouriteProvider;



define('USER', 0);
define('PROVIDER',1);


define('NONE', 0);


define('DEFAULT_FALSE', 0);
define('DEFAULT_TRUE', 1);


define('REQUEST_NEW',        0);
define('REQUEST_WAITING',      1);
define('REQUEST_INPROGRESS',    2);
define('REQUEST_RATING',      3);
define('REQUEST_COMPLETE_PENDING',  4);
define('REQUEST_COMPLETED',      5);
define('REQUEST_CANCELLED',      6);
define('REQUEST_NO_PROVIDER_AVAILABLE',7);
define('REQUEST_CANCEL_USER',8);
define('REQUEST_CANCEL_PROVIDER',9);



define('PROVIDER_NOT_AVAILABLE', 0);
define('PROVIDER_AVAILABLE', 1);

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

define('RATINGS', '1,2,3,4,5');

define('DEVICE_ANDROID', 'android');
define('DEVICE_IOS', 'ios');



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

define('REQUEST_INPROGRESS', 5);

define('REQUEST_STARTED' , 6);

define('REQUEST_ARRIVED' , 7);

define('SERVICE_STARTED' , 8);

define('REQUEST_COMPLETED' , 9);

define('REQUEST_CANCEL_PROVIDER' , 10);

define('REQUEST_CANCEL_USER' , 11); 

define('PROVIDER' , 'PROVIDER');

define('USER' , 'USER');

define('PROVIDER_NOT_AVAILABLE', 0);

define('PROVIDER_IS_AVAILABLE', 1);

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
                'email' => 'required|email',
            )
        );

        if ($validator->fails()) {

            $error_messages = implode(',',$validator->messages()->all());
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

    public function changePassword(Request $request) {

        $old_password = $request->old_password;
        $new_password = $request->password;
        $confirm_password = $request->confirm_password;
        
        $validator = Validator::make($request->all(), [              
                'password' => 'required',
                'old_password' => 'required',
                'confirm_password' => 'required',
            ]);

        if($validator->fails()) {

            $error_messages = implode(',',$validator->messages()->all());

            $response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages );

            $response_code = 200;

        } else {

            if($user = User::find($request->id)) {

                if(Hash::check($old_password,$user->password))
                {
                    $user->password = Hash::make($new_password);
                    $user->save();

                    $response_array = array('success' => true , 'message' => Helper::get_message(102));
                    $response_code = 200;
                    
                } else {
                    $response_array = array('success' => false , 'error' => Helper::get_error_message(131), 'error_code' => 131);
                    $response_code = 200;
                }

            } else {

                $response_array = array('success' => false , 'error' => 'User ID not found');
                $response_code = 200;
            }

        }

        $response = response()->json($response_array,$response_code);

        return $response;
    
    }


    public function userDetails(Request $request)
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
            'mobile' => $user->mobile,
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

    public function updateProfile(Request $request)
    {
        $user_id = $request->id;

        $validator = Validator::make(
            $request->all(),
            // The param names are changed to match the param names in api doc and email validation added to check email existence in db other than the current user 
            array(
                    'device_token' => 'required',
                    'id' => 'required',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|unique:users,email,'.$user_id.'|max:255',
                    'mobile' => 'required|digits_between:6,13',
                    'picture' => 'mimes:jpeg,bmp,png',
            ));

        if ($validator->fails()) {

            $error_messages = implode(',',$validator->messages()->all()); // Error messages added in response for debugging

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

            if ($picture != "") {

                //deleting old image if exists
                //if( $user->picture != "" && file_exists( parse_url($user->picture, PHP_URL_PATH) ) )

                Helper::delete_picture($user->picture);

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

    public function tokenRenew(Request $request)
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

    public function serviceList(Request $request)
    {
        $response_array =  array();

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

        $response = response()->json($response_array, 200);
        return $response;

    }

    public function singleService(Request $request)
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

    public function sendRequest(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                array(
                    's_latitude' => 'required|numeric',
                    's_longitude' => 'required|numeric',
                    'service_type' => 'numeric',
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

                $check_status = array(REQUEST_CANCEL_USER,REQUEST_CANCEL_PROVIDER,REQUEST_COMPLETED);

                $check_requests = Requests::where('user_id' , $request->id)->whereNotIn('status' , $check_status)->count();


                if($check_requests == 0) {

                    Log::info('Previous requests check is done');
            
                    $service_type = $request->service_type; // Get the service type 

                    /** Favourite Providers Search Start */

                    Log::info('Favourite Providers Search Start');

                    $favProviders = array();  // Initialize the variable

                     // Get the favourite providers list

                    $fav_providers_query = FavouriteProvider::leftJoin('providers' , 'favourite_providers.provider_id' ,'=' , 'providers.id')
                            ->where('providers.is_available' , DEFAULT_TRUE)
                            ->where('providers.is_activated' , DEFAULT_TRUE)
                            ->where('providers.is_approved' , DEFAULT_TRUE);

                    if($service_type) {

                        $provider_services = ProviderService::where('service_type_id' , $service_type)
                                                ->where('is_available' , DEFAULT_TRUE)
                                                ->get();

                        $provider_ids = array();

                        if($provider_services ) {

                            foreach ($provider_services as $key => $provider_service) {
                                # code...
                                $provider_ids[] = $provider_service->provider_id;
                            }

                            $favProviders = $fav_providers_query->whereIn('provider_id' , $provider_ids)->get();
                        }
                                       
                    } else {
                        $favProviders = $fav_providers_query->get();
                    }

                    // Check Favourite Providers list is not empty

                    if($favProviders) {

                        // Initialize the variable

                        $list_fav_providers = array();

                        $first_provider_id = 0;

                        foreach ($favProviders as $key => $favProvider) {

                            $list_fav_providers[] = $favProvider->provider_id;

                            // Assign value to the first_provider_id to send push notifications

                            if($first_provider_id == 0) {
                                $first_provider_id = $favProvider->provider_id;
                            }

                        }
                    
                    }


                    Log::info('List Of Favourite Providers' .print_r($list_fav_providers, true));

                    /** Favourite Providers Search End */

                    $s_latitude = $latitude = $request->s_latitude;
                    $s_longitude = $longitude = $request->s_longitude;

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

                    // Check the service type value to search the providers based on the nearby location

                    if($service_type) {

                        Log::info('Location Based search started - service_type');

                        // Get the providers based on the selected service types

                        $service_providers = ProviderService::where('service_type_id' , $service_type)->where('is_available' , 1)->get();

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

                        Log::info('Location Based search started - without service_type');

                        $query = "SELECT providers.id, 1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance FROM providers
                                WHERE is_available = 1 AND is_activated = 1 AND is_approved = 1
                                AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                                ORDER BY distance";

                        $providers = DB::select(DB::raw($query));

                        Log::info("Search query: " . $query);
                    
                    }

                    Log::info('List of providers'." ".print_r($providers));

                    $final_providers = array();

                    if ($providers) 
                    {
                        // Initialize Final list of provider variable

                        $search_providers = array();

                        foreach ($providers as $provider) 
                        {
                            // Check the first_provider_id has already value , because if the user have fav providers means the first_provider_id will be assign over there itself

                            if(!$first_provider_id) {
                                $first_provider_id = $provider->id;
                            }

                            $search_providers[] = $provider->id;
                        
                        }

                    } else {

                        // No provider found

                        Log::info("No Provider Found");

                        // Send push notification to User

                        // Helper::send_push_notification($user->id, USER, Helper::get_push_message(601), Helper::get_push_message(602));

                        $response_array = array('success' => false, 'error' => Helper::get_error_message(112), 'error_code' => 112);
                    
                    }

                    // Merge the favourite providers and search providers

                    $final_providers = array_unique(array_merge($list_fav_providers,$search_providers));

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

                        $requests->status = REQUEST_SEND;
                        $requests->current_provider = $first_provider_id;
                        $requests->save();

                        if ($first_provider_id) {

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
                            $push_data['s_address'] = $requests->s_address;
                            $push_data['d_address'] = $requests->d_address;
                            $push_data['s_latitude'] = $requests->s_latitude;
                            $push_data['s_longitude'] = $requests->s_longitude;
                            $push_data['d_latitude'] = $requests->d_latitude;
                            $push_data['d_longitude'] = $requests->d_longitude;
                            // $push_data['user_rating'] = ProviderRating::where('provider_id', $provider->id)->avg('rating') ?: 0;
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

                                    $request_meta->status = REQUEST_SEND;  // Request status change

                                    // Availablity status change 

                                    if($current_provider = Provider::find($first_provider_id)) {

                                        $current_provider->is_available = PROVIDER_NOT_AVAILABLE;
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

                    $response_array = array('success' => false , 'error' => Helper::get_error_message(127) , 'error_code' => 127);
                }

            }
        }

        $response = response()->json($response_array, 200);
        return $response;

    }

    public function cancelRequest(Request $request) {

        // Validate the request_id

        $validator = Validator::make($request->all() , 
            array(
                    'request_id' => 'required|integer',
                ));

        if($validator->fails()) {

            $error_messages = implode(",", $validator->messages()->all());

            $response_array = array('success' => false , 'error' => Helper::get_error_message(101) , 'error_code' => 101 , 'error_messages' => $error_messages);

        } else {

            // Get the particular request details 

            $request_query = Requests::where('id' , $request->request_id)->where('user_id' , $request->id);

            // Check the request details are not empty 

            if($request_query->count() != 0) {

                $requests = $request_query->first();

                // Check the status of the request is not reached "SERVICE_STARTED" status

                if($requests->status <= REQUEST_ARRIVED) {

                    // Detect amount from User

                    // Get Request Meta details

                    $request_metas = RequestsMeta::where('request_id' , $request->request_id)->get();

                    // Check the request_metas is not empty

                    if($request_metas) {

                        foreach ($request_metas as $rm => $request_meta) {

                            $request_meta->status = REQUEST_CANCEL_USER;
                            $request_meta->save();    
                            
                        }
                    }

                    // Change the status of the request

                    $requests->status = REQUEST_CANCEL_USER;

                    $requests->save();

                    // Send notification to the provider

                    // Push Start

                    $user = User::find($request->id);

                    $push_data = array();
                    $push_data['request_id'] = $requests->id;
                    $push_data['service_type'] = $requests->request_type;
                    $push_data['request_start_time'] = $requests->request_start_time;
                    $push_data['status'] = $requests->status;
                    $push_data['amount'] = $requests->amount;
                    $push_data['user_name'] = $user->name;
                    $push_data['user_picture'] = $user->picture;

                    $title = "Cancel Request";
                    $message = $user->name." "." cancelled the request";

                    $push_message = array(
                        'success' => true,
                        'message' => $message,
                        'data' => array((object) Helper::null_safe($push_data))
                    );

                    // Send Push Notification to Provider

                    //  send_push_notification($first_provider_id, PROVIDER, $title, $push_message);

                    // Push End

                } else {   // If reached the "SERVICE_STARTED" status

                }

            } else {    // If request details are empty

                $response_array = array('success' => false , 'error' => Helper::get_error_message(129) , 'error_code' => 129);
            }
            
        }

        return response()->json(Helper::null_safe($response_array),200);

    }

    public function requestStatusCheck(Request $request) {

        $check_status = array(); // Initialize the check_status variable

        $check_status = array(REQUEST_REJECT_PROVIDER,REQUEST_CANCEL_PROVIDER,REQUEST_CANCEL_USER,REQUEST_COMPLETED);

        $requests = Requests::whereNotIn('status' , $check_status)->where('user_id' , $request->id)->get();

        $request_data = array(); // Initialize the request_data variable

        $request_dataa = array(); // Initialize the request_dataa variable

        // Get the provider timeout from admin settings

        $provider_timeout = 60;

        // Check the requests is empty or not

        if($requests) {

            foreach ($requests as $r => $req) {

                $request_data['request_id'] = $req->id;
                $request_data['user_id'] = $req->user_id;
                $request_data['current_provider'] = $req->current_provider;
                $request_data['confirmed_provider'] = $req->confirmed_provider;
                $request_data['request_type'] = $req->request_type;
                $request_data['request_start_time'] = $req->request_start_time;
                $request_data['s_latitude'] = $req->s_latitude;
                $request_data['s_longitude'] = $req->s_longitude;
                $request_data['d_latitude'] = $req->d_latitude;
                $request_data['d_longitude'] = $req->d_longitude;
                $request_data['s_address'] = $req->s_address;
                $request_data['d_address'] = $req->d_address;
                $request_data['time_left_to_respond'] = $provider_timeout - (time() - strtotime($req->request_start_time));
                $request_data['status'] = $req->status;

                array_push($request_dataa, $request_data);
            }

            $response_array = array('success' => true , 'requests' => $request_dataa );

        } else {

            $response_array = array('success' => false , 'error' => Helper::get_error_message(128) , 'error_code' => 128);

        }

        // Send the response

        return response()->json(Helper::null_safe($response_array,200));

    } 

    public function paybypaypal(Request $request) {

        $validator = Validator::make($request->all() , 
            array(
                'amount' => "required",
                'is_paid' => "required",
                'request_id' => "required|integer",
            ));


        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);

        } else {

            // Check the request id exists and check the user ID matches with the request
            $requests_query = Requests::where('id' , $request->request_id)->where('user_id' , $request->id);

            if($requests_query->count() != 0) {

                $requests = $requests_query->first();

                // Check the status is completed

                if($requests->status == REQUEST_COMPLETED) {

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
                    $response_array = array('success' => 'false' , 'error' => Helper::get_error_message(128) , 'error_code' => 128);
                }

            } else { // Else dont allow to save the details

                $response_array = array('success' => false , 'error' => Helper::get_error_message(129) , 'error_code' => 129);

            }

        }

        return response()->json(Helper::null_safe($response_array),200);

    }

    public function fav_providers(Request $request) {

        // $array1 = array(1,2,3,4);

        // $array2 = array( 
        //         '0.000' => 1,
        //         '0.333' => 10,
        //         '1.385' => 9,
        //         '5.55' => 9,
        //     );

        // dd(array_unique(array_merge($array1,$array2)));

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
                'fav_id' => "required",
            ));


        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);

        } else {

            if($favourite = FavouriteProvider::find($request->fav_id)) {

                if($provider = Provider::find($favourite->provider_id)) {

                    $fav_delete = FavouriteProvider::find($request->fav_id)->delete();

                    $response_array = array('success' => true , 'message' => Helper::get_message(108));

                } else {
                    $response_array = array('success' => false , 'error' => Helper::get_error_message(132) ,'error_code' =>132);
                }

            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(133) ,'error_code' =>133);
            }

        }

        return response()->json(Helper::null_safe($response_array) , 200);

    }

    public function history(Request $request) {

        // Get the completed request details 

        $requests = Requests::where('user_id' , $request->id)->where('status' , REQUEST_COMPLETED)->get();

        // Check the request details are not empty

        if($requests) {

            // Initialize the request_data variable

            $request_data = array();

            // Initialize the request_dataa variable

            $request_dataa = array();

            foreach ($requests as $key => $req) {
                
                $request_data['request_id'] = $req->id;
                $request_data['request_meta_id'] = $req->request_meta_id;
                $request_data['user_id'] = $req->user_id;
                $request_data['current_provider'] = $req->current_provider;
                $request_data['confirmed_provider'] = $req->confirmed_provider;
                $request_data['request_start_time'] = $req->request_start_time;

                // Check the provider details are not empty

                if($provider = Provider::find($req->confirmed_provider)) {
                    $request_data['provider_name'] = $provider->name;
                    $request_data['provider_email'] = $provider->email;
                    $request_data['provider_picture'] = $provider->picture;
                    $request_data['provider_mobile'] = $provider->mobile;
                
                } else {
                    $request_data['provider_name'] = "";
                    $request_data['provider_email'] = "";
                    $request_data['provider_picture'] = "";
                    $request_data['provider_mobile'] = "";
                
                }

                $request_data['user_id'] = $req->user_id;

                array_push($request_dataa, $request_data);
            }

            // Send Response
            $response_array = array('success' => true , 'requests' => $request_dataa);
        } else {

            $response_array = array('success' => false , 'error' => Helper::get_error_message(130) , 'error_code' => 130);

        }

        return response()->json(Helper::null_safe($response_array) , 200);

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
            $settings = Setting::where('key', 'search_radius')->first();
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

}






