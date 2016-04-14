<?php // Code within app\Helpers\Helper.php

   namespace App\Helpers;

   use Hash;

    class Helper
    {
        // Note: $error is passed by reference
        public static function is_token_valid($entity, $id, $token, &$error)
        {
            if (
                ( $entity==USER   && ($row = User::where('id', '=', $id)->where('token', '=', $token)->first()) ) ||
                ( $entity==PROVIDER  && ($row = Provider::where('id', '=', $id)->where('token', '=', $token)->first()) )
            ) {
                if ($row->token_expiry > time()) {
                    // Token is valid
                    $error = NULL;
                    return $row;
                } else {
                    $error = array('success' => false, 'error' => get_error_message(103), 'error_code' => 103);
                    return FALSE;
                }
            }
            $error = array('success' => false, 'error' => get_error_message(104), 'error_code' => 104);
            return FALSE;
        }

        public static function send_user_welcome_email($user)
        {
            $email  = $user->email;
            $id     = $user->id;
            $referral_code = mt_rand(100000,999999); 
            $ledger = new ReferralLedger;
            $ledger->user_id = $id;
            $ledger->referral_code = $referral_code;
            $ledger->save();

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

                $s3_url = web_url().'/uploads/'.$local_url;
                
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
            return clean(Hash::make(rand() . time() . rand()));
        }

        public static function generate_token_expiry()
        {
            return time() + 24*3600*30;  // 30 days
        }

        public static function send_user_forgot_email($email,$email_data,$subject)
        {
            Mail::send('emails.user.forgot_password', array('email_data' => $email_data), function ($message) use ($email, $subject) {
                        $message->to($email)->subject($subject);
                });
        }
        public static function send_provider_forgot_email($email,$email_data,$subject)
        {
            Mail::send('emails.provider.forgot_password', array('email_data' => $email_data), function ($message) use ($email, $subject) {
                        $message->to($email)->subject($subject);
                });
        }

        public static function send_provider_welcome_email($provider)
        {
            $email = $provider->email;
            $name = "$provider->first_name $provider->last_name";
            Mail::send('emails.provider.welcome',
                array('provider' => $provider),
                function($message) use ($email, $name) {
                    $message->to($email, $name)
                        ->subject(Config::get('app.title')." ".tr('account_verification'));
                });
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

    }





