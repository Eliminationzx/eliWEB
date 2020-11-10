<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }
    
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    public function resetPassword($user, $password) {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        $this->gamepasswordreset($user, $password);
        $this->guard()->login($user);        
    }
    
    public function gamepasswordreset($user, $pass) {
        $username = $user->name;
        $email = $user->email;
        
        // old method
        $passhash = sha1(strtoupper($username).':'.strtoupper($pass));
        $battlepasshash = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($email)).":".strtoupper($pass)))))))); 
        
         // generate a random salt
        $salt = random_bytes(32);
        
        // calculate verifier using this salt
        $verifier = $this->CalculateSRP6Verifier($username, $pass, $salt);
              
		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
		foreach ($servers as $server) {
		   if (!$this->isauthdbavailable($server))
			   continue;
		   
		   if ($this->hasbattlenet($server)) {
			   DB::connection('mysql_'.$server.'_auth')
				->update('UPDATE battlenet_accounts SET sha_pass_hash = ? WHERE id = ? AND email = ?', array($battlepasshash, $user['userid_'.$server], $email));
		   }
		   DB::connection('mysql_'.$server.'_auth')
          ->update('UPDATE account SET salt = ?, verifier = ?, sha_pass_hash = ?, WHERE id = ? AND email = ?', array($salt, $verifier, $passhash, $user['userid_'.$server], $email));		  
		}
    }
}
