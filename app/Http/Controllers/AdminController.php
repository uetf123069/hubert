<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\User;

use App\Provider;

use Validator;

use Hash;

use Mail;

use DB;

use Redirect;

use Setting;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }


    //User Functions

    public function users()
    {
        $user = User::orderBy('created_at' , 'desc')->paginate(10);
        return view('admin.users')->with('users',$user);
    }

    public function addUser()
    {

        return view('admin.addUser');
    }

    public function addUserProcess(Request $request)
    {
        $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
                $mobile = $request->mobile;
                $gender = $request->gender;
                $picture = $request->file('picture');
                $address = $request->address;

            if($request->id != '')
            {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                       
                    )
                );
            }
            else
            {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                       
                    )
                );
            }
       
        if($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_errors', $error_messages);
        }
        else
        {
                
                if($request->id != '')
                {
                    // Edit User
                    $user = User::find($request->id);
                    if($user->picture == ''){
                    $user->picture = Helper::upload_picture($picture);
                    }
                }
                else
                {
                    //Add New User
                    $user = new User;
                    $new_password = time();
                    $new_password .= rand();
                    $new_password = sha1($new_password);
                    $new_password = substr($new_password, 0, 8);
                    $user->password = Hash::make($new_password);
                    $user->picture = Helper::upload_picture($picture);
                }
                    $user->first_name = $first_name;
                    $user->last_name = $last_name;
                    $user->email = $email;
                    $user->mobile = $mobile;
                    $user->token = Helper::generate_token();
                    $user->token_expiry = Helper::generate_token_expiry();
                    $user->gender = $gender;
                    $user->is_activated = 1;
                    $user->is_approved = 1;
                    $user->payment_mode = 1;
                    $user->address = $address;
                   
                    
                    if($request->id == ''){
                    $email_data['name'] = $user->first_name;
                    $email_data['password'] = $new_password;
                    $email_data['email'] = $user->email;

                    // $check_mail = Helper::send_users_welcome_email($email_data);
                    }

                    $user->save();

                if($user)
                {
                    return back()->with('flash_success', 'User updated Successfully');
                }
                else
                {
                    return back()->with('flash_error', 'Something Went Wrong, Try Again!');
                }

            }
    }

    public function editUser(Request $request)
    {
        $user = User::find($request->id);
        return view('admin.addUser')->with('name', 'Edit User')->with('user',$user);
    }

    public function deleteUser(Request $request)
    {

        if($user = User::find($request->id)) 
        {

            $user = User::find($request->id)->delete();
        }

        if($user)
        {
            return back()->with('flash_success',"User deleted successfully");
        }
        else
        {
            return back()->with('flash_error',"Something went Wrong");
        }
    }


    //Provider Functions

    public function providers()
    {
        $providers = Provider::orderBy('created_at' , 'desc')->paginate(10);
        return view('admin.providers')->with('providers',$providers);
    }

    public function addProvider()
    {
        return view('admin.addProvider');
    }

    public function addProviderProcess(Request $request)
    {

                $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
                $mobile = $request->mobile;
                $gender = $request->gender;
                $picture = $request->file('picture');
                $address = $request->address;

            if($request->id != '')
            {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                       
                    )
                );
            }
            else
            {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                       
                    )
                );
            }
       
        if($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_errors', $error_messages);
        }
        else
        {
                
                if($request->id != '')
                {
                    // Edit Provider
                    $provider = Provider::find($request->id);
                    if($provider->picture == ''){
                    $provider->picture = Helper::upload_picture($picture);
                    }
                }
                else
                {
                    //Add New Provider
                    $provider = new Provider;
                    $new_password = time();
                    $new_password .= rand();
                    $new_password = sha1($new_password);
                    $new_password = substr($new_password, 0, 8);
                    $provider->password = Hash::make($new_password);
                    $provider->picture = Helper::upload_picture($picture);
                }
                    $provider->first_name = $first_name;
                    $provider->last_name = $last_name;
                    $provider->email = $email;
                    $provider->mobile = $mobile;
                    $provider->token = Helper::generate_token();
                    $provider->token_expiry = Helper::generate_token_expiry();
                    $provider->gender = $gender;
                    $provider->is_activated = 1;
                    $provider->is_approved = 1;
                    $provider->paypal_email = $request->paypal_email;
                    $provider->address = $address;
                    
                    
                    if($request->id == ''){
                    $email_data['name'] = $provider->first_name;
                    $email_data['password'] = $new_password;
                    $email_data['email'] = $provider->email;

                    // $check_mail = Helper::send_provider_welcome_email($email_data);
                    }

                    $provider->save();

                    if($provider)
                    {
                        return back()->with('flash_success', 'Provider updated Successfully');
                    }
                    else
                    {
                        return back()->with('flash_error', 'Something Went Wrong, Try Again!');
                    }

            }
    }

    public function editProvider(Request $request)
    {
        $provider = Provider::find($request->id);
        return view('admin.addProvider')->with('name', 'Edit Provider')->with('provider',$provider);
    }

    public function ProviderApprove(Request $request)
    {
        $providers = Provider::orderBy('created_at' , 'desc')->paginate(10);;
        $provider = Provider::find($request->id);
        $provider->is_approved = $request->status;
        $provider->save();
        if($request->status ==1)
        {
            $message = 'Provider Approved Successfully';
        }
        else
        {
            $message = 'Provider Unapproved Successfully';
        }
        return back()->with('flash_success', $message)->with('providers',$providers);
    }

    public function deleteProvider(Request $request)
    {

        if($provider = Provider::find($request->id)) 
        {

            $provider = Provider::find($request->id)->delete();
        }

        if($provider)
        {
            return back()->with('flash_success',"Provider deleted successfully");
        }
        else
        {
            return back()->with('flash_error',"Something went Wrong");
        }
    }

    public function settings()
    {
        return view('admin.addProvider');
    }
}
