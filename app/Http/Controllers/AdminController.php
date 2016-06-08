<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use App\User;

use App\Provider;

use App\Document;

use App\ProviderDocument;

use App\ProviderRating;

use App\Admin;

use App\ServiceType;

use App\Requests;

use App\RequestPayment;

use App\Settings;

use Validator;

use Hash;

use Mail;

use DB;

use Auth;

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
        $user = Auth::guard('admin')->user()->name;
        $reg_users = User::count();
        $comp_req = Requests::where('status','5')->count();
        $tot_req = Requests::count();
        $can_req = Requests::where('status','6')->count();
        $tot_pay = RequestPayment::sum('total');
        $paypal = RequestPayment::where('payment_mode','paypal')->sum('total');
        $card_pay = RequestPayment::where('payment_mode','card')->sum('total');
        $cod = RequestPayment::where('payment_mode','cod')->sum('total');
        $top = DB::table('provider_ratings')
                    ->leftJoin('providers', 'provider_ratings.provider_id', '=', 'providers.id')
                    ->select('providers.*')
                    ->groupBy('provider_ratings.provider_id')
                    ->orderBy('provider_id','desc')
                    ->limit(1)->first();
        $tot_rev = Requests::where('confirmed_provider',$top->id)->sum('amount');
        $pro_req = Requests::where('confirmed_provider',$top->id)->count();
        $avg_rev = ProviderRating::where('provider_id',$top->id)->avg('rating');
        $provider_reviews = DB::table('provider_ratings')
                ->leftJoin('providers', 'provider_ratings.provider_id', '=', 'providers.id')
                ->leftJoin('users', 'provider_ratings.user_id', '=', 'users.id')
                ->select('provider_ratings.id as review_id', 'provider_ratings.rating', 'provider_ratings.comment', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'users.picture as user_picture', 'providers.id as provider_id', 'provider_ratings.created_at')
                ->orderBy('provider_ratings.id', 'DESC')
                ->limit(3)
                ->get();
        
        return view('admin.dashboard')
                ->with('reg_users', $reg_users)
                ->with('comp_req', $comp_req)
                ->with('tot_req', $tot_req)
                ->with('tot_pay',$tot_pay)
                ->with('paypal',$paypal)
                ->with('card_pay',$card_pay)
                ->with('cod',$cod)
                ->with('top',$top)
                ->with('tot_rev',$tot_rev)
                ->with('pro_req',$pro_req)
                ->with('avg_rev',$avg_rev)
                ->with('reviews', $provider_reviews)
                ->with('can_req', $can_req);
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
        $user = User::orderBy('created_at' , 'desc')->get();
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
                        'picture' => 'required|mimes:jpeg,jpg,bmp,png',
                       
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
        $subQuery = DB::table('requests')
                ->select(DB::raw('count(*)'))
                ->whereRaw('confirmed_provider = providers.id and status != 0');
        $subQuery1 = DB::table('requests')
                ->select(DB::raw('count(*)'))
                ->whereRaw('confirmed_provider = providers.id and status=1');
        $providers = DB::table('providers')
                ->select('providers.*', DB::raw("(" . $subQuery->toSql() . ") as 'total_requests'"), DB::raw("(" . $subQuery1->toSql() . ") as 'accepted_requests'"))
                ->orderBy('providers.created_at', 'DESC')
                ->get();

                // dd($providers);
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
                        'email' => 'required|email|max:255|unique:providers,email',
                        'mobile' => 'required|digits_between:6,13',
                        'address' => 'required|max:300',
                        'picture' => 'required|mimes:jpeg,jpg,bmp,png',
                       
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

    public function providerDocuments(Request $request) {
        $provider_id = $request->id;
        $provider = Provider::find($provider_id);
        $documents = Document::all();
        $provider_document = DB::table('provider_documents')
                            ->leftJoin('documents', 'provider_documents.document_id', '=', 'documents.id')
                            ->select('provider_documents.*', 'documents.name as document_name')
                            ->where('provider_id', $provider_id)->get();


        return view('admin.providerDocuments')
                        ->with('provider', $provider)
                        ->with('document', $documents)
                        ->with('documents', $provider_document);
    }

    public function ProviderApprove(Request $request)
    {
        $providers = Provider::orderBy('created_at' , 'asc')->get();
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
        return view('admin.settings')->with('setting',$settings);
    }

    public function settingsProcess(Request $request)
    {
        $settings = Settings::all();
        foreach ($settings as $setting) {
            $key = $setting->key;
           
                $temp_setting = Settings::find($setting->id);

                if($temp_setting->key == 'site_logo'){
                    $picture = $request->file('picture');
                    if($picture == null){
                    $logo = $temp_setting->value;
                    }
                    else
                    {
                        $logo = Helper::upload_picture($picture);
                    }
                    $temp_setting->value = $logo;
                    $temp_setting->save();
                }
                else
                {
                $temp_setting->value = $request->$key;
                $temp_setting->save();
            }

              
            }
        
        return back()->with('setting', $settings);
    }

    //Documents

    public function documents()
    {
        $document = Document::orderBy('created_at' , 'asc')->get();
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
        $service = ServiceType::orderBy('created_at' , 'asc')->get();
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
                ->get();

            
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
                ->get();
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

    public function UserHistory(Request $request)
    {
        $requests = DB::table('requests')
                ->Where('user_id',$request->id)
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'requests.amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status')
                ->orderBy('requests.created_at', 'DESC')
                ->get();
        return view('admin.request')->with('requests', $requests);
    }

    public function ProviderHistory(Request $request)
    {
        $requests = DB::table('requests')
                ->Where('confirmed_provider',$request->id)
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'requests.amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status')
                ->orderBy('requests.created_at', 'DESC')
                ->get();
        return view('admin.request')->with('requests', $requests);
    }

    public function requests()
    {
        $requests = DB::table('requests')
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'requests.amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status')
                ->orderBy('requests.created_at', 'DESC')
                ->get();
        return view('admin.request')->with('requests', $requests);
    }

    public function ViewRequest(Request $request)
    {
        $requests = DB::table('requests')
                ->where('requests.id',$request->id)
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'requests.amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status', 'request_payments.total_time as total_time','request_payments.base_price as base_price', 'request_payments.time_price as time_price', 'request_payments.tax_price as tax', 'request_payments.total as total_amount', 'requests.s_latitude as latitude', 'requests.s_longitude as longitude','requests.start_time','requests.end_time')
                ->first();    
        return view('admin.requestView')->with('request', $requests);
    }

    public function mapview()
    {
        // dd(\Auth::guard('admin')->user());
        $Providers = Provider::all();
        return view('admin.map', compact('Providers'));
    }
}
