<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

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

        if(empty($CurrentRequest->data)) {
            $ServiceTypes = $this->UserAPI->service_list($request)->getData();
            return view('user.request', compact('ServiceTypes'));
        } else {
            return view('user.request_pending', compact('CurrentRequest'));
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
            $response->message = $response->error." ".$response->error_messages;
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

        $PaymentMethods = $this->UserAPI->get_user_payment_modes($request)->getData();
        
        return view('user.payment');
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