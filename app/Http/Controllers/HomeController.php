<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(Auth::user()->user_type == 'client'){
            return redirect('client');
        }
        else if(Auth::user()->user_type == 'admin'){
            return redirect('admin');
        }
    }
}
