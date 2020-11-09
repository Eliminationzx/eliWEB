<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AccountsController extends Controller
{
    public function passwords() {
        $data = Auth::user();
        $server = Cookie::get('server');
        return $this->servervalidation($server) ? view('admin.account.passwords', ['data' => $data]) : redirect()->route('personal');
    }
    
    public function updateavatar(Request $request) {
        $data = $request->user();
        
        if ($request->hasFile('avatar')) {
            
            $this->validate($request, [
            'avatar' => 'mimes:jpeg,gif,png,bmp,tiff |max:4096 |dimensions:min_width=170,min_height=170,max_width=300,max_height=300',
            ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                    'mimes' => 'Only jpeg,gif, png, bmp,tiff are allowed.',
                    'dimensions' => 'Maximum image size 300x300px.'
                ]
            );
                      
            $avatar = $request->file('avatar');

            $filename = $data->id.'_'.$data->name.'.'. $avatar->getClientOriginalExtension();
            $avatar->move(storage_path('app/public/uploads/avatars'), $filename);
            $data->update(['avatar' => $filename]);
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Changing the profile avatar in your personal cabinet';
            $history['type'] = 'profile';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
        }
        
        return redirect()->back();
    }

    public function updatepasswords(Request $request) {
        $data = $request->user();     
        $username = $data->name;
        $email = $data->email;
        $pass = $request->input('NewPassword');
        $confirmpass = $request->input('ConfrimPassword');
        $oldpass = $request->input('OldPassword');
        
        if (!Hash::check($oldpass, $data->password)) {
            return redirect()->route('accounts.passwords')->with([
                'status' => 'You entered the wrong old password!',
                'type' => 'danger',
              ]
            );
        }

        if ($pass != $confirmpass) {
            return redirect()->route('accounts.passwords')->with([
                'status' => 'Fields with new password do not match!',
                'type' => 'danger',
              ]
            );
        }      
        
        $this->updatepasshashes($data, $pass);
        
        $history['userid'] = $data->id;
        $history['comment'] = 'Password change';
        $history['type'] = 'profile';
        $history['ip'] = $request->ip();
        $this->sethistory($history);
            
        return redirect()->route('accounts.passwords')->with([
                'status' => 'Password changed successfully!',
                'type' => 'success',
              ]
        );
    }
    
    public function updatepasshashes($data, $pass) {       
        $data->update(['password' => Hash::make($pass)]); 
        
        $username = $data->name;
        $email = $data->email;
        
        $passhash = sha1(strtoupper($username).':'.strtoupper($pass));
        $battlepasshash = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($email)).":".strtoupper($pass))))))));
		
		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
		foreach ($servers as $server) {
		   if (!$this->isauthdbavailable($server))
			   continue;
		   
		   if ($this->hasbattlenet($server)) {
			   DB::connection('mysql_'.$server.'_auth')
				->update('UPDATE battlenet_accounts SET sha_pass_hash = ? WHERE id = ? AND email = ?', array($battlepasshash, $data['userid_'.$server], $email));
		   }

		   DB::connection('mysql_'.$server.'_auth')
          ->update('UPDATE account SET sha_pass_hash = ?, v = ?, s = ? WHERE id = ? AND email = ?', array($passhash, 0, 0, $data['userid_'.$server], $email));		  
		}
    }

    public function activity() {
        $data = Auth::user();
        $activities = History::where('userid', $data->id)->orderBy('created_at', 'DESC')->paginate(10);       
        return view('admin.account.activity',compact(['activities', 'data']));
    }
    
    public function cleanupactivities(Request $request) {   
        $oauth_token =  $request->input('oauth_token');
         
        if ($oauth_token != env('OAUTH_CLEANUP_ACTIVITIES_TOKEN')) {
             abort(403);
        }
        
        History::truncate();
    }
}
