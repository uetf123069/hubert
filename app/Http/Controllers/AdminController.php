<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\User;

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
        $validator = Validator::make(
                    $request->all(),
                    array(
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                        'zip' => 'required|max:6',
                       
                    )
                );
        if($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_errors', $error_messages);
        }
        else
        {
                $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
                $mobile = $request->mobile;
                $gender = $request->gender;
                $picture = $request->file('picture');
                $zip_code = $request->zip_code;
                $address = $request->address;

                //Add New User

                $user = new User;
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
                $user->picture = Helper::upload_picture($picture);
                $new_password = time();
                $new_password .= rand();
                $new_password = sha1($new_password);
                $new_password = substr($new_password, 0, 8);
                $user->password = Hash::make($new_password);
                
                $email_data['name'] = $user->first_name;
                $email_data['password'] = $new_password;
                $email_data['email'] = $user->email;

                // $check_mail = Helper::send_users_welcome_email($email_data);

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
        return view('admin.providers');
    }

    public function addProvider()
    {
        return view('admin.addProvider');
    }


    public function settings()
    {
        return view('admin.addProvider');
    }
}
