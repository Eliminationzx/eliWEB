<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use App\Providers\SoapClientExtendedProvider;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CurrencyController extends Controller
{
    public function gold() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        $price = Setting::where('key','gold')->first();
        $accgameinfo = $this->getgameaccountinfo($server, $data);
        $recruiterinfo = null;
		
		if (!empty($accgameinfo)) {
			$recruiterid = $accgameinfo[0]['recruiter'];             
			$recruiterdata = User::where('userid_'.$server, $recruiterid)->first();
			if ($recruiterdata)
				$recruiterinfo = $this->getuserinfo($server, $recruiterdata); 
		}
        
        return view('admin.currency.gold', ['data' => $data, 'userinfo' => $userinfo, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'price' => $price, 'server' => $server]);
    }

    public function buygold(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');    
        $cur_count = $request->input('cur_count');
		
        $guidorrealmid = explode(',', $request->input('guid'));
		if (empty($guidorrealmid) OR count($guidorrealmid) < 2) {
			$guid = null;
			$realmid = null;
		} else {			
			$guid = $guidorrealmid[0];
			$realmid = $guidorrealmid[1];
		}
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $price = Setting::where('key','gold')->first(); 
        
        if(empty($cur_count)){
            return redirect()->route('currency.gold')->with([
                'status' => 'Enter the amount of gold!',
                'type' => 'danger',
              ]
            );
        }

        if(empty($guid)){
            return redirect()->route('currency.gold')->with([
                'status' => 'You did not choose a character!',
                'type' => 'danger',
              ]
            );
        }
        
        $totalprice_gold = $price->value * $cur_count;
        $totalprice_gold = ceil($totalprice_gold);
    
        if($data->donate < $totalprice_gold){
            return redirect()->route('currency.gold')->with([
                'status' => 'There are not enough funds in your account, top up your balance!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('currency.gold')->with([
                'status' => 'Character not found!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo),true);
        
        $reciver = $charinfo[0]['name'];
        $gold_converted = $cur_count * 10000;
        $command = 'send money ' .$reciver. ' "Your order at the online store '.config('app.name_prj').'" "Thank you for buying!" ' .$gold_converted;    
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);      
        $soapmessages = $soapclient->getMessages();
        
        if (!$soapmessages){
            $data->donate = $data->donate - $totalprice_gold;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Buying gold to a character ' .$charinfo[0]['name']. '(' . strtoupper ($server) . ' / ' .$charinfo[0]['realm_name']. ') for ' .$totalprice_gold. ' D';
            $history['type'] = 'payment';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('currency.gold')->with([
                'status' => 'Purchase is successfully completed, the gold is sent to the mail of the selected character!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('currency.gold')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }           
    }

    public function ether() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        $price = Setting::where('key','ether')->first();
        $accgameinfo = $this->getgameaccountinfo($server, $data);
		$recruiterinfo = null;
        
		if (!empty($accgameinfo)) {
			$recruiterid = $accgameinfo[0]['recruiter'];             
			$recruiterdata = User::where('userid_'.$server, $recruiterid)->first();   
			if ($recruiterdata)
				$recruiterinfo = $this->getuserinfo($server, $recruiterdata); 
		}
        
        return view('admin.currency.ether', ['data' => $data, 'userinfo' => $userinfo, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'price' => $price, 'server' => $server]);
    }

    public function buyether(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        $cur_count = $request->input('cur_count');
		
        $guidorrealmid = explode(',', $request->input('guid'));
		if (empty($guidorrealmid) OR count($guidorrealmid) < 2) {
			$guid = null;
			$realmid = null;
		} else {			
			$guid = $guidorrealmid[0];
			$realmid = $guidorrealmid[1];
		}
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $price = Setting::where('key','ether')->first(); 
        
        if(empty($cur_count)){
            return redirect()->route('currency.ether')->with([
                'status' => 'Enter the number of etherial coins!',
                'type' => 'danger',
              ]
            );
        }

        if(empty($guid)){
            return redirect()->route('currency.ether')->with([
                'status' => 'You did not choose a character!',
                'type' => 'danger',
              ]
            );
        }
        
        $totalprice_ether = $price->value * $cur_count;
        $totalprice_ether = ceil($totalprice_ether);
    
        if($data->donate < $totalprice_ether){
            return redirect()->route('currency.ether')->with([
                'status' => 'There are not enough funds in your account, top up your balance!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('currency.ether')->with([
                'status' => 'Character not found!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo),true);
        
        $reciver = $charinfo[0]['name'];
        $cur_id = 38186;
        $command = 'send items ' . $reciver . ' "Your order at the online store '.config('app.name_prj').'" "Thank you for buying!" ' .$cur_id. ':'. $cur_count .'';    
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);      
        $soapmessages = $soapclient->getMessages();
        
        if (!$soapmessages){
            $data->donate = $data->donate - $totalprice_ether;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Buying ethereal coins character ' .$charinfo[0]['name']. '(' . strtoupper ($server) . ' / ' .$charinfo[0]['realm_name']. ') for ' .$totalprice_ether. ' D';
            $history['type'] = 'payment';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('ether')->with([
                'status' => 'Purchase is successfully completed, air coins sent to the mail of the selected character!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('currency.ether')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }           
    }
}
