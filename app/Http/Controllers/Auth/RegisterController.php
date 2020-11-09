<?php
namespace App\Http\Controllers\Auth;

use Cookie;
use Mail;
use DB;
use App\Role;
use App\User;
use App\Referal;
use App\History;
use App\Userphone;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\EmailVerificator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data) {
        return Validator::make($data, [
            'name' => 'required|max:30|min:3|unique:users|regex:/^[A-Za-z0-9 ]+$/',
            'email' => 'required|email:rfc,dns|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'terms' => 'required|accepted',
            'g-recaptcha-response' => 'required|recaptcha',
            'recruiter_name' => 'exists:users,name',            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data) { 
        $username = $data['name'];     
        $email = $data['email'];
        $pass = $data['password'];       

        // XenForo API
		if (env('XENFORO_API_STATE') == 1) {
			$oauth_token = env('XENFORO_OAUTH_TOKEN');
			$action = 'register';        
			$api_url = env('XENFORO_API_URL');     
			
			if ($this->createXenforoAccount($username, $pass, $email, $oauth_token, $action, $api_url) != 'Success')
				return null;
		}

        return User::create([
				  'name' => $username,
				  'password' => bcrypt($pass),
				  'email' => $email,
				  'verify_token' => Str::random(40),
				]);        
    }
    
    public function createXenforoAccount($username, $pass, $email, $oauth_token, $action, $api_url) {
        $postvalue = array(
          'oauth_token' => $oauth_token,
          'action' => $action,
          'user' => $username,
          'pass' => $pass,
          'email' => $email
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvalue);
        $xen_reg_result = curl_exec($ch);
        curl_close($ch);
        
        return $xen_reg_result;
    }
    
    public function getGameAccountIdsByEmail($email) {     
		$userids = array();	
		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
        foreach ($servers as $server) {
            if (!$this->isauthdbavailable($server))
			    continue;
			
			$res = DB::connection('mysql_'.$server.'_auth')
            ->select('SELECT id FROM account WHERE email = ?', array($email));
			$res = json_decode(json_encode($res),true);			
			$userids['userid_'.$server] = $res[0]['id']; 
		}			
        return $userids;        
    }
    
    public function registerGameAccounts($username, $email, $pass, $recruiter_ids) {  
        if ($this->isGameAccountUnique($username, $email))
            return false;
        
        $passaccount = sha1(strtoupper($username).':'.strtoupper($pass));                
        $battlepass = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($email)).":".strtoupper($pass))))))));

		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
		foreach ($servers as $server) {
			if (!$this->isauthdbavailable($server))
				continue;
			
		    $recruiter_id = empty($recruiter_ids) ? 0 : $recruiter_ids['recruiter_'.$server];
			
			if ($this->hasbattlenet($server)) {
				DB::connection('mysql_'.$server.'_auth')
			  ->insert('INSERT INTO battlenet_accounts (email, sha_pass_hash) VALUES (?, ?)', array($email, $battlepass));
				
				$bnet_id = $this->getBnetIdByEmail($server, $email);   

				DB::connection('mysql_'.$server.'_auth')
				  ->insert('INSERT INTO account (username, sha_pass_hash, email, reg_mail, battlenet_account, recruiter) VALUES 
					(?, ?, ?, ?, ?, ?)', array($username, $passaccount, $email, $email, $bnet_id, $recruiter_id));
			} else {
				DB::connection('mysql_'.$server.'_auth')
			  ->insert('INSERT INTO account (username, sha_pass_hash, email, reg_mail, recruiter) VALUES (?, ?, ?, ?, ?)', array($username, $passaccount, $email, $email, $recruiter_id)); 
			}
		}
        return true;
    }
    
    public function isGameAccountUnique($username, $email) {
        $servers = explode(',', env('APP_GAME_SERVER_LIST'));
        foreach ($servers as $server) {
		  if (!$this->isauthdbavailable($server))
			  continue;
		
		  $result = DB::connection('mysql_'.$server.'_auth')
          ->select('SELECT username, email FROM account WHERE username= ? OR email= ?', array($username, $email)); 
		  if (!empty($result))
			  return true;
		}	  
        return false;
    }
    
    public function getBnetIdByEmail($server, $email) {  
	  $battlenetinfo = DB::connection('mysql_'.$server.'_auth')
            ->select('SELECT id FROM battlenet_accounts WHERE email = ?', array($email));
      $battlenetinfo = json_decode(json_encode($battlenetinfo),true); 
      return $battlenetinfo[0]['id'];
    }
    
    public function sendEmailDone($email, $verify_token) {             
       $user = User::where(['email' => $email, 'verify_token' => $verify_token])->first();
       
	   if ($user) {       
			$user->update(['status' => '1', 'verify_token' => NULL]);
			
			$servers = explode(',', env('APP_GAME_SERVER_LIST'));
			foreach ($servers as $server) {
				if (!$this->isauthdbavailable($server))
					continue;
				
				DB::connection('mysql_'.$server.'_auth')
			  ->update('UPDATE account SET '.($server === 'vanilla' ? 'email_verif' : 'active').' = ? WHERE email = ?', array(1, $user->email));
			}
			
			return redirect()->route('login')->with([
				'status' => 'You have confirmed your e-mail address and have completed registration.',
				'type' =>'success',
			  ]
			);
		} else {
			return redirect()->route('login')->with([
				'status' => 'The link is invalid.',
				'type' => 'danger',
			  ]
			);
		}
    }
    
    public function showRegistrationForm($recruiter_name = null) {            
        $recruiter = User::Where('name', $recruiter_name)->first();
        return view('auth.register', ['recruiter' => $recruiter]);
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());    
        if (!$user)
            return redirect()->route('register')->withErrors(['other' => 'There\'s been an unknown error...']);		
        event(new Registered($user));      
        return $this->registered($request, $user) ?: 
                redirect($this->redirectPath());
    }
    
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    public function registered(Request $request, $user) {      
        $email = $request->input('email');
        $pass = $request->input('password');
        $phone = $request->input('phone');
        $recruiter_name = $request->input('recruiter_name');
        $referal = null;
        $recruiter_ids = array();

        // attach role group
        $user->attachRole(Role::where('name','User')->first());        
         
        if (!empty($phone)){
            $userphone = new Userphone();
            $userphone->userid = $user->id;
            $userphone->phone = $phone;
            $userphone->save();
        }                 
             
        if(!empty($recruiter_name)) {
            $recruiter = User::Where('name', $recruiter_name)->first();
            
            if ($recruiter) {
                $referal = new Referal();
                $referal->referalid = $recruiter->id;
                $referal->save();

				$servers = explode(',', env('APP_GAME_SERVER_LIST'));
				foreach ($servers as $server) {	
					$recruiter_ids['recruiter_'.$server] = $recruiter['userid_'.$server];
				}           
            }
        }
		
        // register game accounts                                    
        if ($this->registerGameAccounts($user->name, $user->email, $pass, $recruiter_ids)) {				
            $gameaccountids = $this->getGameAccountIdsByEmail($email);
			if (empty($gameaccountids)) {
				return redirect()->route('register')->with([
						'status' => 'It is impossible to connect to the game servers database, the account is created incorrectly. Please contact the administrator!',
						'type' => 'danger',
					  ]
				);
			}
			
			foreach ($gameaccountids as $key => $value) {
				$user->update([$key => $value]);                                                           
			  
				if ($referal) {
					$referal->update([
					  'userid' => $user->id,
					  $key => $value
					]);
				}
			}
					
			if (env('EMAIL_VERIFICATION_STATE') == 1) {
				Mail::send(new EmailVerificator($user));			
			}
			
			return redirect()->route('register')->with([
				/*'status' => 'The account has been successfully registered. An email was sent to your specified email address with instructions on how to complete the registration.',*/                
				'status' => 'La cuenta ha sido registrada con éxito. Puede iniciar sesión cuando guste.',
				'type' => 'success',
			  ]
			);				
			
        } else {
			return redirect()->route('register')->with([
					'status' => 'There was an unknown error, the account was created incorrectly. Please, contact the administrator!',
					'type' => 'danger',
				  ]
			);
        }
    }
}
