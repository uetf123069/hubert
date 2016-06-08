<?php

namespace App\Http\Controllers\Auth;

use App\Provider;
use App\ProviderService;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ProviderAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration / logout.
     *
     * @var string
     */
    protected $redirectTo = 'provider';

    protected $redirectAfterLogout = '/provider/login';

    /**
     * The guard to be used for validation.
     *
     * @var string
     */

    protected $guard = 'provider';

    /**
     * The Login form view that should be used.
     *
     * @var string
     */

    protected $loginView = 'provider.auth.login';

    /**
     * The Register form view that should be used.
     *
     * @var string
     */

    protected $registerView = 'provider.auth.register';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guestprovider', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:providers',
            'password' => 'required|min:6|confirmed',
            'service_type' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $provider = Provider::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_available' => 1
        ]);

        ProviderService::create([
            'provider_id' => $provider['attributes']['id'],
            'is_available' => 1,
            'service_type_id' => $data['service_type']
            ]);

        Helper::send_user_welcome_email($provider);

        return $provider;
    }
}
