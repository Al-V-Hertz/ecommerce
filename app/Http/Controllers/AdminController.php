<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class AdminController extends Controller
{
    public function index(){
        $data = Item::all();
        return view('admin', compact('data'));
    }
}
