<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use App\Settings;

use App\Requests;

use App\RequestsMeta;

use App\ServiceType;

use App\User;

use App\Provider;

use App\ChatMessage;

use App\Jobs\NormalPushNotification;

use App\Jobs\sendPushNotification;

use DB;

use Log;

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
define('WAITING_FOR_PROVIDER_CONFRIMATION_COD',  8);

define('REQUEST_REJECTED_BY_PROVIDER', 9);


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

class ApplicationController extends Controller
{
    public function assign_next_provider_cron(){

        Log::info("CRON STARTED");

        $settings = Settings::where('key', 'provider_select_timeout')->first();
        $provider_timeout = $settings->value;
        $time = date("Y-m-d H:i:s");
        //Log::info('assign_next_provider_cron ran at: '.$time);

        //Get all the new waiting requests which are not confirmed and not cancelled.
        $query = "SELECT id, user_id,request_type,provider_id, TIMESTAMPDIFF(SECOND,request_start_time, '$time') AS time_since_request_assigned
                  FROM requests
                  WHERE status = ".REQUEST_WAITING;
        $requests = DB::select(DB::raw($query));

        foreach ($requests as $request) {

            if ($request->time_since_request_assigned >= $provider_timeout) {

                $current_offered_provider = RequestsMeta::where('request_id',$request->id)
                                ->where('status', REQUEST_META_OFFERED)
                                ->first();

                $provider_id = array();

                if($current_offered_provider) {
                    $provider_id = $current_offered_provider->provider_id;
                }

                // To change the current provider availability and next provider status ,push notification changes
                Helper::assign_next_provider($request->id,$provider_id);

            } else {
                Log::info("Provider Waiting State");
            }
        }
    }

    public function message_save(Request $request)
    {
        $this->validate($request, [
                "request_id" => "required|integer",
                "user_id" => "required|integer",
                "provider_id" => "required|integer",
                "type" => "required|in:up,pu",
                "message" => "required",
            ]);

        $title = Helper::get_push_message(605);
        $messages = $request->message;
        if($request->type == 'up')
        {
            $this->dispatch( new NormalPushNotification($request->provider_id, PROVIDER,$title, $messages));
            Log::info('Push Sent to Provider');
        }
        if($request->type == 'pu')
        {
            $this->dispatch( new NormalPushNotification($request->user_id, USER,$title, $messages));
            Log::info('Push Sent to User');
        }
        
        return ChatMessage::create($request->all());
    }
}

