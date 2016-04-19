<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use Log;

use Hash;

use Validator;

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

    		if (! Helper::is_token_valid(USER, $user_id, $token, $error)) {
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
                        $response_array = array('success' => false, 'error' => 'Not a valid social registration User', 'error_code' => 404);
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
			Helper::send_user_forgot_email($user->email,$email_data,$subject);

			$response_array = array();
			$response_array['success'] = true;
			$response_code = 200;
			$response = response()->json($response_array, $response_code);
			return $response;

		}
		else{
			$response_array = array('success' => false, 'error' => 'This Email is not registered', 'error_code' => 425);
			$response_code = 200;
			$response = response()->json($response_array, $response_code);
			return $response;
		}
	}

    public function details_fetch(Request $request)
    {
        $user = User::find($request->id);

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
                        'email' => 'required|email|unique:user,email,'.$user_id.'|max:255',
                        'phone' => 'required|digits_between:6,13',
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
            $phone = $request->phone;
            $picture = $request->file('picture');

            $user = User::find($user_id);
            $user->name = $name;
            $user->email = $email;
            if ($phone != "")
                $user->phone = $phone;

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
                'phone' => $user->phone,
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

    public function renew_token(Request $request)
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
            if ($user = User::where('id', '=', $user_id)->where('token', '=', $token)->first()) {

                // Generate new tokens
                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();

                $user->save();

                $response_array = array(
                        'success' => true,
                        'token' => $user->token,
                        'token_refresh' => $user->token_refresh
                );
            } else {
                $response_array = array(
                        'success' => false,
                        'error' => Helper::get_error_message(115),
                        'error_code' => 115
                );
            }
        }

        $response = $response()->json($response_array, 200);
        return $response;
    }





}
