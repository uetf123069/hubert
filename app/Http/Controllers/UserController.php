<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\Settings;

use App\User;

use App\Cards;

class UserController extends Controller
{

    protected $UserAPI;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserapiController $API)
    {
        $this->UserAPI = $API;
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.dashboard');
    }

    /**
     * Show the services list.
     *
     * @return \Illuminate\Http\Response
     */
    public function services(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $Services = $this->UserAPI->history($request)->getData();

        return view('user.services', compact('Services'));
    }

    /**
     * Show the request list.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_form(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $CurrentRequest = $this->UserAPI->request_status_check($request)->getData();

        // dd($CurrentRequest);

        if(empty($CurrentRequest->data)) {
            $ServiceTypes = $this->UserAPI->service_list($request)->getData();
            return view('user.request', compact('ServiceTypes'));
        } else {
            if($CurrentRequest->data[0]->status < 3) {
                return view('user.request_waiting', compact('CurrentRequest'));
            } else if($CurrentRequest->data[0]->status == 3) {
                $PaymentMethods = $this->UserAPI->get_payment_modes($request)->getData();
                // dd($PaymentMethods);
                return view('user.request_payment', compact('CurrentRequest','PaymentMethods'));
            } else if($CurrentRequest->data[0]->status == 4) {
                return view('user.request_rating', compact('CurrentRequest'));
            }
        }
    }

    /**
     * Process user request.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_submit(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);
        
        $response = $this->UserAPI->send_request($request)->getData();

        if($response->success) {
            $response->message = "Your request has been posted. Waiting for provider to respond";
        } else {
            $response->success = false;
            if(isset($response->error_messages)) {
                $response->message = $response->error." ".$response->error_messages;
            } else {
                $response->message = $response->error;
            }
        }

        return back()->with('response', $response);
    }

    /**
     * Process user request.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_cancel(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);

        $response = $this->UserAPI->cancel_request($request)->getData();

        if($response->success) {
            $response->message = "Your request has been cancelled.";
        } else {
            $response->success = false;
            $response->message = $response->error." ".$response->error_messages;
        }

        return back()->with('response', $response);
    }

    /**
     * Get Latest update.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_updates(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $response = $this->UserAPI->request_status_check($request)->getData();

        return response()->json($response);
    }

    /**
     * Process user request.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_payment(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'is_paid' => 1
        ]);

        $response = $this->UserAPI->paynow($request)->getData();

        if($response->success) {
            $response->message = "Payment successful.";
        } else {
            $response->success = false;
            $response->message = $response->error;
        }

        return back()->with('response', $response);
    }

    /**
     * Process user request.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_review(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);

        // dd($request->all());

        $response = $this->UserAPI->rate_provider($request)->getData();

        // dd($response);

        if($response->success) {
            $response->message = "Thank you for reviewing the provider.";
        } else {
            $response->success = false;
            $response->message = $response->error;
        }

        return back()->with('response', $response);
    }


    /**
     * Show the payment methods.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_form(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);

        $PaymentMethods = $this->UserAPI->get_user_payment_modes($request)->getData();

        $PaypalID = \Auth::user()->paypal_email;
        
        return view('user.payment', compact('PaymentMethods', 'PaypalID'));
    }

    /**
     * Show the payment methods.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_card_add(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);

        $user_id = \Auth::user()->id;
        $user = User::find($user_id);
        $payment_token = $request->stripeToken;
        $last_four = substr($request->number,-4);
        $email = \Auth::user()->email;
        $settings = Settings::where('key' , 'stripe_secret_key')->first();
                        $stripe_secret_key = $settings->value;
                \Stripe\Stripe::setApiKey($stripe_secret_key);

        try{

                // Get the key from settings table
                
                    $customer = \Stripe\Customer::create(array(
                                   "card" => $payment_token,
                                  "email" => $email)
                                );
                if($customer){

                    $customer_id = $customer->id;

                    $cards = new Cards;
                    $cards->user_id = $request->id;
                    $cards->customer_id = $customer_id;
                    $cards->last_four = $last_four;
                    $cards->card_token = $customer->sources->data[0]->id;

                    // Check is any default is available
                    $check_card = Cards::where('user_id',$request->id)->first();

                    if($check_card ) 
                        $cards->is_default = 0;
                    else
                        $cards->is_default = 1;
                    
                    $cards->save();

                    if($user) {
                        $user->payment_mode = 'card';
                        $user->default_card = $cards->id;
                        $user->save();
                    }

                    $response_array = array('success' => true);
                    $response_code = 200;
                
                } else {
                    $response->message('Could not create client ID');
                }
            
            } catch(Exception $e) {
                $response->message('error'. $e);
            
            }

        $PaymentMethods = $this->UserAPI->get_user_payment_modes($request)->getData();
        
        return back();
    }

    /**
     * Show the payment methods.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_card_def(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);

        $response = $this->UserAPI->default_card($request)->getData();
        
        if($response->success) {
            $response->message = "Successfully made card as default";
        } else {
            $response->message = "Unknown error please try again later";
        }

        return back()->with('response', $response);
    }

    /**
     * Show the payment methods.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_card_del(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
        ]);

        $response = $this->UserAPI->delete_card($request)->getData();
        
        if($response->success) {
            $response->message = "Successfully made card as default";
        } else {
            $response->message = "Unknown error please try again later";
        }

        return back()->with('response', $response);
    }

    /**
     * Show the payment methods.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_update_paypal(Request $request)
    {
        $this->validate($request, [
                'paypal_email' => 'email',
            ]);

        \Auth::user()->paypal_email = $request->paypal_email;
        \Auth::user()->save();

        $response = response()->json([]);
        $response->success = true;
        $response->message = 'Paypal Account has been successfully updated.';

        return back()->with('response', $response);
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_form()
    {
        return view('user.profile');
    }

    /**
     * Save any changes to the users profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $response = $this->UserAPI->update_profile($request)->getData();

        if($response->success) {
            $response->message = "Profile has been updated";
        } else {
            $response->success = false;
            $response->message = $response->error." ".$response->error_messages;
        }

        return back()->with('response', $response);
    }

    /**
     * Save changed password.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save_password(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $response = $this->UserAPI->change_password($request)->getData();

        if($response->success) {
            $response->message = "Password has been updated. You can log in with the new password from next time.";
        } else {
            $response->success = false;
            $response->message = $response->error." ".$response->error_messages;
        }

        return back()->with('response', $response);
    }

    public function test(Request $request)
    {
        dd($request);
    }
}