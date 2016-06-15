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

                // Change waiting to respond state
                if($current_offered_provider) {
                    $get_offered_provider = Provider::where('id',$current_offered_provider->provider_id)->first();
                    $get_offered_provider->waiting_to_respond = WAITING_TO_RESPOND_NORMAL;
                    $get_offered_provider->save();

                    // TimeOut the current assigned provider
                    $current_offered_provider->status = REQUEST_META_TIMEDOUT;
                    $current_offered_provider->save();
                }

                //Select the new provider who is in the next position.
                $next_request_meta = RequestsMeta::where('request_id', '=', $request->id)->where('status', REQUEST_META_NONE)
                                    ->leftJoin('providers', 'providers.id', '=', 'requests_meta.provider_id')
                                    ->where('providers.is_activated',DEFAULT_TRUE)
                                    ->where('providers.is_available',DEFAULT_TRUE)
                                    ->where('providers.is_approved',DEFAULT_TRUE)
                                    ->where('providers.waiting_to_respond',WAITING_TO_RESPOND_NORMAL)
                                    ->select('requests_meta.id','requests_meta.status','requests_meta.provider_id')
                                    ->orderBy('requests_meta.created_at')->first();

                //Check the next provider exist or not.

                if($next_request_meta){

                    // change waiting to respond state
                    $provider_detail = Provider::find($next_request_meta->provider_id);
                    $provider_detail->waiting_to_respond = WAITING_TO_RESPOND;
                    $provider_detail->save();

                    //Assign the next provider.
                    $next_request_meta->status = REQUEST_META_OFFERED;
                    $next_request_meta->save();

                    //Update the request start time in request table
                    Requests::where('id', '=', $request->id)->update( array('request_start_time' => date("Y-m-d H:i:s")) );
                    Log::info('assign_next_provider_cron assigned provider to request_id:'.$request->id.' at '.$time);

                    // Push Start
                    
                    $service = ServiceType::find($request->request_type);
                    $user = User::find($request->user_id);
                    $request_data = Requests::find($request->id);

                    // Push notification has to add
                    $push_data = array();
                    $title = "New Service";
                    $push_msg = "You got a new service from ".$user->first_name.''.$user->last_name;
                    $message = array(
                        'success' => true,
                        'msg' => $push_msg,
                        'data' => array((object) $push_data)
                    );
                    // Send Push Notification to Provider 
                    $this->dispatch(new sendPushNotification($next_request_meta->provider_id,PROVIDER,$request->id,$title,$message));

                    Log::info(print_r($messages,true));

                }else{
                    //End the request
                    //Update the request status to no provider available
                    Requests::where('id', '=', $request->id)->update( array('status' => REQUEST_NO_PROVIDER_AVAILABLE) );

                    // No longer need request specific rows from RequestMeta
                    RequestsMeta::where('request_id', '=', $request->id)->delete();
                    Log::info('assign_next_provider_cron ended the request_id:'.$request->id.' at '.$time);

                    // Send Push Notification to User
                    $title = "No Provider Available";
                    $message = "No provider available to take the service.";

                    $this->dispatch(new NormalPushNotification($request->user_id,USER,$title,$message));
                }

            } else {
                Log::info("Provider Waiting State");
            }
        }
    }

    public function message_save(Request $request)
    {
        $this->validate($request, [
                "user_id" => "required|integer",
                "provider_id" => "required|integer",
                "type" => "required|in:up,pu",
                "message" => "required",
            ]);
        return ChatMessage::create($request);
    }
}
