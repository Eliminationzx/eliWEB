<?php

namespace App\Http\Controllers\admin;

use DB;
use App\Http\Controllers\Controller;
use App\Role;
use App\Role_user;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function getallusers() {
        $data = Auth::user();
        if ($data->can('view-users') === false) {
            abort(403);
        }
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.system.users.getallusers',compact(['users','data']));
    }

    public function formupdateusers($id) {
        $data = Auth::user();
        if ($data->can('update-users') === false) {
            abort(403);
        }
        $roles = Role::all();
		
		$user = User::find($id);
		if (empty($user))
			return redirect()->route('admin.users');
		
        $role_permissions = $user->roles()->pluck('id')->toArray();

        return view('admin.system.users.formupdateusers',compact(['roles','role_permissions','user', 'data']));
    }
	
	public function search(Request $request) {
        $data = $request->user();
		if ($data->can('view-users') === false) {
            abort(403);
        }
		
        $searchstr = $request->input('searchstr');
        
        preg_match_all(strpos($searchstr, '@') !== false ? '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix' : '/[\p{L}\p{Z}\h\v\-]+/u', $searchstr, $matches);

        $users = null;
        
        foreach ($matches[0] as $match) {
            if (Trim($match) === '')
                continue;

			$users_tmp = User::Where('email', '=' , $match)->orWhere('name', 'LIKE', '%'.$match.'%')->get()->toArray();

            if (!$users)
                $users = $users_tmp;
            else 
                $users = array_merge_recursive($users, $users_tmp);
        }
        
        if (empty($users)) {
            return redirect()->route('admin.users')->with([
                'status' => 'Unfortunately, nothing was found at your request..',
                'type' => 'danger',
              ]
            );
        } else {
			foreach ($users as &$user) {
				$user['roles'] = User::find($user['id'])->roles;
			}
		}
                                               
        return view('admin.system.users.searchusers', compact(['users','data']));
    }

    public function updateusers(Request $request) {
        $data = $request->user();
        if ($data->can('update-users') === false) {
            abort(403);
        }
		
        $id = $request->usersid;
        $user = User::find($id);
		if ($user == null)
			return redirect()->route('admin.users');
		
        $user->name = $request->username;
        $user->email = $request->email;			
		$pass = $request->password;
		$repeatpass = $request->repeatpassword;
		$role = $request->role;
		
	    $servers = explode(',', env('APP_GAME_SERVER_LIST'));	
		foreach ($servers as $server) {
			$user['userid_'.$server] = $request['userid_'.$server];
		}

        if(!empty($pass)){
            if ($pass != $repeatpass) {
                return back()->with('status', 'The passwords you entered do not match!');
            }else{
                $user->password = Hash::make($pass);
				$this->gamepasswordupdate($user, $pass);
            }
        }
			
		$user->donate = $request->donate;
		$user->vote = $request->vote;
		$user->status = $request->status === null ? 0 : 1;
        Role_user::where('user_id',$id)->delete();
        if($role != null){
            foreach ($role as $key=>$value){
                $user->attachRole($value);
            }
        }
		$user->save();	

        return redirect()->route('admin.users')->with('status', 'User successfully edited!');
    }

    public function deleteusers (Request $request){
        $data = $request->user();
        if ($data->can('delete-users') === false) {
            abort(403);
        }
        $id = $request->element_id;
		Role_user::where('user_id',$id)->delete();
        User::find($id)->delete();
    }
	
	public function gamepasswordupdate($user, $pass) {
        $username = $user->name;
        $email = $user->email;
        
        $passhash = sha1(strtoupper($username).':'.strtoupper($pass));
        $battlepasshash = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($email)).":".strtoupper($pass)))))))); 
              
		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
		foreach ($servers as $server) {
		   if (!$this->isauthdbavailable($server))
			   continue;
		   
		   if ($this->hasbattlenet($server)) {
			   DB::connection('mysql_'.$server.'_auth')
				->update('UPDATE battlenet_accounts SET sha_pass_hash = ? WHERE id = ? AND email = ?', array($battlepasshash, $user['userid_'.$server], $email));
		   }
		   DB::connection('mysql_'.$server.'_auth')
          ->update('UPDATE account SET sha_pass_hash = ?, v = ?, s = ? WHERE id = ? AND email = ?', array($passhash, 0, 0, $user['userid_'.$server], $email));		  
		}
    }
}
