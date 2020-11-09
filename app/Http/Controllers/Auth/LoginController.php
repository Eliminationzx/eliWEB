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
            ->select('SELECT username, sha_pass_hash FROM account WHERE email = ?', array($email));
            $res = json_decode(json_encode($res),true);

            if (!empty($res)) {
                $username = $res[0]['username'];
                $phash = sha1(strtoupper($username).':'.strtoupper($password));
                if (strcasecmp($phash, $res[0]['sha_pass_hash']) == 0) 
                    return true;
            }
        }

        return false;    
    }
}
