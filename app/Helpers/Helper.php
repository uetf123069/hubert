<?php // Code within app\Helpers\Helper.php

   namespace App\Helpers;

   use Hash;

   use App\Admin;

   use App\User;

   use App\Provider;

   use Mail;

   use File;

   use Log;

    class Helper
    {

        public static function clean($string)
        {
            $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }

        public static function web_url()
        {
            return url('/');
        }

        // Note: $error is passed by reference
        public static function is_token_valid($entity, $id, $token, &$error)
        {
            if (
                ( $entity== 'USER' && ($row = User::where('id', '=', $id)->where('token', '=', $token)->first()) ) ||
                ( $entity== 'PROVIDER' && ($row = Provider::where('id', '=', $id)->where('token', '=', $token)->first()) )
            ) {
                if ($row->token_expiry > time()) {
                    // Token is valid
                    $error = NULL;
                    return $row;
                } else {
                    $error = array('success' => false, 'error' => Helper::get_error_message(103), 'error_code' => 103);
                    return FALSE;
                }
            }
            $error = array('success' => false, 'error' => Helper::get_error_message(104), 'error_code' => 104);
            return FALSE;
        }

        public static function send_user_welcome_email($user)
        {
            $email  = $user->email;
            $id     = $user->id;
            $referral_code = mt_rand(100000,999999); 
            

            $name = "$user->first_name $user->last_name";
            $admin   = Admin::find(1);
            $message = array(
                'subject' => 'Welcome to Uber X',
                'from_email' => $admin->email,
                'from_name' => "Admin",
                'to' => array(array('email' => $email, 'name' => $name)),
                'global_merge_vars' => array(
                array(
                    'name' => 'NAME',
                    'content' => $name),
                array(
                    'name' => 'REFERRALCODE',
                    'content' => $referral_code)
                    )
                );

            $template_name = 'bienvenido-v2-0-1';

            $_params = array("template_name" => $template_name, "template_content" => '', "message" => $message);

            $response = Mandrill::request('messages/send-template', $_params);
        }

        public static function upload_picture($picture)
        {
            $file_name = time();
            $file_name .= rand();
            $file_name = sha1($file_name);
            if ($picture) {
                $ext = $picture->getClientOriginalExtension();
                $picture->move(public_path() . "/uploads", $file_name . "." . $ext);
                $local_url = $file_name . "." . $ext;

                $s3_url = Helper::web_url().'/uploads/'.$local_url;
                
                return $s3_url;
            }
            return "";
        }

        // Convert all NULL values to empty strings
        public static function null_safe($arr)
        {
            $newArr = array();
            foreach ($arr as $key => $value) {
                $newArr[$key] = ($value == NULL) ? "" : $value;
            }
            return $newArr;
        }

        public static function generate_token()
        {
            return Helper::clean(Hash::make(rand() . time() . rand()));
        }

        public static function generate_token_expiry()
        {
            return time() + 24*3600*30;  // 30 days
        }

        public static function send_user_forgot_email($email,$email_data,$subject)
        {
            if(env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
               try
                {
                    Mail::send('emails.user.forgot_password', array('email_data' => $email_data), function ($message) use ($email, $subject) {
                            $message->to($email)->subject($subject);
                    });

                } catch(Exception $e) {

                    return Helper::get_error_message(123);

                }

                return Helper::get_message(105);

            } else {
                return Helper::get_error_message(123);
            }
           
        }
        public static function send_provider_forgot_email($email,$email_data,$subject)
        {            
            if(env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
                try
                {
                    // Log::info("mail Started//.....");

                    Mail::send('emails.provider.forgot_password', array('email_data' => $email_data), function ($message) use ($email, $subject) {
                            $message->to($email)->subject($subject);
                    });

                } catch(Exception $e) {

                    Log::info('Email Send Error message***********'.print_r($e,true));

                    return Helper::get_error_message(123);
                }

                return Helper::get_message(105);

            } else {
                return Helper::get_error_message(123);
            }
        }

        public static function send_provider_welcome_email($provider)
        {
            $email = $provider->email;

            $subject = "Account Verification";

            $email_data = $provider;

            if(env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
                try
                {
                    Log::info("Provider welcome mail started.....");

                    Mail::send('emails.provider.welcome', array('email_data' => $email_data), function ($message) use ($email, $subject) {
                            $message->to($email)->subject($subject);
                    });

                } catch(Exception $e) {

                    Log::info('Email send error message***********'.print_r($e,true));

                    return Helper::get_error_message(123);
                }

                return Helper::get_message(105);

            } else {

                return Helper::get_error_message(123);

            }
        }

        public static function get_error_message($code)
        {
            switch($code) {
                case 101:
                    $string = "Invalid input.";
                    break;
                case 102:
                    $string = "Email address is already in use.";
                    break;
                case 103:
                    $string = "Token expired.";
                    break;
                case 104:
                    $string = "Invalid token.";
                    break;
                case 105:
                    $string = "Invalid email or password.";
                    break;
                case 106:
                    $string = "All fields are required.";
                    break;
                case 107:
                    $string = "The current password is incorrect.";
                    break;
                case 108:
                    $string = "The passwords do not match.";
                    break;
                case 109:
                    $string = "There was a problem with the server. Please try again.";
                    break;
                case 110:
                    $string = "There is a delivery already in progress.";
                    break;
                case 111:
                    $string = "Email is not activated.";
                    break;
                case 112:
                    $string = "No provider found for the selected service in your area currently.";
                    break;
                case 113:
                    $string = "The delivery is already cancelled.";
                    break;
                case 114:
                    $string = "The delivery cancellation is not allowed at this point.";
                    break;
                case 115:
                    $string = "Invalid refresh token.";
                    break;
                case 116:
                    $string = "No provider assigned to this request id.";
                    break;
                case 117:
                    $string = "The delivery is cancelled by user.";
                    break;
                case 118:
                    $string = "The delivery is not completed.";
                    break;
                case 119:
                    $string = "You have pending payments of completed deliveries.";
                    break;
                case 120:
                    $string = "You should have at least one added card or minimum wallet balance.";
                    break;
                case 121:
                    $string = "You can use the referral code only once.";
                    break;
                case 122:
                    $string = "You can't use your own referral code.";
                    break;
                case 123:
                    $string = "Something went wrong in mail configuration";
                    break;
                case 124:
                    $string = "This Email is not registered";
                    break;
                case 125:
                    $string = "Not a valid social registration User";
                    break;
                case 126:
                    $string = "Something went wrong while sending request. Please try again.";
                    break;
                case 127;
                    $string = "Already request is in progress. Try again later";
                    break;
                case 128:
                    $string = "Request is not Completed. So you can't do the payment now.";
                    break;
                case 129:
                    $string = "Request Service ID and User ID are mismatched";
                    break;
                case 130:
                    $string = "No results found";
                    break;
                case 131:
                    $string = 'Password doesn\'t match';
                    break;
                case 132:
                    $string = 'Provider ID not found';
                    break;
                default:
                    $string = "Unknown error occurred.";
            }
            return $string;
        }

        public static function get_message($code)
        {
            switch($code) {
                case 101:
                    $string = "Success";
                    break;
                case 102:
                    $string = "Changed password successfully.";
                    break;
                case 103:
                    $string = "Successfully logged in.";
                    break;
                case 104:
                    $string = "Successfully logged out.";
                    break;
                case 105:
                    $string = "Successfully signed up.";
                    break;
                case 106:
                    $string = "Mail sent successfully";
                    break;
                case 107:
                    $string = "Payment successfully done";
                    break;
                case 108:
                    $string = "Favourite provider deleted successfully";
                    break;
                default:
                    $string = "";
            }
            return $string;
        }

        public static function get_push_message($code) {

            switch ($code) {
                case 601:
                    $string = "No Provider Available";
                    break;
                case 602:
                    $string = "No provider available to take the Service.";
                    break;
                case 603:
                    $string = "Request completed successfully";
                    break;
                default:
                    $string = "";
            }

            return $string;
        
        }

        public static function generate_password()
        {
            $new_password = time();
            $new_password .= rand();
            $new_password = sha1($new_password);
            $new_password = substr($new_password,0,8);
            return $new_password;
        }

        public static function delete_picture($picture) {
            File::delete( public_path() . "/uploads/" . basename($picture));
            return true;
        }

        public static function send_notifications($id, $type, $title, $message)
        {
            Log::info('push notification');

            $push_notification = 1; // Check the push notifictaion is enabled

            // Check the user type whether "USER" or "PROVIDER"

            if ($type == 'PROVIDER') {
                $user = Provider::find($id);
            } else {
                $user = User::find($id);
            }

            if ($push_notification == 1) {
                if ($user->device_type == 'ios') {
                    Helper::send_ios_push($user->device_token, $title, $message, $type);
                } else {

                    Helper::send_android_push($user->device_token, $title, $message);
                }
            }
        }

        public static function send_ios_push($user_id, $title, $message, $type)
        {
            require_once app_path().'ios/apns.php';

            $msg = array("alert" => "" . $title,
                "status" => "success",
                "title" => $title,
                "message" => $message,
                "badge" => 1,
                "sound" => "default");

            if (!isset($user_id) || empty($user_id)) {
                $deviceTokens = array();
            } else {
                $deviceTokens = $user_id;
            }

            $apns = new Apns();
            $apns->send_notification($deviceTokens, $msg);

            Log::info($deviceTokens);
        }

        public static function send_android_push($user_id, $message, $title)
        {
            require_once app_path().'/gcm/GCM_1.php';
            require_once app_path().'/gcm/const.php';

            if (!isset($user_id) || empty($user_id)) {
                $registatoin_ids = "0";
            } else {
                $registatoin_ids = trim($user_id);
            }
            if (!isset($message) || empty($message)) {
                $msg = "Message not set";
            } else {
                $msg = trim($message);
            }
            if (!isset($title) || empty($title)) {
                $title1 = "Message not set";
            } else {
                $title1 = trim($title);
            }

            $message = array(TEAM => $title1, MESSAGE => $msg);

            $gcm = new GCM();
            $registatoin_ids = array($registatoin_ids);
            $gcm->send_notification($registatoin_ids, $message);

        }

    }





