<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use App\User;

use App\Provider;

use App\Document;

use App\ProviderDocument;

use App\ProviderRating;

use App\ChatMessage;

use App\Admin;

use App\ServiceType;

use App\Requests;

use App\UserRating;

use App\RequestPayment;

use App\ProviderService;

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
        if($top != null){
        $tot_rev = Requests::where('confirmed_provider',$top->id)->sum('amount');
        $pro_req = Requests::where('confirmed_provider',$top->id)->count();
        $avg_rev = ProviderRating::where('provider_id',$top->id)->avg('rating');
        }
        else
        {
        $tot_rev = 0;
        $pro_req = 0;
        $avg_rev = 0;
        }
        $provider_reviews = DB::table('user_ratings')
                ->leftJoin('providers', 'user_ratings.provider_id', '=', 'providers.id')
                ->leftJoin('users', 'user_ratings.user_id', '=', 'users.id')
                ->select('user_ratings.id as review_id', 'user_ratings.rating', 'user_ratings.comment', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'users.picture as user_picture', 'providers.id as provider_id', 'user_ratings.created_at')
                ->orderBy('user_ratings.created_at', 'desc')
                
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
                    if($picture != ''){
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
                    return back()->with('flash_success', tr('admin_not_profile'));
                }
                else
                {
                    return back()->with('flash_error', tr('admin_not_error'));
                }
        }
    }

    public function payment()
    {
        $payment = DB::table('request_payments')
                    ->leftJoin('requests','requests.id','=','request_payments.request_id')
                    ->leftJoin('users','users.id','=','requests.user_id')
                    ->leftJoin('providers','providers.id','=','requests.confirmed_provider')
                    ->select('request_payments.*','users.first_name as user_first_name','users.last_name as user_last_name','providers.first_name as provider_first_name','providers.last_name as provider_last_name')
                    ->orderBy('created_at','desc')
                    ->get();
                    
        return view('admin.adminPayment')->with('payments',$payment);
    }

    public function paymentSettings()
    {
        $settings = Settings::all();
        return view('admin.paymentSettings')->with('setting',$settings);
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
                    $email_data['first_name'] = $user->first_name;
                    $email_data['last_name'] = $user->last_name;
                    $email_data['password'] = $new_password;
                    $email_data['email'] = $user->email;

                    $subject = Helper::tr('user_welcome_title');
                    $page = "emails.admin.welcome";
                    $email = $user->email;
                    Helper::send_email($page,$subject,$email,$email_data);
                    }

                    $user->save();

                if($user)
                {
                    return back()->with('flash_success', tr('admin_not_user'));
                }
                else
                {
                    return back()->with('flash_error', tr('admin_not_error'));
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
            return back()->with('flash_success',tr('admin_not_user_del'));
        }
        else
        {
            return back()->with('flash_error',tr('admin_not_error'));
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
                ->whereRaw('confirmed_provider = providers.id and status in (1,2,3,4,5)');
        $providers = DB::table('providers')
                ->select('providers.*', DB::raw("(" . $subQuery->toSql() . ") as 'total_requests'"), DB::raw("(" . $subQuery1->toSql() . ") as 'accepted_requests'"))
                ->orderBy('providers.id', 'DESC')
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
                    
                
                $subject = Helper::tr('provider_welcome_title');
                $page = "emails.admin.welcome";
                $email_data['first_name'] = $provider->first_name;
                    $email_data['last_name'] = $provider->last_name;
                    $email_data['password'] = $new_password;
                    $email_data['email'] = $provider->email;
                $email = $provider->email;
                Helper::send_email($page,$subject,$email,$email_data);
                    }

                   $provider->save();

                    if($provider)
                    {
                        return back()->with('flash_success', tr('admin_not_provider'));
                    }
                    else
                    {
                        return back()->with('flash_error', tr('admin_not_error'));
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
            $message = tr('admin_not_provider_approve');
        }
        else
        {
            $message = tr('admin_not_provider_decline');
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
            return back()->with('flash_success',tr('admin_not_provider_del'));
        }
        else
        {
            return back()->with('flash_error',tr('admin_not_error'));
        }
    }

    public function settings()
    {
        $settings = Settings::all();
        switch (Setting::get('currency')) {
            case '$':
                $symbol = '$';
                $currency = 'US Dollar (USD)';
                break;
            
            case '₹':
                $symbol = '₹';
                $currency = 'Indian Rupee (INR)';
                break;
            case 'د.ك':
                $symbol = 'د.ك';
                $currency = 'Kuwaiti Dinar (KWD)';
                break;
            case 'د.ب':
                $symbol = 'د.ب';
                $currency = 'Bahraini Dinar (BHD)';
                break;
            case '﷼':
                $symbol = '﷼';
                $currency = 'Omani Rial (OMR)';
                break;
            case '£':
                $symbol = '£';
                $currency = 'Euro (EUR)';
                break;
            case '€':
                $symbol = '€';
                $currency = 'British Pound (GBP)';
                break;
            case 'ل.د':
                $symbol = 'ل.د';
                $currency = 'Libyan Dinar (LYD)';
                break;
            case 'B$':
                $symbol = 'B$';
                $currency = 'Bruneian Dollar (BND)';
                break;
            case 'S$':
                $symbol = 'S$';
                $currency = 'Singapore Dollar (SGD)';
                break;
            case 'AU$':
                $symbol = 'AU$';
                $currency = 'Australian Dollar (AUD)';
                break;
            case 'CHF':
                $symbol = 'CHF';
                $currency = 'Swiss Franc (CHF)';
                break;
        }
        return view('admin.settings')->with('symbol',$symbol)->with('currency',$currency);
    }


    public function settingsProcess(Request $request)
    {
        $settings = Settings::all();
        foreach ($settings as $setting) {
            $key = $setting->key;
           
                $temp_setting = Settings::find($setting->id);

                if($temp_setting->key == 'site_icon'){
                    $site_icon = $request->file('site_icon');
                    if($site_icon == null)
                    {
                       
                        $icon = $temp_setting->value;
                    }
                    else
                    {

                        $icon = Helper::upload_picture($site_icon);
                       
                    }
                    $temp_setting->value = $icon;
                    $temp_setting->save();
                }

               else if($temp_setting->key == 'site_logo'){
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
                
                   else if($temp_setting->key == 'card'){
                        if($request->$key==1)
                        {
                            $temp_setting->value   = 1;

                        }
                        else
                        {
                            $temp_setting->value = 0;
                        }
                        $temp_setting->save();
                    }
                   else if($temp_setting->key == 'paypal'){
                        if($request->$key==1)
                        {
                            $temp_setting->value   = 1;
                        }
                        else
                        {
                            $temp_setting->value = 0;
                        }
                        $temp_setting->save();
                    }
                    else if($temp_setting->key == 'manual_request'){
                        if($request->$key==1)
                        {
                            $temp_setting->value   = 1;
                        }
                        else
                        {
                            $temp_setting->value = 0;
                        }
                        $temp_setting->save();
                    }
                  else if($request->$key!=''){
                $temp_setting->value = $request->$key;
                $temp_setting->save();
                
            }

              
            }
        
        return back()->with('setting', $settings)->with('flash_success','Settings Updated Successfully');
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
                $message = tr('admin_not_doc_updated');
            }
            else
            {
                $document = new Document;
                $message = tr('admin_not_doc');
            }
                $document->name = $request->document_name;
                $document->save();
            
        if($document)
        {
            return back()->with('flash_success',$message);
        }
        else
        {
            return back()->with('flash_error',tr('admin_not_error'));
        }
        }
    }

    public function deleteDocument(Request $request)
    {

            $document = Document::find($request->id)->delete();
       
        if($document)
        {
            return back()->with('flash_success',tr('admin_not_doc_del'));
        }
        else
        {
            return back()->with('flash_error',tr('admin_not_error'));
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
                        'provider_name' => 'required|max:255',
                                         
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
                $message = tr('admin_not_st_updated');
            }
            else
            {
                $service = new ServiceType;
                $message = tr('admin_not_st');

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
                $service->provider_name = $request->provider_name;
                $service->save();
            
        if($service)
        {
            return back()->with('flash_success',$message);
        }
        else
        {
            return back()->with('flash_error',tr('admin_not_error'));
        }
        }
    }

    public function deleteService(Request $request)
    {

            $service = ServiceType::find($request->id)->delete();
       
        if($service)
        {
            return back()->with('flash_success',tr('admin_not_st_del'));
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
                ->orderBy('user_ratings.id', 'ASC')
                ->get();
            return view('admin.reviews')->with('name', 'User')->with('reviews', $user_reviews);
    }

    public function deleteUserReviews(Request $request) {
        $user = UserRating::find($request->id)->delete();
        return back()->with('flash_success', tr('admin_not_ur_del'));
    }

    public function deleteProviderReviews(Request $request) {
        $provider = ProviderRating::find($request->id)->delete();
        return back()->with('flash_success', tr('admin_not_pr_del'));
    }

    public function UserHistory(Request $request)
    {
        $requests = DB::table('requests')
                ->Where('user_id',$request->id)
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'requests.amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status')
                ->orderBy('requests.created_at', 'ASC')
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
                ->orderBy('requests.created_at', 'ASC')
                ->get();
        return view('admin.request')->with('requests', $requests);
    }

    public function requests()
    {
        $requests = DB::table('requests')
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->leftJoin('request_payments', 'requests.id', '=', 'request_payments.request_id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'request_payments.total as amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status')
                ->orderBy('requests.created_at', 'desc')
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
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'requests.is_paid',  'requests.id as id', 'requests.created_at as date', 'requests.confirmed_provider', 'requests.status', 'requests.provider_status', 'requests.amount', 'request_payments.payment_mode as payment_mode', 'request_payments.status as payment_status', 'request_payments.total_time as total_time','request_payments.base_price as base_price', 'request_payments.time_price as time_price', 'request_payments.tax_price as tax', 'request_payments.total as total_amount', 'requests.s_latitude as latitude', 'requests.s_longitude as longitude','requests.start_time','requests.end_time','requests.before_image', 'requests.after_image', 'requests.s_address as request_address')
                ->first();    
        return view('admin.requestView')->with('request', $requests);
    }

    public function mapview()
    {
        // dd(\Auth::guard('admin')->user());
        $Providers = Provider::all();
        return view('admin.map', compact('Providers'));
    }

    public function usermapview()
    {
        // dd(\Auth::guard('admin')->user());
        $Users = User::where('latitude', '!=', '0')->where('longitude', '!=', '0')->get();
        return view('admin.userMap', compact('Users'));
    }

    public function help()
    {
        return view('admin.help');
    }

    public function providerDetails(Request $request) 
    {
        $provider = Provider::find($request->id);
        $avg_rev = ProviderRating::where('provider_id',$request->id)->avg('rating');


        if($provider) {
            $service = "";
            $service_type = ProviderService::where('provider_id' ,$provider->id)
                                ->leftJoin('service_types' ,'provider_services.service_type_id','=' , 'service_types.id')
                                ->first();
            if($service_type) {
                $service = $service_type->name;
            }
            return view('admin.providerDetails')->with('provider' , $provider)->withService($service)->with('review',$avg_rev);
        } else {
            return back()->with('error' , "Provider details not found");
        }
    }

    public function userDetails(Request $request) 
    {
        $user = User::find($request->id);
        $avg_rev = UserRating::where('user_id',$request->id)->avg('rating');

        if($user) {
            return view('admin.userDetails')->with('user' , $user)->with('review',$avg_rev);
        } else {
            return back()->with('error' , "User details not found");
        }
    }

    public function ViewChatHistory(Request $request)
    {
        $history = DB::table('chat_messages')
                ->where('chat_messages.request_id',$request->id)
                ->leftJoin('requests', 'chat_messages.request_id', '=', 'requests.id')
                ->leftJoin('providers', 'requests.confirmed_provider', '=', 'providers.id')
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name', 'providers.first_name as provider_first_name', 'providers.last_name as provider_last_name', 'users.id as user_id', 'providers.id as provider_id', 'chat_messages.*','users.picture as user_picture', 'providers.picture as provider_picture')
                ->get();    
        return view('admin.chatHistory')->with('chat_history', $history)->with('request_id',$request->id);
    }

    public function adminChatHistoryDelete(Request $request) {
        $provider = ChatMessage::where('request_id',$request->id)->delete();
        return back()->with('flash_success', tr('chat_history_delete'));
    }
}
