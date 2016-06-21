<?php

namespace App\Jobs;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Provider;
use App\Settings;
use App\ProviderRating;
use App\Requests;
use App\Jobs\Job;
use App\Helpers\Helper;
use Log;

class sendPushNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $id;
    protected $user_type;
    protected $request_id;
    protected $title;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id,$user_type,$request_id,$title,$message)
    {
        $this->id = $id;
        $this->user_type = $user_type;
        $this->request_id = $request_id;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Request Push Notification Queue Started");
        // Get the request details
        if($requests = Requests::find($this->request_id)) {
            
            // Check the user type whether "USER" or "PROVIDER"
            if($this->user_type == 0) {
                $user = User::find($this->id);
            } else {
                $user = Provider::find($this->id);
            }

            // Get the provider timeout from the admin settings
            $settings = Settings::where('key', 'provider_select_timeout')->first();
            $provider_timeout = $settings->value;

            $push_data = array();
            $push_data['request_id'] = $requests->id;
            $push_data['service_type'] = $requests->request_type;
            $push_data['request_start_time'] = $requests->request_start_time;
            $push_data['status'] = $requests->status;
            $push_data['user_name'] = $user->first_name."".$user->last_name;
            $push_data['user_picture'] = $user->picture;
            $push_data['s_address'] = $requests->s_address;
            $push_data['s_latitude'] = $requests->s_latitude;
            $push_data['s_longitude'] = $requests->s_longitude;
            $push_data['user_rating'] = ProviderRating::where('provider_id', 1)->avg('rating') ?: 0;
            $push_data['time_left_to_respond'] = $provider_timeout - (time() - strtotime($requests->request_start_time));

            $push_message = array(
                    'success' => true,
                    'message' => $this->message,
                    // 'data' => array((object) $push_data)
                );

            $push_notification = 1; // Check the push notifictaion is enabled

            if ($push_notification == 1) {

                if ($user->device_type == 'ios') {

                    Log::info("iOS push Started");

                    require_once app_path().'/ios/apns.php';

                    Log::info($user->device_token);

                    $msg = array(
                        "alert" => "" . $this->title,
                        "status" => "success",
                        "title" => $this->title,
                        // "message" => $push_message,
                        "badge" => 1,
                        "sound" => "default",
                        "status" => $requests->status,
                        "rid" => $requests->id,
                        );

                    if (!isset($user->device_token) || empty($user->device_token)) {
                        $deviceTokens = array();
                    } else {
                        $deviceTokens = $user->device_token;
                    }

                    $apns = new \Apns();
                    $apns->send_notification($deviceTokens, $msg);

                    Log::info("iOS push end");

                } else {

                    Log::info("Andriod push Started");

                    require_once app_path().'/gcm/GCM_1.php';
                    require_once app_path().'/gcm/const.php';

                    if (!isset($user->device_token) || empty($user->device_token)) {
                        $registatoin_ids = "0";
                    } else {
                        $registatoin_ids = trim($user->device_token);
                    }
                    if (!isset($push_message) || empty($push_message)) {
                        $msg = "Message not set";
                    } else {
                        $msg = $push_message;
                    }
                    if (!isset($this->title) || empty($this->title)) {
                        $title1 = "Message not set";
                    } else {
                        $title1 = trim($this->title);
                    }

                    $message = array(TEAM => $title1, MESSAGE => $msg);

                    $gcm = new \GCM();
                    $registatoin_ids = array($registatoin_ids);
                    $gcm->send_notification($registatoin_ids, $message);

                    Log::info("Andriod push end");
                }
            
            } else {
                Log::info('Push notifictaion is not enabled. Please contact admin');
            }
        } else {
            Log::info("Request Details not found");
        }
    }
}
