<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
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
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }


    //User Functions

    public function users()
    {
        return view('admin.users');
    }

    public function addUser()
    {
        return view('admin.addUser');
    }


    //Provider Functions

    public function providers()
    {
        return view('admin.providers');
    }

    public function addProvider()
    {
        return view('admin.addProvider');
    }
}
