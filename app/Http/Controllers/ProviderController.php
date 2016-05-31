<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\ProviderApiController;


class ProviderController extends Controller
{
    protected $ProviderApiController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProviderApiController $ProviderApiController)
    {
        $this->middleware('provider',['except' => ['change_state']]);
        $this->ProviderApiController = $ProviderApiController;
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\Auth::guard('provider')->user());
        return view('provider.dashboard');
    }

    /**
     * Show the services list.
     *
     * @return \Illuminate\Http\Response
     */
    public function services()
    {
        return view('provider.services');
    }

    /**
     * Show the request list.
     *
     * @return \Illuminate\Http\Response
     */
    public function request()
    {
        return view('provider.request');
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('provider.profile');
    }

    /**
     * Save any changes to the provider profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->details_save($request);
        $ApiResponse = $data->getData();

        // dd($ApiResponse->error_messages);

        if($ApiResponse->success == true){
            return back()->with('success', 'Profile has been saved');
        }elseif($ApiResponse->success == false){
            return back()->with('error', $ApiResponse->error_messages);
        }

    }

    /**
     * Save changed password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->changePassword($request);
        $ApiResponse = $data->getData();

        // dd($ApiResponse);

        if($ApiResponse->success == true){
            return back()->with('success', 'Password Updated');
        }elseif($ApiResponse->success == false){
            return back()->with('error', $ApiResponse->error);
        }
    }


    /**
     * change State.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_state(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->available_update($request);
        $ApiResponse = $data->getData();

        return response()->json($ApiResponse);
    }


    /**
     * Update location.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_location(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->location_update($request);
        $ApiResponse = $data->getData();

        // dd($ApiResponse);

        if($ApiResponse->success == true){
            return back()->with('success', 'Location Updated');
        }elseif($ApiResponse->success == false){
            return back()->with('error', $ApiResponse->error);
        }
    }

    /**
     * Show the ongoing list.
     *
     * @return \Illuminate\Http\Response
     */
    public function ongoing()
    {
        return view('provider.ongoing');
    }

    /**
     * Show the documents list.
     *
     * @return \Illuminate\Http\Response
     */
    public function documents()
    {
        return view('provider.documents');
    }
}
