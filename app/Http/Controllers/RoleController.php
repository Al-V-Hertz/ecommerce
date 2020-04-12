<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function roles()
    {
        return view("roles");
    }
    
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $data = Role::with('permissions')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn ="<button id = '$row->id' class='btn btn-primary edit'>Edit</button>";
                           $btn= $btn."  <button id='$row->id' class='btn btn-danger delete'>Delete</button>";
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }
}
