<?php

namespace App\Listeners;

use App\Helpers\Helper;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        \Auth::user()->token = Helper::generate_token();
        \Auth::user()->token_expiry = Helper::generate_token_expiry();
        \Auth::user()->device_token = \Auth::user()->device_token ? \Auth::user()->device_token : 'weblogin';
        \Auth::user()->save();
    }
}
