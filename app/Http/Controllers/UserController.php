<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\Http\Controllers\UserapiController;



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

        if($CurrentRequest->success) {

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
            $response->message = $response->error;
        }

        return back()->with('response', $response);
    }

    /**
     * Show the payment methods.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        return view('user.payment');
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
        $url = url('/userApi/updateProfile');

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $data = $this->UserapiController->update_profile($request);

        return redirect('back')->with('success', 'Profile has been saved');
    }

    /**
     * Save changed password.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save_password()
    {
        return redirect('back')->with('success', 'Password has been updated');
        // return view('user.profile');
    }
}