<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\User;

use App\Provider;

use App\Document;

use App\Admin;

use App\ServiceType;

use App\RequestPayment;

use App\Settings;

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
        $this->middleware('admin');
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

    public function profile()
    {
        $admin = Admin::first();
        return view('admin.adminProfile')->with('admin',$admin);
    }

    public function profileProcess(Request $request)
    {
                $name = $request->name;
                $paypal_email = $request->paypal_email;
                $email = $request->email;
                $mobile = $request->mobile;
                $gender = $request->gender;
                $picture = $request->file('picture');
                $address = $request->address;

                $validator = Validator::make(
                    $request->all(),
                    array(
                        'name' => 'required|max:255',
                        'paypal_email' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                       
                    )
                );
            if($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_errors', $error_messages);
        }
        else
        {
                    $admin = Admin::find($request->id);
                    $admin->name = $name;
                    $admin->email = $email;
                    $admin->mobile = $mobile;
                    if($admin->picture == ''){
                    $admin->picture = Helper::upload_picture($picture);
                    }
                    $admin->remember_token = Helper::generate_token();
                    $admin->gender = $gender;
                    $admin->is_activated = 1;
                    $admin->paypal_email = $request->paypal_email;
                    $admin->address = $address;
                    $admin->save();

                if($admin)
                {
                    return back()->with('flash_success', 'Admin Details updated Successfully');
                }
                else
                {
                    return back()->with('flash_error', 'Something Went Wrong, Try Again!');
                }
        }
    }

    public function payment()
    {
        $payment = RequestPayment::all();
        return view('admin.adminPayment')->with('payments',$payment);
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
        $providers = Provider::orderBy('created_at' , 'asc')->paginate(10);
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
        $providers = Provider::orderBy('created_at' , 'asc')->paginate(10);;
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
        $settings = Settings::all();
        // dd($settings);
        return view('admin.settings');
    }

    public function settingsProcess()
    {
        $settings = Settings::all();
        // dd($settings);
        return view('admin.settings');
    }

    //Documents

    public function documents()
    {
        $document = Document::orderBy('created_at' , 'asc')->paginate(10);
        return view('admin.documents')->with('documents',$document);
    }

    public function editDocument(Request $request)
    {
        $document = Document::find($request->id);
        return view('admin.addDocuments')->with('name', 'Edit Document')->with('document',$document);
    }

    public function addDocument()
    {
        return view('admin.addDocuments');
    }

    public function addDocumentProcess(Request $request)
    {

                $validator = Validator::make(
                    $request->all(),
                    array(
                        'document_name' => 'required|max:255',
                                         
                    )
                );
            if($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_errors', $error_messages);
        }
        else
        {
            if($request->id != '')
            {
                $document = Document::find($request->id);
                $message = "Document Updated successfully";
            }
            else
            {
                $document = new Document;
                $message = "Document Created successfully";
            }
                $document->name = $request->document_name;
                $document->save();
            
        if($document)
        {
            return back()->with('flash_success',$message);
        }
        else
        {
            return back()->with('flash_error',"Something went Wrong");
        }
        }
    }

    public function deleteDocument(Request $request)
    {

            $document = Document::find($request->id)->delete();
       
        if($document)
        {
            return back()->with('flash_success',"Document deleted successfully");
        }
        else
        {
            return back()->with('flash_error',"Something went Wrong");
        }
    }

    //Service Types

    public function serviceTypes()
    {
        $service = ServiceType::orderBy('created_at' , 'asc')->paginate(10);
        return view('admin.serviceTypes')->with('services',$service);
    }

    public function editService(Request $request)
    {
        $service = ServiceType::find($request->id);
        return view('admin.addServiceTypes')->with('name', 'Edit Service Types')->with('service',$service);
    }

    public function addServiceType()
    {
        return view('admin.addServiceTypes');
    }

    public function addServiceProcess(Request $request)
    {

                $validator = Validator::make(
                    $request->all(),
                    array(
                        'service_name' => 'required|max:255',
                                         
                    )
                );
            if($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_errors', $error_messages);
        }
        else
        {
            if($request->id != '')
            {
                $service = ServiceType::find($request->id);
                $message = "Service Type Updated successfully";
            }
            else
            {
                $service = new ServiceType;
                $message = "Service Type Created successfully";

            }
                if ($request->is_default == 1) {
                ServiceType::where('status', 1)->update(array('status' => 0));
                $service->status = 1;
            }
            else
            {
                $service->status = 0;
            }
                $service->name = $request->service_name;
                $service->save();
            
        if($service)
        {
            return back()->with('flash_success',$message);
        }
        else
        {
            return back()->with('flash_error',"Something went Wrong");
        }
        }
    }

    public function deleteService(Request $request)
    {

            $service = ServiceType::find($request->id)->delete();
       
        if($service)
        {
            return back()->with('flash_success',"Service deleted successfully");
        }
        else
        {
            return back()->with('flash_error',"Something went Wrong");
        }
    }

    public function providerReviews()
    {
            $provider_reviews = DB::table('provider_ratings')
                ->leftJoin('providers', 'provider_ratings.provider_id', '=', 'providers.id')
                ->leftJoin('users', 'provider_ratings.user_id', '=', 'users.id')
                ->select('provider_ratings.id as review_id', 'provider_ratings.rating', 'provider_ratings.comment', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'provider_ratings.created_at')
                ->orderBy('provider_ratings.id', 'DESC')
                ->paginate(10);

            
            return view('admin.reviews')->with('name', 'Provider')
                        ->with('reviews', $provider_reviews);
    }

    public function userReviews()
    {
            
            $user_reviews = DB::table('user_ratings')
                ->leftJoin('providers', 'user_ratings.provider_id', '=', 'providers.id')
                ->leftJoin('users', 'user_ratings.user_id', '=', 'users.id')
                ->select('user_ratings.id as review_id', 'user_ratings.rating', 'user_ratings.comment', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'user_ratings.created_at')
                ->orderBy('user_ratings.id', 'DESC')
                ->paginate(10);
            return view('admin.reviews')->with('name', 'User')->with('reviews', $user_reviews);
    }

    public function deleteUserReview(Request $request) {
        $user = UserRating::find('id', $request->id)->delete();
        return back()->with('flash_success', 'User Review Deleted Successfully');
    }

    public function deleteProviderReview(Request $request) {
        $provider = ProviderRating::find('id', $request->id)->delete();
        return back()->with('flash_success', 'Provider Review Deleted Successfully');
    }

    public function requests()
    {
        $requests = DB::table('requests')
                ->leftJoin('providers', 'request.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'request.user_id', '=', 'users.id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'request.is_paid',  'request.id as id', 'request.created_at as date', 'request.confirmed_provider', 'request.status', 'request.provider_status', 'request.amount')
                ->orderBy('request.created_at', 'DESC')
                ->paginate(10);
        return view('admin.requests')->with('requests', $requests);
    }

}
