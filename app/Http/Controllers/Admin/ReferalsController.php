<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\History;
use App\Referal;
use App\Setting;
use App\Http\Controllers\Controller;
use DB;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ReferalsController extends Controller
{
    public function index(){
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $referalsinfo = $this->getreferalsinfo($server, $data);   
        $reward = Setting::where('key', 'referal_complete')->first();

        if($referalsinfo){
            foreach ($referalsinfo as $referals) {                  
                if($referals['complete'] == TRUE)
                   $this->proceed($server, $data, $referals, $reward);
            }
        }  
        
        return view('admin.referals.referals', ['server' => $server, 'data' => $data, 'referalsinfo' => $referalsinfo, 'reward' => $reward]);
    }
    
    public function proceed($server, $data, $referals, $reward) {
        $usercomplete = User::where('name', $referals['names'])->first();                   
        $usercheck = $this->checkreferalcomplete($server, $usercomplete);
                    
        if($usercheck->payment == 0) {
            $data->donate = $data->donate + $reward->value;
            $data->save();

            $history['userid'] = $data->id;
            $history['comment'] = 'Charging bonuses for an invited player ' . $referals['names'];
            $history['type'] = 'rewards';
            $history['ip'] = \Request::ip();
            $this->sethistory($history);
            
            $usercheck->payment = 1;
            $usercheck->save();
        }
    }
    
    public function checkreferalcomplete($server, $usercomplete) {
        return Referal::where('userid_'.$server, $usercomplete['userid_'.$server])->first();
    }
    
    public function getreferalsinfo($server, $data) {
        $referalsinfo = Cache::get('referalsinfo+'.$server.'+userid='.$data->id);
        
        $referals = Referal::where('referalid', $data->id)->get();

        if (!$referalsinfo) {           
            $i = 0;
            $filtered_array = null;
            
            foreach ($referals as $referal){                  
                $userdata = User::where('userid_'.$server, $referal['userid_'.$server])->first();                            
                $userinfo = $this->getuserinfo($server, $userdata);			
				if ($userinfo == null)
					continue;
                
                $filtered_array = array_filter($userinfo, function($obj) use ($server) {
                    $totaltime = 3600 * 12;                       
                    return $obj->level == $obj->realm_maxlvl and $obj->totaltime >= $totaltime;
                });                
                            
                $referalsinfo[$i] = array(
                  'userinfo' => $userinfo,                        
                  'names' => $userdata->name,
                  'complete' => $filtered_array != null ? TRUE : FALSE,                      
                );
                        
                $i++;
            }
            
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('referalsinfo+'.$server.'+userid='.$data->id, $referalsinfo, $cachelifetime);
        }
                   
        return $referalsinfo;
    }        
}
