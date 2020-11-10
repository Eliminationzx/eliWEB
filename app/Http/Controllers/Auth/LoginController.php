<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Http\Controllers\Controller;
use App\User;
use App\History;
use App\Role;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/personal';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function credentials(Request $request)
    {
        $request['status'] = env('EMAIL_VERIFICATION_STATE') == 1 ? 1 : 0;
        return $request->only('email', 'password', 'status');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {     
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    public function authenticated(Request $request, $user)
    {   
        $gameaccountids = $this->getGameAccountIdsByEmail($user->email);

        foreach ($gameaccountids as $key => $value) {
                $user->update([$key => $value]);
        }  

        $history['userid'] = $user->id;
        $history['comment'] = 'Login to control panel';
        $history['type'] = 'auth_cp';
        $history['ip'] = $request->ip();
        $this->sethistory($history);   
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $email = $request['email'];
        $password =  $request['password'];
        if ($this->syncGameAccountsWithCredentials($email, $password) && 
            User::where('email', $email)->first() == null)
        {
            $user = new User();
            $user->password = Hash::make($password);
            $user->email = $email;
            $user->name = strtok($email, '@');
            $user->status = 1;
            $user->save();

            // attach role group
            $user->attachRole(Role::where('name','User')->first());
        } 

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    public function syncGameAccountsWithCredentials($email, $password) {     
        $servers = explode(',', env('APP_GAME_SERVER_LIST'));
        foreach ($servers as $server) {
            if (!$this->isauthdbavailable($server))
                continue;
            
            $res = DB::connection('mysql_'.$server.'_auth')
            ->select('SELECT username, salt, verifier, session_key_auth FROM account WHERE email = ?', array($email));
            $res = json_decode(json_encode($res),true);

            if (!empty($res)) {
                $username = $res[0]['username'];
                $salt = $res[0]['salt'];
                $verifier = $res[0]['verifier'];
                //$phash = sha1(strtoupper($username).':'.strtoupper($password));
                //  if (strcasecmp($phash, $res[0]['sha_pass_hash']) == 0) 
                //    return true;
                if ($this->VerifySRP6Login($username, $password, $salt, $verifier)) 
                    return true;
            }
        }

        return false;    
    }
    
    public function CalculateSRP6Verifier($username, $password, $salt)
    {
        // algorithm constants
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);
        
        // calculate first hash
        $h1 = sha1(strtoupper($username . ':' . $password), TRUE);
        
        // calculate second hash
        $h2 = sha1($salt.$h1, TRUE);
        
        // convert to integer (little-endian)
        $h2 = gmp_import($h2, 1, GMP_LSW_FIRST);
        
        // g^h2 mod N
        $verifier = gmp_powm($g, $h2, $N);
        
        // convert back to a byte array (little-endian)
        $verifier = gmp_export($verifier, 1, GMP_LSW_FIRST);
        
        // pad to 32 bytes, remember that zeros go on the end in little-endian!
        $verifier = str_pad($verifier, 32, chr(0), STR_PAD_RIGHT);
        
        // done!
        return $verifier;
    }
    
    public function VerifySRP6Login($username, $password, $salt, $verifier)
    {
        // re-calculate the verifier using the provided username + password and the stored salt
        $checkVerifier = $this->CalculateSRP6Verifier($username, $password, $salt);
        
        // compare it against the stored verifier
        return ($verifier === $checkVerifier);
    }
}
