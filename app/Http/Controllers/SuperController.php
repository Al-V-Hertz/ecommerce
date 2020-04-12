<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Illuminate\Http\Request;
use DataTables;
class SuperController extends Controller
{
    public function __construct()
    {
        $this->middleware('superadmin');
    }
    
    public function index()
    {
        return view("superadmin");
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('roles')->get();
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

    public function adduser(Request $request)
    {
        $newUser = new User();
        $newUser->name = $request->addname;
        $newUser->email = $request->addemail;
        if($request->addpassword == $request->conpassword)
        {
            $newUser->password = Hash::make($request->addpassword);
        }
        $newUser->assignRole($request->addrole);
        $newUser->save();
        return "Success";
    }

    public function getuser(Request $request)
    {
        $user = User::with('roles')->where('id', $request->id)->first();
        $perms = Role::findByName($user->roles[0]->name)->permissions;
        $roles = Role::all();
        // dd($user);
        return compact('user', 'perms', 'roles');
    }

    public function getroles()
    {
        $roles = Role::all();
        return $roles;
    }

    public function updateuser(Request $request)
    {
        $updUser = User::with('roles')->where("id", $request->updid)->first();
        $updUser->name = $request->updname;
        $updUser->email = $request->updemail;
        $updUser->password = Hash::make($request->updpassword);
        $updUser->removeRole($updUser->roles[0]->name);
        $updUser->assignRole($request->updrole);
        $updUser->save();
        // dd($request->updid);
        return "Successfully";
    }

    public function getpermissions(Request $request)
    {
        $pm = Role::findByName($request->role)->permissions;
        return compact('pm');
    }

    public function deleteuser(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
    }
}
