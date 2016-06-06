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
        // Get the request details
        if($requests = Requests::find($this->request_id)) {

            if($this->user_type == 0) {
                $user = User::find($requests->user_id);
            } else {
                $user = Provider::find($requests->confirmed_provider);
            }

            // Get the provider timeout from the admin settings
            $settings = Settings::where('key', 'provider_select_timeout')->first();
            $provider_timeout = $settings->value;

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
            $push_data['user_rating'] = ProviderRating::where('provider_id', 1)->avg('rating') ?: 0;
            $push_data['time_left_to_respond'] = $provider_timeout - (time() - strtotime($requests->request_start_time));

            $push_message = array('success' => true,'message' => $this->message,'data' => array((object) $push_data));

            Helper::send_notifications($user->id, $this->user_type, $this->title, $push_message);
        }
    }
}
