<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ApplicationController extends Controller
{
     public function assign_next_provider_cron(){
        $settings = Setting::where('key', 'provider_select_timeout')->first();
        $provider_timeout = $settings->value;
        $time = date("Y-m-d H:i:s");
        //Log::info('assign_next_provider_cron ran at: '.$time);

        //Get all the new waiting requests which are not confirmed and not cancelled.
        $query = "SELECT id, user_id,request_type, TIMESTAMPDIFF(SECOND,request_start_time, '$time') AS time_since_request_assigned
                  FROM request
                  WHERE status = ".REQUEST_WAITING;
        $requests = DB::select(DB::raw($query));

        foreach ($requests as $request) {

            if ($request->time_since_request_assigned >= $provider_timeout) {
                // TimeOut the current assigned provider
                RequestMeta::where('request_id', $request->id)->where('status', REQUEST_META_OFFERED)->update(array('status' => REQUEST_META_TIMEDOUT));

                //Select the new provider who is in the next position.
                $next_request_meta = RequestMeta::where('request_id', '=', $request->id)->where('status', REQUEST_META_NONE)
                                    ->leftJoin('provider', 'provider.id', '=', 'request_meta.provider_id')
                                    ->where('provider.is_active',DEFAULT_TRUE)
                                    ->where('provider.available',DEFAULT_TRUE)
                                    ->select('request_meta.id','request_meta.status','request_meta.provider_id')
                                    ->orderBy('request_meta.created_at')->first();

                //Check the next provider exist or not.
                if($next_request_meta){
                    //Assign the next provider.
                    $next_request_meta->status = REQUEST_META_OFFERED;
                    $next_request_meta->save();
                    //Update the request start time in request table
                    Requests::where('id', '=', $request->id)->update( array('request_start_time' => date("Y-m-d H:i:s")) );
                    Log::info('assign_next_provider_cron assigned provider to request_id:'.$request->id.' at '.$time);

                    /*Push Start*/
                    $settings = Setting::where('key', 'provider_select_timeout')->first();
                    $provider_timeout = $settings->value;
                    $service = ServiceType::find($request->request_type);
                    $user = Provider::find($request->user_id);
                    $request_data = Requests::find($request->id);


                    // Push notification has to add
                    
                    $title = "New Service";
                    $push_msg = "You got a new service from ".$user->first_name.''.$user->last_name;
                    $push_message = array(
                        'success' => true,
                        'msg' => $push_msg,
                        'data' => array((object) $push_data)
                    );
                    /* Send Push Notification to Provider */
                    send_push_notification($next_request_meta->provider_id, PROVIDER, $title, $push_message);
                    Log::info(print_r($push_message,true));
                }else{
                    //End the request
                    //Update the request status to no provider available
                    Requests::where('id', '=', $request->id)->update( array('status' => REQUEST_NO_PROVIDER_AVAILABLE) );

                    // No longer need request specific rows from RequestMeta
                    RequestMeta::where('request_id', '=', $request->id)->delete();
                    Log::info('assign_next_provider_cron ended the request_id:'.$request->id.' at '.$time);

                    //Notify the admin
                    send_no_provider_found_notification_to_admin($request->id);

                    /*Send Push Notification to User*/
                    send_push_notification($request->user_id, USER, 'No Provider Available', 'No provider available to take the service.');

                }
            }
        }
    }

}
