<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Vote_log;
use App\Realms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PersonalController extends Controller
{
    public function index()
    {
        $data = Auth::user(); 
        $ip = \Request::ip();        
        $server = Cookie::get('server');
         
        $userinfo = array();
        $accgameinfo = null;
        $accountbaninfo = null;
        $recruiterinfo = null;
        $recruiterdata = null;
        $ipbaninfo = null;
        $sumplaytime = null;
        $premiuminfo = null;
		$realminfos = null;
            
        if ($this->servervalidation($server)) {      
            $userinfo = $this->getuserinfo($server, $data);
            $accgameinfo = $this->getgameaccountinfo($server, $data);
            $accountbaninfo = $this->getaccountbaninfo($server, $data);
            $ipbaninfo = $this->getipbaninfo($server, $ip);
			$premiuminfo = $this->getpremiuminfo($server, $data);
			
			if ($userinfo)
				$sumplaytime = $this->getsumplaytime($userinfo);
            
			if ($accgameinfo) {
				$recruiterid = $accgameinfo[0]['recruiter'];  		
				$recruiterdata = User::find($recruiterid);
				
				if ($recruiterdata)            
					$recruiterinfo = $this->getuserinfo($server, $recruiterdata); 
			}
						
		    $realminfos = Realms::where('server', $server)->get();
			foreach ($realminfos as &$realminfo) {
				$realminfo->{ 'online' } = $this->getonlinecount($realminfo->realmid, $realminfo->server);
				$realminfo->{ 'status' } = $this->getserverstatus($realminfo->realmid, $realminfo->server);
			}
        }

        return view('admin.home', ['data' => $data,
                    'userinfo' => $userinfo,                   
                    'accountbaninfo' => $accountbaninfo,
                    'ipbaninfo' => $ipbaninfo,         
                    'sumplaytime' => $sumplaytime,
                    'accgameinfo' => $accgameinfo,
                    'recruiterinfo' => $recruiterinfo,
                    'recruiterdata' => $recruiterdata,
                    'premiuminfo' => $premiuminfo,
                    'server' => $server,
                    'ip' => $ip,
					'realminfos' => $realminfos]);
    }
	
	public function getserverstatus($realmid, $server) {      
		$fsck = @fsockopen(env('WORLD_'.strtoupper($server).'_HOST', ''), env('WORLD_PORT_'.strtoupper($server).'_'.$realmid, ''), $error_no, $error_str, 0.5);
		$status = $fsck ? 'online' : 'offline';
		@fclose($fsck);
		return $status;
    }
	
	public function getonlinecount($realmid, $server) {
	   if (!$this->ischaractersdbavailable($server, $realmid))
		   return 0;
	   
	   $online_count = DB::connection('mysql_'.$server.'_characters_'.$realmid)
		  ->select("SELECT COUNT(*) FROM `characters` WHERE `online` = 1");
	   $online_count = json_decode(json_encode($online_count),true);
	   
	   return $online_count[0]['COUNT(*)'];
    }
       
    public function setcookie(Request $request){
        $cookie = Cookie::forever('server', $request->input('server'));
        return back()->withCookie($cookie);
    }
	
	public function switchmodes(Request $request)
	{
	  if (session()->has('isDark')) {
          session()->put('isDark', !session('isDark'));
      }
      else {
          //provide an initial value of isDark
          session()->put('isDark', true);
      }
      return redirect()->back();
	}
}
