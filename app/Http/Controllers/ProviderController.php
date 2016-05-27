<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProviderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('provider');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * Save changed password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('provider.profile');
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
