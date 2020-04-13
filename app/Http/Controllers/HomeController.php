<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        if(Auth::user()->hasRole('superadmin')){
            return redirect('control');
        }
        else if(Auth::user()->hasRole('admin')){
            return redirect('admin');
        }
        else{
            return redirect('client');
        }
    }
}
