<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Role_user;
use App\Permission;
use App\Permission_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRolesController extends Controller
{
    public function getallroles() {
        $data = Auth::user();
        if ($data->can('view-roles') === false) {
            abort(403);
        }
        $roles = Role::orderBy("id", 'desc')->paginate(10);
        return view('admin.system.roles.getallroles',compact(['roles', 'data']));
    }

    public function formcreateroles(){
        $data = Auth::user();
        if ($data->can('create-roles') === false) {
            abort(403);
        }
        $permissions = Permission::all();
        return view('admin.system.roles.formcreateroles',compact(['permissions', 'data']));
    }

    public function createroles(Request $request) {
        $data = $request->user();
        if ($data->can('create-roles') === false) {
            abort(403);
        }
        $role = new Role();
        $role->name         = $request->name;
        $role->display_name = $request->display_name; // optional
        $role->description  = $request->description; // optional
        $role->save();

        foreach ($request->permission as $key=>$value){
            $role->attachPermission($value);
        }
        return redirect()->route('admin.roles')->with('status', 'Role successfully created!');
    }

    public function formupdateroles($id) {
        $data = Auth::user();
        if ($data->can('update-roles') === false) {
            abort(403);
        }
        $role = Role::find($id);
        $permissions=Permission::all();
        $role_permissions = $role->perms()->pluck('id','id')->toArray();

        return view('admin.system.roles.formupdateroles',compact(['role','role_permissions','permissions', 'data']));
    }

    public function updateroles(Request $request) {
        $data = $request->user();
        if ($data->can('update-roles') === false) {
            abort(403);
        }
        $id = $request->roleid;
        $role = Role::find($id);
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->save();

        Permission_role::where('role_id',$id)->delete();
        if($request->permission){
            foreach ($request->permission as $key=>$value){
                $role->attachPermission($value);
            }
        }
        return redirect()->route('admin.roles')->with('status', 'The role has been successfully updated!');
    }

    public function deleteroles (Request $request){
        $data = $request->user();
        if ($data->can('delete-roles') === false) {
            abort(403);
        }
        $id = $request->element_id;
        $role = Role::findOrFail($id);
        $role->delete();
    }
}
