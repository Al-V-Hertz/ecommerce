<?php

namespace App\Http\Controllers;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::with('permissions')->get();
        return view("roles", compact('data'));
    }

    public function deleterole(Request $request)
    {
        $del = Role::find($request->id);
        $del->delete();
        return response()->json($del);
    }

    public function getrole(Request $request)
    {
        $role  = Role::with('permissions')->where("id", $request->id)->first();
        $perm = $role->permissions;
        $allperm = Permission::all();
        return compact('allperm', 'role', 'perm');
    }

    public function getallperm()
    {
        $p = Permission::all();
        return $p;
    }

    public function addrole(Request $request)
    {
        $this->validate($request, [
            'role' => 'required|min:4',
            'pm' => 'required',
        ]);

        $newRole = Role::create(['name' => $request->role]);
        $perm = Permission::find($request->pm);
        $newRole->givePermissionTo($perm);
        return response()->json($newRole);
    }

    public function updrole(Request $request)
    {
        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->syncPermissions($request->pm);
        $role->save();
    }

}
