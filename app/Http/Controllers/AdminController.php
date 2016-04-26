<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Validator;

use Hash;

use Mail;

use App\Admin;

use DB;



class AdminController extends Controller
{
    public function adminDashboard()
    {
    	return view('admin.adminDashboard')->withPage('dashboard');
    }

    public function userManagement()
	{

		if($user = User::orderBy('created_at' , 'desc')->paginate(10))
		{
			return view('admin.userManagement')
				->with('title',"User Management")
				->with('page',"users")
				->with('users',$user);
		}
		else
		{
			return Redirect::back()->with('flash_error',"Something went wrong");
		}
	}

	public function adminAddUser()
	{
		return view('admin.addUser')->withPage('users');
	}

	public function adminUserEdit($id)
	{
		$user = User::find($id);

		if($user)
		{
			return view('admin.editUser')->withPage('users')->withUser($user);
		}
		else
		{
			return back()->with('flash_error',"Something went wrong");
		}
	}

	public function addUserProcess(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
        ]);
        $email = $request->email;

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)
                        ->withInput();
        }
		else 
		{
			if ($request->id != "") 
            {
            	$user = User::find($request->id);
				$user->email = $request->email;
				
            }
            else
            {
            	$user = User::where('email', $request->email)->first();
				if ($user) {
					$error = "User already exists";
					return back()->with('flash_error', $error);
				}
            	$user = new User;
				$user->email = $request->email;
				$user->name = $request->username;

				$new_password = time();
				$new_password .= rand();
				$new_password = sha1($new_password);
				$new_password = substr($new_password, 0, 8);
				$user->password = Hash::make($new_password);


				$subject = "Welcome On Board";
				$email_data['name'] = $user->name;
				$email_data['password'] = $new_password;
				$email_data['email'] = $user->email;
				
				try
				{
					// Mail::send('emails.newuser', array('email_data' => $email_data), function ($message) use ($email, $subject) {
					// $message->to($email)->subject($subject);
					// });
					// Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
     				//        			$m->from('hello@app.com', 'Your Application');


				}				
				catch(Exception $e)
				{
					return back()->with('flash_error', "Something went wrong in mail configuration");
				}
				
            }

			$user->save();

			if ($user) {
				return back()->with('flash_success', "User updated Successfully");
			} else {
				return back()->with('flash_error', "Something went wrong");
			}
		}
	}

	public function userActivate($id)
	{
		$user = User::find($id);
		$user->is_activated = 1;
		$user->save();
		if($user)
		{
			return back()->with('flash_success',"User Activated successfully");
		}
		else
		{
			return back()->with('flash_error',"Something went Wrong");
		}
	}

	public function userDecline($id)
	{
		$user = User::find($id);
		$user->is_activated = 0;
		$user->save();
		if($user)
		{
			return back()->with('flash_success',"User Declined successfully");
		}
		else
		{
			return back()->with('flash_error',"Something went Wrong");
		}
	}

	public function userDelete($id)
	{

        if($user_details = User::find($id)) 
        {

            $user = User::find($id)->delete();
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

    public function filterUsers(Request $request,$flag)
    {
        if($request->has('keyword'))
        {
            $q = $request->keyword;

            $feeds = User::orderBy('created_at','desc')
            			->distinct()
            			->orWhere('name','like', '%'.$q.'%')
            			->orWhere('email','like', '%'.$q.'%');

            $slide = 'recentuser';

            if(!$feeds)
            {
                return back()->with('flash_error',"Result not found");
            }
        }
        else
        {
            if($flag == 1) // flag = 1 for recent, flag =2 for trending, flag = 4 for untrending, flag=4 for activated, flag = 5 for unactivated
            {
                $feeds = User::orderBy('name','asc');
                $slide = 'recentuser';
            }
            elseif($flag == 2)
            {
                $feeds = User::orderBy('created_at','desc');
                $slide = 'recentuser';
            }
            elseif($flag == 3)
            {
                $feeds = User::orderBy('created_at','desc');
                $slide = 'untrendin';
            }
            elseif($flag == 4)
            {
                $feeds = User::where('is_activated' , 1)->orderBy('name','desc');
                $slide = 'activated';
            }
            elseif($flag == 5)
            {
                $feeds = User::where('is_activated' , 0)->orderBy('created_at','desc');
                $slide = 'unactivated';
            }
            elseif($flag == 6)
            {
                $category_id = $request->topics;

                if($request->topics && !$request->feed_date)
                {
                    Session::put('topi',$request->topics);
                    $feeds = User::where('status',$request->topics)->orderBy('created_at','desc');
                    $slide = 'category-id';
                }
                else
                {
                    if(Session::has('topi'))
                    {
                        $top = Session::get('topi');
                        $feeds = User::where('status',Input::get('topics'))->orderBy('created_at','desc');
                        $slide = 'category-id';
                    }
                    else
                    {
                        $feeds = User::orderBy('created_at','desc');
                        $slide = 'category-id';
                    }
                }

                if(Input::has('feed_date') && !Input::has('topics')) {

                    $s_date = date('Y-m-d H:i:s', strtotime(Input::get('feed_date')));
                    $e_date = date('Y-m-d H:i:s',strtotime(Input::get('feed_date')." "."23:59:59"));
                    
                    Session::put('topi',Input::get('feed_date'));

                    $feeds = User::where('requests.created_at', '>=', $s_date )
                                    ->where('requests.created_at', '<=', $e_date )->where('requests.status','!=', 0);

                    //Log::info($feeds);
                    $slide = 'feed-date';
                }

                if(Input::has('feed_date') && Input::has('topics')) {

                    $s_date = date('Y-m-d H:i:s', strtotime(Input::get('feed_date')));
                    $e_date = date('Y-m-d H:i:s',strtotime(Input::get('feed_date')." "."23:59:59"));
                    
                    Session::put('topi',Input::get('feed_date'));

                    $feeds = User::where('created_at', '>=', $s_date )
                                    ->where('requests.created_at', '<=', $e_date )
                                    ->where('status' , Input::get('topics'));

                    Log::info($feeds);

                    $slide = 'feed-date and Topic';
                }
            }
            else
            {
                return back()->with('flash_error',"Something went wrong");
            }
        }
        if($feeds)
        {
        	$users = $feeds->paginate(10);

            return view('admin.userManagement')
                ->with('title',"Request Management")
                ->with('page',"users")
                ->with('users',$users);
        }
        else
        {
            return Redirect::back()->with('flash_error',"Something went wrong");
        }
    }

    public function setting()
	{
		return view('admin.setting')
			->with('title',"Flagged Posts")
			->with('page', "admin_setting");
	}

	public function settingProcess(Request $request)
	{

		$validator = Validator::make(array(
			'sitename' => $request->sitename),
			array('sitename' => 'required'));
		if($validator->fails())
		{
			$errors = $validator->messages()->all();
			return Redirect::back()->with('flash_errors',$errors);
		}
		else
		{
			$validator1 = Validator::make(
				array(
					'picture' => $request->file('picture')
				),
				array(
					'picture' => 'required|mimes:png')
				);
			if($validator1->fails())
			{
				// do nothing
			}
			else
			{
				$file_name = time();
				$file_name .= rand();
				$ext = $request->file('picture')->getClientOriginalExtension();
				$request->file('picture')->move(public_path() . "/uploads", $file_name . "." . $ext);
				$local_url = $file_name . "." . $ext;
				$s3_url = url('/uploads/' . $local_url);
				Setting::set('logo', $s3_url);
			}
			Setting::set('sitename', $request->sitename);
			Setting::set('footer', $request->footer);
			Setting::set('google_play', $request->google_play);
			Setting::set('ios_app', $request->ios_app);
			Setting::set('website_link', $request->website_link);
			Setting::set('timezone', $request->timezone);
			Setting::set('browser_key', $request->browser_key);
			Setting::set('radius', $request->radius);
			Setting::set('like_limit_count', $request->like_limit_count);
			Setting::set('superlike_limit_count', $request->superlike_limit_count);
			Setting::set('search_radius', $request->search_radius);

			return Redirect::back()->with('flash_success', "successfully");
		}
	}

	public function mailConfig(Request $request)
	{
		if($request->mail_type == "mandrill")
		{
			Setting::set('mail_type',"mandrill");
			Setting::set('smtp_host',"smtp.mandrillapp.com");
			Setting::set('mail_username',$request->username);
			Setting::set('secret',$request->password);
		}
		elseif($request->mail_type == "normal_smtp")
		{
			Setting::set('mail_type',"smtp");
			Setting::set('smtp_host',"smtp.gmail.com");
			Setting::set('mail_username',$request->username);
			Setting::set('secret',$request->password);
		}

		return Redirect::back()->with('flash_success',"Successfull");
	}

	public function adminProfile()
	{
		$admin = Admin::find(1);
		return view('admin.profile')
			->with('title',"Flagged Posts")
			->with('page', "account")
			->with('admin',$admin);
	}

	public function adminProfileProcess(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

		if($validator->fails())
		{
			$error = $validator->messages()->all();
			return back()->with('flash_errors',$error);
		}
		else
		{
			$name = $request->name;
			$email = $request->email;
			$admin = Admin::find(1);
			$admin->name = $name;
			$admin->email = $email;
			$admin->save();

			if ($admin)
			{
				return back()->with('flash_success', "Admin updated successfully");
			}
			else
			{
				return back()->with('flash_error', "Something went wrong");
			}
		}
	}

	public function adminPassword(Request $request)
	{
		$validator = Validator::make($request->all(),
			array('password' => 'required',
				'con_password' => 'required'));
		if($validator->fails())
		{
			$error = $validator->messages()->all();
			return back()->with('flash_errors',$error);
		}
		else
		{
			$password = $request->password;
			$con_password = $request->con_password;
			$admin = Admin::find(1);
			$admin->password = Hash::make($con_password);
			$admin->save();

			if ($admin) {
				return back()->with('flash_success', "Admin updated successfully");
			} else {
				return back()->with('flash_error', "Something went wrong");
			}
		}
	}

	public function profilePics(Request $request)
	{
		$validator = Validator::make($request->all(),
			array('profile_pic' => 'required|mimes:jpeg,bmp,gif,png'));
		if($validator->fails())
		{
			$error = $validator->messages()->all();
			return back()->with('flash_errors',$error);
		}
		else
		{
			$admin = Admin::find(1);
			$file_name = time();
			$file_name .= rand();
			$ext = $request->file('profile_pic')->getClientOriginalExtension();
			$request->file('profile_pic')->move(public_path() . "/uploads", $file_name . "." . $ext);
			$local_url = $file_name . "." . $ext;
			$s3_url = url('/') . '/uploads/' . $local_url;
			$admin->profile_pic = $s3_url;
			$admin->save();

			if ($admin) {
				return back()->with('flash_success', "Admin updated successfully");
			} else {
				return back()->with('flash_error', "Something went wrong");
			}
		}
	}

	public function paymentDetails() {

		$payments = Payment::orderBy('payments.created_at' , 'desc')
							->leftJoin('users' , 'payments.user_id' ,'=' , 'users.id')
							->select('users.name as name' , 'users.id as user_id' ,'payments.id as payment_id' ,
								'payments.paypal_email' , 'payments.paypal_id' , 'payments.paid_amount' , 'payments.paid_status',
								'payments.created_at as time')
							->get();

		return view('admin.payments')
			->with('title',"payments")
			->with('payments',$payments)
			->with('page', "payments");
	}


}
















