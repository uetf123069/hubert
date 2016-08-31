<?php

namespace App\Listeners;

use App\Helpers\Helper;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

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
        $class_name = get_class($event->user);
        switch ($class_name) {
            case 'App\Admin':
                $guard = 'admin';
                break;

            case 'App\Provider':
                $guard = 'provider';
                break;
            
            default:
                $guard = 'web'; 
                break;
        }

        if($guard == 'web' || $guard == 'provider'){
            \Auth::guard($guard)->user()->token = Helper::generate_token();
            \Auth::guard($guard)->user()->token_expiry = Helper::generate_token_expiry();
            \Auth::guard($guard)->user()->device_token = \Auth::guard($guard)->user()->device_token ? \Auth::guard($guard)->user()->device_token : 'weblogin';
            \Auth::guard($guard)->user()->save();
        }
    }
}
