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

	public function list_message($id) 
    {

        $user = User::find($id);
        $select_user = User::find($id);

        $username = $user->id;

        $messages = Message::
            where('receiver_id', $username)
            ->orWhere('sender_id' , $username)
            ->orderBy('updated_at' , 'DESC')
            ->get();

        $alluser = [];

        $default = Message::where('receiver_id', $username)
            ->orWhere('sender_id' , $username)
            ->orderBy('updated_at' , 'DESC')
            ->first();

            $de = "";


        if($default) {

            if($default->sender_id == $user->id) {
                $sender = User::where('id' , $default->receiver_id)->first();
                $receiver = $user;
            } elseif($default->receiver_id == $user->id) 
            {
                $sender = User::where('id' , $default->sender_id)->first();
                $receiver = $user;
            }

            $default_messages = Message::
                where('receiver_id', $default->receiver_id)
                ->orwhere('receiver_id', $default->sender_id)
                ->Where('sender_id' , $default->sender_id)
                ->orWhere('sender_id' , $default->receiver_id)
                ->get();


            $de =  view('admin.userIndividualMessage')
                            ->with('sender' , $sender)
                            ->with('user' , $receiver)
                            ->with('messages' , $default_messages);
        } else {
            $de = "";
        }


        foreach($messages as $m => $message) 
        {

            if($message->sender_id == $username) {
                $alluser[] = $message->receiver_id;
            } else {
                $alluser[] = $message->sender_id;
            }

        }

        $users = array_unique($alluser);

        return view('admin.usermessage')
                ->with('page' , 'messages')
                ->with('title' , 'Messages')
                ->with('messages' , $messages)
                ->with('user' , $user)
                ->with('select_user' , $select_user)
                ->with('home_active' ,'')
                ->with('de' , $de)
                ->with('notification_active' , '')
                ->with('message_active' , 'radar-active')
                ->with('title' , 'Messages')
                ->with('page' , 'messages')
                ->with('users' , $users);
    }

    public function AdminIndividualMessage(Request $request) {

		$auth_user = $request->auth_user;

		$receiver = User::find($auth_user);

        $user = $request->user;

        $sender = User::where('id' , $user)->first();

        $messages = Message::where('receiver_id', $user)
            			->orWhere('sender_id' , $receiver->id)
            			->orwhere('receiver_id' , $receiver->id)
            			->orWhere('sender_id' ,$user)
            			->get();

        return view('admin.userIndividualMessage')
                        ->with('sender' , $sender)
                        ->with('user' , $receiver)
                        ->with('messages' , $messages);
	
	}
	
	public function questions(Request $requst) {

		$questions = AdminQuestion::where('type' , 'dropdown')->get();

		return view('admin.questions')
						->with('title',"Questions")
						->with('page',"questions")
						->with('questions' , $questions);
	}

	public function adminQuestionProcess(Request $request) {

		$question = new AdminQuestion;

		$question->question = $request->question;
		$question->type = $request->type;
		$code = rand(100, 999);
		$question->code = 'QN'.$code;
		$question->save();

		if($question) {

			if($request->type == "dropdown") {


				if($request->has('option')) {

					foreach ($request->option as $key => $options) {

						$option = new AdminOption;
						$o_code = rand(1000, 9999);
						$option->code = 'QN'.$o_code;
						$option->question_id = $question->id;
						$option->option = $options;
						$option->save();
					
					}

				}

			}
		}

		return Redirect::back()->with('flash_success' , "Successfully question added");
	
	}

	public function cityManagement() {

		if($cities = City::orderBy('created_at' , 'desc')->paginate(10))
		{
			return view('admin.cityManagement')
				->with('title',"City Management")
				->with('page',"cities")
				->with('cities',$cities);
		}
		else
		{
			return Redirect::back()->with('flash_error',"Something went wrong");
		}
	}

	public function addCity() {

		return view('admin.addCity')
					->with('title',"Cities")
					->with('page',"cities");
	}

	public function addCityProcess(Request $request) {

		$address = $request->city;

		$validator = Validator::make($request->all(),
			array( 
				'city' => 'required',

			));

		if($validator->fails())
		{
			$error = $validator->messages()->all();
			return back()->with('flash_errors',$error);
		}
		else
		{
			if(!$request->has('id')) {

				if($check_city = City::find($request->id)) {
					$city = $check_city;
				} else {
					$city = new City;
				}
				
			} else{
				$city = City::where('id' , $request->id)->first();
			}

			if($request->has('city')){ 
				$city->city = $address;
			}

			$city->save();

			if ($city) {
				return back()->with('flash_success', "City added successfully");
			} else {
				return back()->with('flash_error', "Something went wrong");
			}
		}
	
	}

	public function editCity(Request $request) {

		if($city_details = City::find($request->id)) {

			return view('admin.editCity')->with('title',"Cities")
					->with('page',"cities")->with('city',$city_details);

		} else {

			return back()->with('flash_error',"Something went Wrong");

		}
	
	}

	public function cityDelete(Request $request) {

		if($city = City::find($request->id)) 
        {

            $city_details = City::find($request->id)->delete();
        }

		if($city_details)
		{
			return back()->with('flash_success',"City deleted successfully");
		}
		else
		{
			return back()->with('flash_error',"Something went Wrong");
		}
	
	}

	public function addsubhub(Request $request) {

		if($city = City::find($request->id)) {

			$subhubs = Subhub::where('city_id' , $city->id)->paginate(10);

			return view('admin.addsubhub')
						->with('city',$city)
						->with('subhubs',$subhubs)
						->with('title',"addsubhub")
						->with('page',"cities");
		} else {

			return Redirect::back()->with('flash_error' , 'City Not Found');
		}

	}

	public function addsubhubprocess(Request $request) {

		$subhub = $request->subhub;
		$id = $request->id;

		$validator = Validator::make($request->all(),
			array( 
				'subhub' => 'required',

			));

		if($validator->fails())
		{
			$error = $validator->messages()->all();
			return back()->with('flash_errors',$error);
		}
		else
		{
			if($request->has('id')) {

				if($city = City::where('id' , $request->id)->first()) {

					$subhub_obj = new Subhub;
					$subhub_obj->city_id = $id;
					$subhub_obj->subhub = $subhub;
					$subhub_obj->save();

					if($subhub_obj) {

						return back()->with('flash_success', "Subhub Added Successfully")->with('city' , $city);

					} else {
						return back()->with('flash_error', "Something went wrong");
					}
				} else {
					return back()->with('flash_error', "Something went wrong");
				}

			} else {
				return back()->with('flash_error' , 'City ID not found');
			}

		}
	
	}

	public function editSubhub(Request $request) {

		if($subhub_details = Subhub::find($request->id)) {

			return view('admin.editsubhub')->with('title',"Subhub")
					->with('page',"cities")->with('city',$subhub_details);

		} else {

			return back()->with('flash_error',"Something went Wrong");

		}
	
	}

	public function subhubDelete(Request $request) {

		if($subhub = Subhub::find($request->id)) 
        {

            $subhub_details = Subhub::find($request->id)->delete();
        }

		if($subhub_details)
		{
			return back()->with('flash_success',"City deleted successfully");
		}
		else
		{
			return back()->with('flash_error',"Something went Wrong");
		}
	
	}

}
















