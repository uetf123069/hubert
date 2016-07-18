<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\ServiceType;

use App\Helpers\Helper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function service_list() {

        if($serviceList = ServiceType::all()) {
            $response_array = Helper::null_safe(array('success' => true,'services' => $serviceList));
        } else {
            $response_array = array('success' => false,'error' => Helper::get_error_message(115),'error_code' => 115);
        }
        $response = response()->json($response_array, 200);
        return $response;
    }
}
