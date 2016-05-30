<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\Http\Controllers\UserapiController;



class UserController extends Controller
{

    protected $UserapiController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserapiController $UserapiController)
    {
        $this->middleware('auth');
        $this->UserapiController = $UserapiController;
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
    public function services()
    {
        return view('user.services');
    }

    /**
     * Show the request list.
     *
     * @return \Illuminate\Http\Response
     */
    public function request()
    {
        return view('user.request');
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_edit()
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
        $data = $request->all();

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $data = $this->UserapiController->update_profile($request);

        dd($data);

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