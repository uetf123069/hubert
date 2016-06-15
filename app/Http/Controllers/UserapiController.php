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

use App\Admin;

use App\RequestsMeta;

use App\ServiceType;

use App\Provider;

use App\Settings;

use App\FavouriteProvider;

use App\RequestPayment;

use App\UserRating;

use App\ProviderRating;

use App\Cards;

use App\ChatMessage;

use App\Jobs\NormalPushNotification;

use App\Jobs\sendPushNotification;


define('USER', 0);

define('PROVIDER',1);

define('NONE', 0);

define('DEFAULT_FALSE', 0);
define('DEFAULT_TRUE', 1);

// Payment Constants
define('COD',   'cod');
define('PAYPAL', 'paypal');
define('CARD',  'card');

// Request table status
define('REQUEST_NEW',        0);
define('REQUEST_WAITING',      1);
define('REQUEST_INPROGRESS',    2);
define('REQUEST_COMPLETE_PENDING',  3);
define('REQUEST_RATING',      4);                                                                      
define('REQUEST_COMPLETED',      5);
define('REQUEST_CANCELLED',      6);
define('REQUEST_NO_PROVIDER_AVAILABLE',7);

//Only when manual request
define('REQUEST_REJECTED_BY_PROVIDER', 8);

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
                                'gender' => 'in:male,female,others',
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
                if($request->has('gender')) {
                    $user->gender = $request->gender;
                }
                
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
                if(Settings::where('key' , COD)->where('value' , DEFAULT_TRUE)->first()) {

                    // Save the default payment method
                    $user->payment_mode = COD;
                }

                $user->save();

                $payment_mode_status = $user->payment_mode ? $user->payment_mode : 0;

                // Send welcome email to the new user:
                $subject = Helper::tr('user_welcome_title');
                $email_data = $user;
                $page = "emails.user.welcome";
                $email = $user->email;
                Helper::send_email($page,$subject,$email,$email_data);

                // Response with registered user details:

                $response_array = array(
                    'success' => true,
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'mobile' => $user->mobile,
                    'gender' => $user->gender,
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
                        if($user->is_activated) {
                            if(Hash::check($password, $user->password)){

                                /*manual login success*/
                                $operation = true;

                            }else{
                                $response_array = array( 'success' => false, 'error' => Helper::get_error_message(105), 'error_code' => 105 );
                            }
                        } else {
                            $response_array = array('success' => false , 'error' => Helper::get_error_message(144),'error_code' => 144);
                        }

                    } else {
                        $response_array = array( 'success' => false, 'error' => Helper::get_error_message(105), 'error_code' => 105 );
                    }
                }

            } else {
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
                        if($user->is_activated) {
                            /*social login success*/
                            $operation = true;
                        } else {
                            $response_array = array('success' => false , 'error' => Helper::get_error_message(144),'error_code' => 144);
                        }

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
                    'gender' => $user->gender,
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
        $email =$request->email;
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
            $user = User::where('email' , $email)->first();
            $new_password = Helper::generate_password();
            $user->password = Hash::make($new_password);
            
            $email_data = array();
            $subject = Helper::tr('user_forgot_email_title');
            $email_data['password']  = $new_password;
            $email_data['user']  = $user;
            $page = "emails.user.forgot_password";
            $email_send = Helper::send_email($page,$subject,$user->email,$email_data);

            $response_array['success'] = true;
            $response_array['message'] = Helper::get_message(106);
            $user->save();
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
        } else {
            $user = User::find($request->id);

            if(Hash::check($old_password,$user->password))
            {
                $user->password = Hash::make($new_password);
                $user->save();

                $response_array = Helper::null_safe(array('success' => true , 'message' => Helper::get_message(102)));
                
            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(131), 'error_code' => 131);
            }

        }

        $response = response()->json($response_array,200);
        return $response;
    
    }

    public function user_details(Request $request)
    {
        $user = User::find($request->id);

        $response_array = array(
            'success' => true,
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'mobile' => $user->mobile,
            'gender' => $user->gender,
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
                'id' => 'required',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'email|unique:users,email,'.$user_id.'|max:255',
                'mobile' => 'required|digits_between:6,13',
                'picture' => 'mimes:jpeg,bmp,png',
                'gender' => 'in:male,female,others',
                'device_token' => 'required',
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
            if($request->has('first_name')) {
                $user->first_name = $request->first_name;
            }
            if($request->has('last_name')) {
                $user->last_name = $request->last_name;
            }
            if($request->has('email')) {
                $user->email = $email;
            }
            if ($mobile != "")
                $user->mobile = $mobile;
            // Upload picture
            if ($picture != "") {
                Helper::delete_picture($user->picture); // Delete the old pic
                $user->picture = Helper::upload_picture($picture);
            }
            if($request->has('gender')) {
                $user->gender = $request->gender;
            }

            // Generate new tokens
            // $user->token = Helper::generate_token();
            // $user->token_expiry = Helper::generate_token_expiry();
            
            $user->save();

            $payment_mode_status = $user->payment_mode ? $user->payment_mode : "";

            $response_array = array(
                'success' => true,
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'mobile' => $user->mobile,
                'gender' => $user->gender,
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
            $response_array = Helper::null_safe(array('success' => true,'token' => $user->token));
        } else {
            $response_array = array('success' => false,'error' => Helper::get_error_message(115),'error_code' => 115);
        }

        $response = response()->json($response_array, 200);
        return $response;
    
    }

    public function service_list(Request $request) {
    
        if($serviceList = ServiceType::all()) {
            $response_array = Helper::null_safe(array('success' => true,'services' => $serviceList));
        } else {
            $response_array = array('success' => false,'error' => Helper::get_error_message(115),'error_code' => 115);
        }
        $response = response()->json($response_array, 200);
        return $response;

    }

    // Not using now
    public function single_service(Request $request) {
    
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
                $response_array = array('success' => true,'provider_details' => $provider_details_data);
                $response_array = Helper::null_safe($response_array);
            } else {
                $response_array = array('success' => false,'error' => Helper::get_error_message(115),'error_code' => 115);
            }
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function guest_provider_list(Request $request) {
        $validator = Validator::make(
            $request->all(),
            array(
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'
            ));

        if ($validator->fails()) {
            $error_messages = implode(',',$validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            /*Get default search radius*/
            $settings = Settings::where('key', 'search_radius')->first();
            $distance = $settings->value;

            $query = "SELECT providers.id,providers.first_name,providers.last_name,providers.latitude,providers.longitude,
                            1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) AS distance
                      FROM providers
                      WHERE is_available = 1 AND is_activated = 1 AND is_approved = 1
                            AND (1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance
                      ORDER BY distance";

            $providers = DB::select(DB::raw($query));

            $response_array = Helper::null_safe(array(
                'success' => true,
                'providers' => $providers
            ));
        }

        return response()->json($response_array , 200);
    }

    // Automated Request
    public function send_request(Request $request) {

        $validator = Validator::make(
                $request->all(),
                array(
                    's_latitude' => 'required|numeric',
                    's_longitude' => 'required|numeric',
                    'service_type' => 'numeric|exists:service_types,id',
                ), array( 'required' => 'Location Selected was incorrect! Please try again!'));

        if ($validator->fails()) 
        {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {
            Log::info('Create request start');
            // Check the user filled the payment details
            $user = User::find($request->id);
            if(!$user->payment_mode) {
                // Log::info('Payment Mode is not available');
                $response_array = array('success' => false , 'error' => Helper::get_error_message(134) , 'error_code' => 134);
            } else {

                $allow = DEFAULT_FALSE;
                // if the payment mode is CARD , check if any default card is available
                if($user->payment_mode == CARD) {
                    if($user_card = Cards::find($user->default_card)) {
                        $allow = DEFAULT_TRUE;
                    }
                } else {
                    $allow = DEFAULT_TRUE;
                }

                if($allow == DEFAULT_TRUE) {

                    // Check already request exists 
                    $check_status = array(REQUEST_NO_PROVIDER_AVAILABLE,REQUEST_CANCELLED,REQUEST_COMPLETED);

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

                                array_push($list_fav_providers, $list_fav_provider);
                            }                
                        }
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
                        // Initialize Final list of provider variable
                        $search_providers = array();
                        $search_provider = array();

                        if ($providers) {

                            foreach ($providers as $provider) {
                                $search_provider['id'] = $provider->id;
                                $search_provider['waiting'] = $provider->waiting;
                                $search_provider['distance'] = $provider->distance;
                                
                                array_push($search_providers, $search_provider);
                            }
                        } else {
                            if(!$list_fav_providers) {
                                Log::info("No Provider Found");
                                // Send push notification to User

                                $title = Helper::get_push_message(601);
                                $messages = Helper::get_push_message(602);
                                $this->dispatch( new NormalPushNotification($user->id, USER,$title, $messages));     
                                $response_array = array('success' => false, 'error' => Helper::get_error_message(112), 'error_code' => 112);
                            }
                        }

                        // Merge the favourite providers and search providers
                        $merge_providers = array_merge($list_fav_providers,$search_providers);

                        // Sort the providers based on the waiting time
                        $sort_waiting_providers = Helper::sort_waiting_providers($merge_providers);  

                        // Get the final providers list
                        $final_providers = $sort_waiting_providers['providers'];    
                                // 
                        $check_waiting_provider_count = $sort_waiting_providers['check_waiting_provider_count'];

                        if(count($final_providers) == $check_waiting_provider_count){
                            return response()->json($response_array = array('success' => false, 'error' => Helper::get_error_message(112), 'error_code' => 112) , 200);

                        }

                        // Create Requests
                        $requests = new Requests;
                        $requests->user_id = $user->id;

                        if($service_type)
                            $requests->request_type = $service_type;

                        $requests->status = REQUEST_NEW;
                        $requests->confirmed_provider = NONE;
                        $requests->request_start_time = date("Y-m-d H:i:s", $request_start_time);
                        $requests->s_address = $request->s_address ? $request->s_address : "";
                            
                        if($latitude){ $requests->s_latitude = $latitude; }
                        if($longitude) { $requests->s_longitude = $longitude; }
                            
                        $requests->save();

                        if($requests) {
                            $requests->status = REQUEST_WAITING;
                            //No need fo current provider state
                            // $requests->current_provider = $first_provider_id;
                            $requests->save();

                            // Save all the final providers
                            $first_provider_id = 0;

                            if($final_providers) {
                                foreach ($final_providers as $key => $final_provider) {

                                    $request_meta = new RequestsMeta;

                                    if($first_provider_id == 0) {

                                        $first_provider_id = $final_provider;

                                        $request_meta->status = REQUEST_META_OFFERED;  // Request status change

                                        // Availablity status change
                                        if($current_provider = Provider::find($first_provider_id)) {
                                            $current_provider->waiting_to_respond = WAITING_TO_RESPOND;
                                            $current_provider->save();
                                        }

                                        // Send push notifications to the first provider
                                        $title = Helper::get_push_message(604);
                                        $message = "You got a new request from".$user->name;

                                        $this->dispatch(new sendPushNotification($first_provider_id,PROVIDER,$requests->id,$title,$message));

                                        // Push End
                                    }

                                    $request_meta->request_id = $requests->id;
                                    $request_meta->provider_id = $final_provider; 
                                    $request_meta->save();
                                }
                            }
                            $response_array = array(
                                'success' => true,
                                'request_id' => $requests->id,
                                'current_provider' => $first_provider_id,
                                'address' => $requests->s_address,
                                'latitude' => $requests->s_latitude,
                                'longitude' => $requests->s_longitude,
                            );

                            $response_array = Helper::null_safe($response_array); Log::info('Create request end');
                        } else {
                            $response_array = array('success' => false , 'error' => Helper::get_error_message(126) , 'error_code' => 126 );
                        }     
                    } else {
                        $response_array = array('success' => false , 'error' => Helper::get_error_message(127) , 'error_code' => 127);
                    }

                } else {
                    $response_array = array('success' => false , 'error' => Helper::get_error_message(142) ,'error_code' => 142);
                }
            }
        }
        $response = response()->json($response_array, 200);
        return $response;
    
    }

    // Manual request
    public function manual_create_request(Request $request) {
        
        $validator = Validator::make(
                $request->all(),
                array(
                    's_latitude' => 'required|numeric',
                    's_longitude' => 'required|numeric',
                    'service_type' => 'numeric|exists:service_types,id',
                    'provider_id' => 'required|exists:providers,id',
                ));

        if ($validator->fails()) 
        {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {
            Log::info('Create request start');
            // Check the user filled the payment details
            $user = User::find($request->id);
            if(!$user->payment_mode) {
                Log::info('Payment Mode is not available');
                $response_array = array('success' => false , 'error' => Helper::get_error_message(134) , 'error_code' => 134);
            } else {

                $allow = DEFAULT_FALSE;
                // if the payment mode is CARD , check if any default card is available
                if($user->payment_mode == CARD) {
                    if($user_card = Cards::find($user->default_card)) {
                        $allow = DEFAULT_TRUE;
                    }
                } else {
                    $allow = DEFAULT_TRUE;
                }

                if($allow == DEFAULT_TRUE) {

                    // Check the provider is available
                    if($provider = Provider::where('id' , $request->provider_id)->where('is_available' , DEFAULT_TRUE)->where('is_activated' , DEFAULT_TRUE)->where('is_approved' , DEFAULT_TRUE)->where('waiting_to_respond' ,DEFAULT_FALSE)->first()) {

                        // Check already request exists 
                        $check_status = array(REQUEST_NO_PROVIDER_AVAILABLE,REQUEST_CANCELLED,REQUEST_COMPLETED);

                        $check_requests = Requests::where('user_id' , $request->id)->whereNotIn('status' , $check_status)->count();

                        if($check_requests == 0) {

                            Log::info('Previous requests check is done');
                           
                            // Create Requests
                            $requests = new Requests;
                            $requests->user_id = $user->id;

                            if($request->service_type)
                                $requests->request_type = $request->service_type;

                            $requests->status = REQUEST_NEW;
                            $requests->confirmed_provider = NONE;
                            $requests->request_start_time = date("Y-m-d H:i:s");
                            $requests->s_address = $request->s_address ? $request->s_address : "";
                                
                            if($request->s_latitude){ $requests->s_latitude = $request->s_latitude; }
                            if($request->s_longitude) { $requests->s_longitude = $request->s_longitude; }
                                
                            $requests->save();

                            if($requests) {
                                $requests->status = REQUEST_WAITING;
                                
                                $request_meta = new RequestsMeta;

                                $request_meta->status = REQUEST_META_OFFERED;  // Request status change

                                // Availablity status change
                                    $provider->waiting_to_respond = WAITING_TO_RESPOND;
                                    $provider->save();
                            

                                // Send push notifications to the first provider
                                $title = Helper::get_push_message(604);
                                $message = "You got a new request from".$user->name;

                                $this->dispatch(new sendPushNotification($request->provider_id,PROVIDER,$requests->id,$title,$message));

                                // Push End

                                $request_meta->request_id = $requests->id;
                                $request_meta->provider_id = $request->provider_id; 
                                $request_meta->save();

                                $response_array = array(
                                    'success' => true,
                                    'request_id' => $requests->id,
                                    'current_provider' => $request->provider_id,
                                    'address' => $requests->s_address,
                                    'latitude' => $requests->s_latitude,
                                    'longitude' => $requests->s_longitude,
                                );

                                $response_array = Helper::null_safe($response_array); Log::info('Create request end');
                            } else {
                                $response_array = array('success' => false , 'error' => Helper::get_error_message(126) , 'error_code' => 126 );
                            }     
                        
                        } else {
                            $response_array = array('success' => false , 'error' => Helper::get_error_message(127) , 'error_code' => 127);
                        }

                    } else {
                        $response_array = array('success' => false , 'error' => Helper::get_error_message(153) ,'error_code' => 153);
                    }
                } else {
                    $response_array = array('success' => false , 'error' => Helper::get_error_message(142) ,'error_code' => 142);
                }
            }
        }
        $response = response()->json($response_array, 200);
        return $response;   
    }

    public function cancel_request(Request $request) {
    
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
                PROVIDER_ACCEPTED,
                PROVIDER_STARTED,
            );

            // Check whether request cancelled previously
            if($requestStatus != REQUEST_CANCELLED)
            {
                // Check whether request eligible for cancellation

                if(in_array($providerStatus, $allowedCancellationStatuses)) {

                    // Update status of the request to cancellation
                    $requests->status = REQUEST_CANCELLED;
                    $requests->save();

                    // If request has confirmed provider then release him to available status
                    if($requests->confirmed_provider != DEFAULT_FALSE){

                        $provider = Provider::find( $requests->confirmed_provider );
                        $provider->is_available = PROVIDER_AVAILABLE;
                        $provider->save();

                        // clearing chat table
                        ChatMessage::where('request_id',$request_id)->delete();

                        // Send Push Notification to Provider
                        $title = Helper::tr('cancel_by_user_title');
                        $message = Helper::tr('cancel_by_user_message');
                        
                        $this->dispatch(new sendPushNotification($requests->confirmed_provider,PROVIDER,$requests->id,$title,$message));

                        Log::info("Cancelled request by user");
                        // Send mail notification to the provider
                        $email_data = array();

                        $subject = Helper::tr('request_cancel_user');

                        $email_data['provider_name'] = $email_data['username'] = "";

                        if($user = User::find($requests->user_id)) {
                            $email_data['username'] = $user->first_name." ".$user->last_name;    
                        }
                        
                        if($provider = Provider::find($requests->confirmed_provider)) {
                            $email_data['provider_name'] = $provider->first_name. " " . $provider->last_name;
                        }

                        $page = "emails.user.request_cancel";
                        $email_send = Helper::send_email($page,$subject,$provider->email,$email_data);
                    }

                    // No longer need request specific rows from RequestMeta
                    RequestsMeta::where('request_id', '=', $request_id)->delete();

                    $response_array = Helper::null_safe(array('success' => true,'request_id' => $request->id));

                } else {
                    $response_array = array( 'success' => false, 'error' => Helper::get_error_message(114), 'error_code' => 114 );
                }

            } else {
                $response_array = array( 'success' => false, 'error' => Helper::get_error_message(113), 'error_code' => 113 );
            }
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function waiting_request_cancel(Request $request) {

        $get_requests = Requests::where('user_id' , $request->id)->where('status' , REQUEST_WAITING)->get();

        if($get_requests) {
            foreach ($get_requests as $key => $requests) {
                $requests->status = REQUEST_CANCELLED;
                $requests->save();

                $requests_meta = RequestsMeta::where('request_id' , $requests->id);
                $current_provider = $requests_meta->where('status' , DEFAULT_TRUE)->first()->provider_id;
                if($provider = Provider::find($current_provider)) {
                    $provider->waiting_to_respond = WAITING_TO_RESPOND_NORMAL;
                    $provider->save();
                }

                $delete_request_meta = RequestsMeta::where('request_id' , $requests->id)->delete();

                //Send notification to the provider
                $title = Helper::tr('waiting_cancel_by_user_title');
                $message =  Helper::tr('waiting_cancel_by_user_message');

                Log::info("waiting cancelled - current provider".$current_provider);

                $this->dispatch(new sendPushNotification($current_provider,PROVIDER,$requests->id,$title,$message));
            }
        }

        $response_array = array('success' => true);

        return response()->json($response_array , 200);

    }

    public function request_status_check(Request $request) {

        $check_status = array(REQUEST_COMPLETED,REQUEST_CANCELLED,REQUEST_NO_PROVIDER_AVAILABLE);

        $requests = Requests::where('requests.user_id', '=', $request->id)
                            ->whereNotIn('requests.status', $check_status)
                            ->leftJoin('users', 'users.id', '=', 'requests.user_id')
                            ->leftJoin('providers', 'providers.id', '=', 'requests.confirmed_provider')
                            ->leftJoin('service_types', 'service_types.id', '=', 'requests.request_type')
                            ->select(
                                'requests.id as request_id',
                                'requests.request_type as request_type',
                                'service_types.name as service_type_name',
                                'requests.after_image as after_image',
                                'requests.before_image as before_image',
                                'requests.end_time as end_time',
                                'request_start_time as request_start_time',
                                'requests.status','providers.id as provider_id',
                                DB::raw('CONCAT(providers.first_name, " ", providers.last_name) as provider_name'),
                                'providers.picture as provider_picture',
                                'providers.mobile as provider_mobile',
                                'requests.provider_status',
                                'requests.amount',
                                DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_name'),
                                'users.picture as user_picture',
                                'users.id as user_id',
                                'requests.s_latitude',
                                'requests.s_longitude'
                            )->get()->toArray();

        $requests_data = array();
        $invoice = array();

        if($requests) {
            foreach ($requests as  $req) {

                $req['rating'] = DB::table('user_ratings')->where('provider_id', $req['provider_id'])->avg('rating') ?: 0;
                // unset($req['provider_id']);
                $requests_data[] = $req;

                $allowed_status = array(REQUEST_COMPLETE_PENDING,REQUEST_COMPLETED,REQUEST_RATING);

                if( in_array($req['status'], $allowed_status)) {
                    $invoice = RequestPayment::where('request_id' , $req['request_id'])
                                    ->leftJoin('requests' , 'request_payments.request_id' , '=' , 'requests.id')
                                    ->leftJoin('users' , 'requests.user_id' , '=' , 'users.id')
                                    ->leftJoin('cards' , 'users.default_card' , '=' , 'cards.id')
                                    ->where('cards.is_default' , DEFAULT_TRUE)
                                    ->select('requests.confirmed_provider as provider_id' , 'request_payments.total_time',
                                        'request_payments.payment_mode as payment_mode' , 'request_payments.base_price',
                                        'request_payments.time_price' , 'request_payments.tax_price' , 'request_payments.total',
                                        'cards.card_token','cards.customer_id','cards.last_four')
                                    ->get()->toArray();
                }
            }
        }

        $response_array = Helper::null_safe(array(
            'success' => true,
            'data' => $requests_data,
            'invoice' => $invoice
        ));
    
        $response = response()->json($response_array, 200);
        return $response;
    } 

    public function paybypaypal(Request $request) {

        $user = User::find($request->id);

        $validator = Validator::make($request->all() , 
            array(

                'request_id' => 'required|exists:requests,id,user_id,'.$request->id,
                'payment_mode' => 'required|in:'.PAYPAL.'|exists:settings,key,value,1',
                'is_paid' => 'required|in:'.DEFAULT_TRUE,
                'payment_id' => 'required',
            ),array(
                'exists' => 'The :attribute doesn\'t belong to user:'.$user->firstname.' '.$user->last_name,
                'in'      => 'The :attribute must be one of the following types: :values',
            )
            );
        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);

        } else {
            $requests = Requests::where('id',$request->request_id)->where('status' , REQUEST_COMPLETE_PENDING)->first();
            // Check the status is completed
            if( $requests && $requests->status != REQUEST_RATING) {

                if($requests->status == REQUEST_COMPLETE_PENDING) {

                    $requests->status = REQUEST_RATING;

                    $requests->is_paid = DEFAULT_TRUE;
                    $requests->amount = $request->amount;
                    $requests->save();

                    if($request_payment = RequestPayment::where('request_id' , $request->request_id)->first()) {

                        $request_payment->payment_id = $request->payment_id;
                        $request_payment->payment_mode = $request->payment_mode;
                        $request_payment->status = DEFAULT_TRUE;
                        $request_payment->save();
                    }

                    // Send push notification to provider

                    if($user)
                        $title =  "The"." ".$user->first_name.' '.$user->last_name." done the payment";
                    else
                        $title = Helper::tr('request_completed_user_title');

                    $message = Helper::tr('request_completed_user_message');                    
                    $this->dispatch(new sendPushNotification($requests->confirmed_provider,PROVIDER,$requests->id,$title,$message));

                     // Send mail notification to the provider
                    $subject = Helper::tr('request_completed_bill');
                    $email = Helper::get_emails(3,$request->id,$requests->confirmed_provider);
                    $page = "emails.user.invoice";
                    Helper::send_invoice($requests->id,$page,$subject,$email);

                    // Send Response
                    $response_array =  Helper::null_safe(array('success' => true , 'message' => Helper::get_message(107)));

                } else {
                    $response_array = array('success' => 'false' , 'error' => Helper::get_error_message(137) , 'error_code' => 137);
                }
            
            } else {
                $response_array = array('success' => 'false' , 'error' => Helper::get_error_message(138) , 'error_code' => 138);
            }
        }

        return response()->json($response_array,200);

    }

    public function paynow(Request $request) {

        $validator = Validator::make($request->all() , 
            array(
                    'request_id' => 'required|exists:requests,id,user_id,'.$request->id,
                    'payment_mode' => 'required|in:'.COD.','.PAYPAL.','.CARD.'|exists:settings,key,value,1',
                    'is_paid' => 'required',
                ),
            array(
                    'exists' => Helper::get_error_message(139),
                )
            );

        if($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false , 'error' => $error_messages , 'error_messages' => Helper::get_error_message(101));
        } else {

            $requests = Requests::where('id',$request->request_id)->where('status' , REQUEST_COMPLETE_PENDING)->first();
            $user = User::find($request->id);

            //Check current status of the request
            if($requests && intval($requests->status) != REQUEST_RATING ) {

                $total = 0;

                if($request_payment = RequestPayment::where('request_id' , $request->request_id)->first()) {
                    $request_payment->payment_mode = $request->payment_mode;
                    $request_payment->save();
                    $total = $request_payment->total;
                }

                if($request->payment_mode == COD) {

                    $requests->status = REQUEST_RATING;
                    $requests->is_paid = DEFAULT_TRUE;

                    $request_payment->payment_id = uniqid();
                    $request_payment->status = DEFAULT_TRUE;

                } elseif($request->payment_mode == CARD) {


                    $check_card_exists = User::where('users.id' , $request->id)
                                ->leftJoin('cards' , 'users.id','=','cards.user_id')
                                ->where('cards.id' , $user->default_card)
                                ->where('cards.is_default' , DEFAULT_TRUE);

                    if($check_card_exists->count() != 0) {

                        $user_card = $check_card_exists->first();

                        // Get the key from settings table
                        $settings = Settings::where('key' , 'stripe_secret_key')->first();
                        $stripe_secret_key = $settings->value;

                        $customer_id = $user_card->customer_id;
                    
                        \Stripe\Stripe::setApiKey($stripe_secret_key);

                        try{

                           $user_charge =  \Stripe\Charge::create(array(
                              "amount" => $total * 100,
                              "currency" => "usd",
                              "customer" => $customer_id,
                            ));

                           $payment_id = $user_charge->id;
                           $amount = $user_charge->amount/100;
                           $paid_status = $user_charge->paid;

                           $request_payment->payment_id = $payment_id;
                           $request_payment->status = 1;

                           if($paid_status) {
                                $requests->is_paid =  DEFAULT_TRUE;
                           }
                            $requests->status = REQUEST_RATING;
                            $requests->amount = $amount;
                        
                        } catch (\Stripe\StripeInvalidRequestError $e) {
                            Log::info(print_r($e,true));
                            $response_array = array('success' => false , 'error' => Helper::get_error_message(141) ,'error_code' => 141);
                        }

                    } else {
                        $response_array = array('success' => false, 'error' => Helper::get_error_message(140) , 'error_code' => 140);
                    }

                }  

                $requests->save();
                $request_payment->save();

                // Send notification to the provider Start
                if($user)
                    $title =  "The"." ".$user->first_name.' '.$user->last_name." done the payment";
                else
                    $title = Helper::tr('request_completed_user_title');

                $message = Helper::get_push_message(603);
                $this->dispatch(new sendPushNotification($requests->confirmed_provider,PROVIDER,$requests->id,$title,$message));
                // Send notification end

                // Send invoice notification to the user, provider and admin
                $subject = Helper::tr('request_completed_bill');
                $email = Helper::get_emails(3,$request->id,$requests->confirmed_provider);
                $page = "emails.user.invoice";
                Helper::send_invoice($requests->id,$page,$subject,$email);

                $response_array = array('success' => true);         

            } else {
                $response_array = array('success' => false,'error' => Helper::get_error_message(138) , 'error_code' => 138);
            }
        }

        return response()->json($response_array , 200);
    
    }

     public function rate_provider(Request $request) {

        $user = User::find($request->id);

        $validator = Validator::make(
            $request->all(),
            array(
                'request_id' => 'required|integer|exists:requests,id,user_id,'.$user->id.'|unique:user_ratings,request_id',
                'rating' => 'required|integer|in:'.RATINGS,
                'comments' => 'max:255',
                'is_favorite' => 'in:'.DEFAULT_TRUE.','.DEFAULT_FALSE,
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

            $req = Requests::where('id' ,$request_id)
                    ->where('status' ,REQUEST_RATING)
                    ->first();

            if ($req && intval($req->status) != REQUEST_COMPLETED) {
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

                // Save favourite provider details
                if($request->is_favorite ==  DEFAULT_TRUE) {
                    $fav_provider = FavouriteProvider::where('provider_id',$req->confirmed_provider)->where('user_id' , $request->id)->first();
                    if(!$fav_provider){
                        $favProvider = new FavouriteProvider;
                        $favProvider->provider_id = $req->confirmed_provider;
                        $favProvider->user_id = $request->id;
                        $favProvider->status = DEFAULT_TRUE;
                        $favProvider->save();
                    }
                }

                // Send Push Notification to Provider
                $title = Helper::tr('provider_rated_by_user_title');
                $messages = Helper::tr('provider_rated_by_user_message');
                $this->dispatch( new sendPushNotification($req->confirmed_provider, PROVIDER,$req->id,$title, $messages));     
                $response_array = array('success' => true);

            } else {
                $response_array = array('success' => false,'error' => Helper::get_error_message(150),'error_code' => 150);
            }
        }

        $response = response()->json($response_array, 200);
        return $response;
    } 

    public function add_fav_provider(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'fav_provider' => 'exists:providers,id'
            )
        );
    
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
        
        } else {
            // Save favourite provider details
            $fav_provider = FavouriteProvider::where('provider_id',$request->fav_provider)->where('user_id' , $request->id)->first();
            if(!$fav_provider){

                $favProvider = new FavouriteProvider;
                $favProvider->provider_id = $request->fav_provider;
                $favProvider->user_id = $request->id;
                $favProvider->status = DEFAULT_TRUE;
                $favProvider->save();

                $response_array = Helper::null_safe(array('success' => true));

            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(143) , 'error_code' => 143);
            }
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function fav_providers(Request $request) {

        $fav_providers = FavouriteProvider::where('favourite_providers.user_id' , $request->id)
                            ->leftJoin('providers' , 'favourite_providers.provider_id' , '=' ,'providers.id')
                            ->select('favourite_providers.id as favourite_id' ,'providers.id as provider_id' ,
                                DB::raw('CONCAT(providers.first_name, " ", providers.last_name) as provider_name'),'providers.picture'
                                )
                            ->get()
                            ->toArray();
        $providers = array();
        $data = array();

        if($fav_providers) {

            foreach ($fav_providers as $f => $fav_provider) {
                $fav_provider['user_rating'] = DB::table('user_ratings')->where('provider_id', $fav_provider['provider_id'])->avg('rating') ?: 0;
                $providers[] = $fav_provider;
            }

            $response_array = Helper::null_safe(array('success' => true , 'providers' => $providers));

        } else {
            $response_array = array('success' => false , 'error' => Helper::get_error_message(132) , 'error_code' => 132);
        }

        return response()->json($response_array,200);
    
    }

    public function delete_fav_provider(Request $request) {

        $favourite_id = $request->favourite_id;

        $validator = Validator::make($request->all() , 
            array(
                'favourite_id' => "required|exists:favourite_providers,id",
            ));
        if($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages' => $error_messages);
        } else {

            $favourite = FavouriteProvider::find($request->favourite_id);

            if($provider = Provider::find($favourite->provider_id)) {

                $fav_delete = $favourite->delete();

                $response_array = Helper::null_safe(array('success' => true , 'message' => Helper::get_message(108)));

            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(132) ,'error_code' =>132);
            }

        }

        return response()->json($response_array , 200);

    }

    public function history(Request $request) {
    
        // Get the completed request details 

        $requests = Requests::where('requests.user_id', '=', $request->id)
                            ->where('requests.status', '=', REQUEST_COMPLETED)
                            ->leftJoin('providers', 'providers.id', '=', 'requests.confirmed_provider')
                            ->leftJoin('users', 'users.id', '=', 'requests.user_id')
                            ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                            ->orderBy('request_start_time','desc')
                            ->select('requests.id as request_id', 'requests.request_type as request_type', 'request_start_time as date',
                                    DB::raw('CONCAT(providers.first_name, " ", providers.last_name) as provider_name'), 'providers.picture',
                                    DB::raw('ROUND(request_payments.total) as total'))
                                    ->get()
                                    ->toArray();

        $response_array = Helper::null_safe(array('success' => true,'requests' => $requests));

        return response()->json($response_array , 200);
    }

    public function single_request(Request $request) {

        $user = User::find($request->id);

        $validator = Validator::make(
            $request->all(),
            array(
                'request_id' => 'required|integer|exists:requests,id,user_id,'.$user->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t belong to user:'.$user->id,
            )
        );
    
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
        
        } else {

            $requests = Requests::where('requests.id' , $request->request_id)
                                ->leftJoin('providers' , 'requests.confirmed_provider','=' , 'providers.id')
                                ->leftJoin('users' , 'requests.user_id','=' , 'users.id')
                                ->leftJoin('user_ratings' , 'requests.id','=' , 'user_ratings.request_id')
                                ->leftJoin('request_payments' , 'requests.id','=' , 'request_payments.request_id')
                                ->leftJoin('cards','users.default_card','=' , 'cards.id')
                                ->select('providers.id as provider_id' , 'providers.picture as provider_picture',
                                    DB::raw('CONCAT(providers.first_name, " ", providers.last_name) as provider_name'),'user_ratings.rating','user_ratings.comment',
                                     DB::raw('ROUND(request_payments.base_price) as base_price'), DB::raw('ROUND(request_payments.tax_price) as tax_price'),
                                     DB::raw('ROUND(request_payments.time_price) as time_price'), DB::raw('ROUND(request_payments.total) as total'),
                                    'cards.id as card_id','cards.customer_id as customer_id',
                                    'cards.card_token','cards.last_four',
                                    'requests.id as request_id','requests.before_image','requests.after_image',
                                    'requests.user_id as user_id',
                                    DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_name'))
                                ->get()->toArray();

            $response_array = Helper::null_safe(array('success' => true , 'data' => $requests));
        }

        return response()->json($response_array , 200);
    
    }

    public function get_payment_modes(Request $request) {

        $payment_modes = array();
        $modes = Settings::whereIn('key' , array('cod','paypal','card'))->where('value' , 1)->get();
        if($modes) {
            foreach ($modes as $key => $mode) {
                $payment_modes[$mode->key] = $mode->key;
            }            
        }

        $response_array = Helper::null_safe(array('success' => true , 'payment_modes' => $payment_modes));

        return response()->json($response_array,200);
    }

    public function get_user_payment_modes(Request $request) {

        $user = User::find($request->id);

        if($user->payment_mode) {

            $payment_data = $data = $card_data = array();

            if($user_cards = Cards::where('user_id' , $request->id)->get()) {
                foreach ($user_cards as $c => $card) {
                    $data['id'] = $card->id;
                    $data['customer_id'] = $card->customer_id;
                    $data['card_id'] = $card->card_token;
                    $data['last_four'] = $card->last_four;
                    $data['is_default']= $card->is_default;

                    array_push($card_data, $data);
                }
            } 

            $response_array = Helper::null_safe(array('success' => true, 'payment_mode' => $user->payment_mode , 'card' => $card_data));

        } else {
            $response_array = array('success' => false , 'error' => Helper::get_error_message(130) , 'error_code' => 130);
        }
        return response()->json($response_array , 200);
    
    }
    
    public function payment_mode_update(Request $request) {
        
        $validator = Validator::make($request->all() , 
            array(
                'payment_mode' => 'required|in:'.COD.','.PAYPAL.','.CARD,
                )
            );
         if($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false ,'error' => $error_messages , 'error_messages' => Helper::get_error_message(101));
        } else {
            $user = User::where('id', '=', $request->id)->update( array('payment_mode' => $request->payment_mode));

            $response_array = Helper::null_safe(array('success' => true , 'message' => Helper::get_message(109)));
        }

        return response()->json($response_array , 200);

    }

    public function add_card(Request $request) {

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

            $user = User::find($request->id);

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

                    if($user) {
                        $user->payment_mode = CARD;
                        $user->default_card = $cards->id;
                        $user->save();
                    }

                    $response_array = Helper::null_safe(array('success' => true));
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
    
        $response = response()->json($response_array,200);
        return $response; 
    }

    public function delete_card(Request $request) {
    
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

            $user = User::find($request->id);

            if($user) {
                $user->payment_mode = CARD;
                $user->default_card = DEFAULT_FALSE;
                $user->save();
            }

            $response_array = array('success' => true );
        }
    
        return response()->json($response_array , 200);
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

            $user = User::find($request->id);
            
            $old_default = Cards::where('user_id' , $request->id)->where('is_default', DEFAULT_TRUE)->update(array('is_default' => DEFAULT_FALSE));

            $card = Cards::where('id' , $request->card_id)->update(array('is_default' => DEFAULT_TRUE));

            if($card) {
                if($user) {
                    $user->payment_mode = CARD;
                    $user->default_card = $request->card_id;
                    $user->save();
                }
                $response_array = Helper::null_safe(array('success' => true));
            } else {
                $response_array = array('success' => false , 'error' => 'Something went wrong');
            }
        }
        return response()->json($response_array , 200);
    
    }

    public function message_get(Request $request)
    {
        $Messages = ChatMessage::where('user_id', $request->id)
                ->where('provider_id', $request->provider_id);
                // ->orderBy('id', 'desc');

        $response_array = Helper::null_safe(array(
            'success' => true,
            'data' => $Messages->get()->toArray(),
        ));
    
        return response()->json($response_array, 200);
    }
}






