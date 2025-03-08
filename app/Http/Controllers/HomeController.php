<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        Carbon::setLocale('id');
    }

    public function index()
    {

        return view('home');
        // if(Auth::user()->role === 'admin'){     
        // }

    }
}
