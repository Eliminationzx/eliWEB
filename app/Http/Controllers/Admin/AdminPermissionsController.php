<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Permission_role;
use App\Role;
use App\Role_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPermissionsController extends Controller
{
    public function getallpermissions() {
        $data = Auth::user();
        if ($data->can('view-permissions') === false) {
            abort(403);
        }
        $permissions = Permission::orderBy("id", 'desc')->paginate(10);
        return view('admin.system.permissions.getallpermission',compact(['permissions', 'data']));
    }

    public function formcreatepermissions() {

        $data = Auth::user();
        if ($data->can('create-permissions') === false) {
            abort(403);
        }
        $roles = Role::all();
        return view('admin.system.permissions.formcreatepermissions',compact(['roles', 'data']));
    }

    public function createpermissions(Request $request) {
        $data = $request->user();
        if ($data->can('view-permissions') === false) {
            abort(403);
        }
        $permission = new Permission();
        $permission->name         = $request->name;
        $permission->display_name = $request->display_name; // optional
        $permission->description  = $request->description; // optional
        $permission->save();

        if($request->role) {
            foreach ($request->role as $key => $value) {
                $role = Role::findOrFail($value);
                $role->attachPermission($permission);
            }
        }
        return redirect()->route('admin.permissions')->with('status', 'The Privilege is successfully created!');
    }

    public function formupdatepermissions($id) {
        $data = Auth::user();
        if ($data->can('update-permissions') === false) {
            abort(403);
        }
        $permissions = Permission::find($id);
        $roles=Role::all();
        $role_permissions = $permissions->roles->pluck('id','id')->toArray();
        return view('admin.system.permissions.formupdatepermissions',compact(['roles','role_permissions','permissions', 'data']));
    }

    public function updatepermissions(Request $request) {
        $data = $request->user();
        if ($data->can('update-permissions') === false) {
            abort(403);
        }
        $id = $request->permissionid;
        $permission = Permission::find($id);
        $permission->name=$request->name;
        $permission->display_name=$request->display_name;
        $permission->description=$request->description;
        $permission->save();

        Permission_role::where('permission_id',$id)->delete();
        if($request->role){
            foreach ($request->role as $key=>$value){
                $role = Role::findOrFail($value);
                $role->attachPermission($permission);
            }
        }

        return redirect()->route('admin.permissions')->with('status', 'The Privilege has been successfully renewed!');
    }

    public function deletepermissions (Request $request) {
        $data = $request->user();
        if ($data->can('delete-permissions') === false) {
            abort(403);
        }
        $id = $request->element_id;
        $role = Permission::findOrFail($id);
        $role->delete();
    }
}
