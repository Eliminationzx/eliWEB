<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use App\Providers\SoapClientExtendedProvider;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PremiumController extends Controller
{
    public function index() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $premiuminfo = $this->getpremiuminfo($server, $data);
        
        $userinfo = $this->getuserinfo($server, $data); 
         
        $price_day = Setting::where('key', 'premium_day')->first();
        $price_month = Setting::where('key', 'premium_month')->first();
        $price_year = Setting::where('key', 'premium_year')->first();     
                  
        return view('admin.premium.premium', [
            'data' => $data, 
            'premiuminfo' => $premiuminfo,
            'userinfo' => $userinfo,         
            'price_day' => $price_day, 
            'price_month' => $price_month,
            'price_year' => $price_year,
            'server' => $server
        ]);
    }
    
    public function insertpremiuminfo($server, $data, $setdata, $unsetdata, $type, $score) {
        $userid = $data['userid_'.$server];                       
        return DB::connection('mysql_'. $server .'_auth')
           ->insert("INSERT INTO account_premium ( id, setdate, unsetdate, premium_type, active, score) VALUES ('$userid', '$setdata', '$unsetdata', '$type', '1', $score)");    
    }
    
    public function updatepremiuminfo($server, $data, $unsetdata, $type, $score) {
        $userid = $data['userid_'.$server];              
        return DB::connection('mysql_'. $server .'_auth')
            ->update("UPDATE account_premium SET unsetdate = '$unsetdata', premium_type = '$type', score = '$score', active = '1' WHERE id = '$userid'");
    }
    
    public function sendpremiumitem(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
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
        
        if (empty($guid)) {
            return redirect()->route('premium')->with([
                'status' => 'You did not choose a character!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('premium')->with([
                'status' => 'Character not found!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);
         
        $reciver = $charinfo[0]['name']; 
        $realm_id = $charinfo[0]['realm_id'];
        $command ='send items ' .$reciver. ' "Online shop '. config('app.name_prj').'" "This book has a special power. Please use it wisely..." 9017:1';           
        $soapclient = new SoapClientExtendedProvider($server, $realm_id);        
        $soapclient->cmd($command);
        $soapmessages = $soapclient->getMessages();
        
        if (!$soapmessages) {
            return redirect()->route('premium')->with([
                    'status' => 'A special item has been successfully sent to the selected character.',
                    'type' => 'success',
                  ]
                );
        } else {
            return redirect()->route('premium')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }

    public function paypremium(Request $request) {      
        $data = $request->user();     
        $server = Cookie::get('server'); 

        if (!$this->isauthdbavailable($server) || !$this->servervalidation($server)) {
		    return redirect()->route('premium')->with([
                'status' => 'There is no connection to the database. Please, contact the administrator.',
                'type' => 'danger',
              ]
            );
        }
        
        $premium_data = $this->getpremiuminfo($server, $data);
        
        $price_day = Setting::where('key', 'premium_day')->first();
        $price_month = Setting::where('key', 'premium_month')->first();
        $price_year = Setting::where('key', 'premium_year')->first();
         
        $day = 84600;
        $month = $day * 30;
        $year = $month * 12;
        
        $setdata = time();
        $unsetdata = time();
        
        $score = 0;
        $premium_type = 1;       
        
        switch ($request->input('premium')) {
            case 'day': {
                if ($data->donate < $price_day->value) {
                    return redirect()->route('premium')->with(
                      [
                        'status' => 'You don\'t have enough money, top up your balance.',
                        'type' => 'danger',
                      ]
                    );
                }
                
                if (empty($premium_data[0])) {
                    $unsetdata = $unsetdata+$day;
                    $score = 1;                    
                    if ($this->insertpremiuminfo($server, $data, $setdata, $unsetdata, $premium_type, $score)) {
                        $data->donate = $data->donate-$price_day->value;
                        $data->save();
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Activation of premium status for the day (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);                     
                          
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status for the day has been successfully activated.',
                            'type' => 'success',
                          ]
                        );
                    } 
                }
                
                if ($premium_data[0]['unsetdate'] == 0) {
                    return redirect()->route('premium')->with(
                      [
                        'status' => 'You already have lifetime premium status activated.',
                        'type' => 'success',
                      ]
                    );
                }
                
                if ($premium_data[0]['active'] == 0) {
                    $unsetdata = $unsetdata+$day;
                    $score = $premium_data[0]['score'] + 1;
                    $premium_type = $premium_data[0]['premium_type'];
                    
                    if ($premium_type == 1 and $score >= 100)
                        $premium_type = 2;
                    elseif ($premium_type == 2 and $score >= 180)
                        $premium_type = 3;
                    
                    if ($this->updatepremiuminfo($server, $data, $unsetdata, $premium_type, $score)) {
                        $data->donate = $data->donate-$price_day->value;
                        $data->save(); 
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Activation of premium status for the day (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                        
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status has been successfully extended for a day.',
                            'type' => 'success',
                          ]
                        );
                    }
                }
                
                if ($premium_data[0]['unsetdate'] > $setdata AND $premium_data[0]['active'] == 1) {
                    $unsetdata = $premium_data[0]['unsetdate'] + $day;
                    $score = $premium_data[0]['score'] + 1;
                    $premium_type = $premium_data[0]['premium_type'];
                    
                    if ($premium_type == 1 and $score >= 100)
                        $premium_type = 2;
                    elseif ($premium_type == 2 and $score >= 180)
                        $premium_type = 3;
                        
                    if ($this->updatepremiuminfo($server, $data, $unsetdata, $premium_type, $score)) { 
                        $data->donate = $data->donate-$price_day->value;
                        $data->save();
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Extension of premium status by the day (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                        
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status has been successfully extended for a day.',
                            'type' => 'success',
                          ]
                        );
                    }
                }
                break;
            }
            case 'month': {
                if ($data->donate < $price_month->value) {
                    return redirect()->route('premium')->with(
                      [
                        'status' => 'You don\'t have enough money, top up your balance.',
                        'type' => 'danger',
                      ]
                    );
                }
                
                if (empty($premium_data[0])) {
                    $unsetdata = $unsetdata+$month;
                    $score = 30;                    
                    if ($this->insertpremiuminfo($server, $data, $setdata, $unsetdata, $premium_type, $score)) {
                        $data->donate = $data->donate-$price_month->value;
                        $data->save();
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Activation of premium status for the month (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                          
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'premium status for a month has been successfully activated.',
                            'type' => 'success',
                          ]
                        );
                    }
                }

                if ($premium_data[0]['unsetdate'] == 0) {                              
                    return redirect()->route('premium')->with(
                      [
                        'status' => 'You already have lifetime premium status activated.',
                        'type' => 'success',
                      ]
                    );
                }

                if ($premium_data[0]['active'] == 0) {
                    $score = $premium_data[0]['score'] + 30;                    
                    $unsetdata = $unsetdata+$month; 
                    $premium_type = $premium_data[0]['premium_type'];
                    
                    if ($premium_type == 1 and $score >= 100)
                        $premium_type = 2;
                    elseif ($premium_type == 2 and $score >= 180)
                        $premium_type = 3;
                    
                    if ($this->updatepremiuminfo($server, $data, $unsetdata, $premium_type, $score)) {
                        $data->donate = $data->donate-$price_month->value;
                        $data->save();
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Activation of premium status for the month (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                        
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status has been successfully extended for a day.',
                            'type' => 'success',
                          ]
                        );
                    }
                }

                if ($premium_data[0]['unsetdate'] > $setdata AND $premium_data[0]['active'] == 1) {  
                    $unsetdata = $premium_data[0]['unsetdate'] + $month;
                    $score = $premium_data[0]['score'] + 30;  
                    $premium_type = $premium_data[0]['premium_type'];
                    
                    if ($premium_type == 1 and $score >= 100)
                        $premium_type = 2;
                    elseif ($premium_type == 2 and $score >= 180)
                        $premium_type = 3;
                        
                    if ($this->updatepremiuminfo($server, $data, $unsetdata, $premium_type, $score)) { 
                        $data->donate = $data->donate-$price_month->value;
                        $data->save();
                    
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Extension of premium status by one month (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                        
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status has been successfully extended by a month.',
                            'type' => 'success',
                          ]
                        );
                    }
                }
                break;
            }
            case 'year': {
                if ($data->donate < $price_year->value) {
                    return redirect()->route('premium')->with(
                      [
                        'status' => 'You don\'t have enough money, top up your balance.',
                        'type' => 'danger',
                      ]
                    );
                }
                
                if (empty($premium_data[0])) {
                    $unsetdata = $unsetdata+$year;
                    $score = 360;                    
                    if ($this->insertpremiuminfo($server, $data, $setdata, $unsetdata, $premium_type, $score)) {
                        $data->donate = $data->donate-$price_year->value;
                        $data->save();
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Activation of premium status for the year (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                          
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status for the year has been successfully activated.',
                            'type' => 'success',
                          ]
                        );
                    } 
                }
                
                if ($premium_data[0]['unsetdate'] == 0) {
                    return redirect()->route('premium')->with(
                      [
                        'status' => 'You already have lifetime premium status activated.',
                        'type' => 'success',
                      ]
                    );
                }
                
                if ($premium_data[0]['active'] == 0) {
                    $unsetdata = $unsetdata+$year;
                    $score = $premium_data[0]['score'] + 360;
                    $premium_type = $premium_data[0]['premium_type'];
                    
                    if ($premium_type == 1 and $score >= 100)
                        $premium_type = 2;
                    elseif ($premium_type == 2 and $score >= 180)
                        $premium_type = 3;
                        
                    if ($this->updatepremiuminfo($server, $data, $unsetdata, $premium_type, $score)) {
                        $data->donate = $data->donate-$price_year->value;
                        $data->save(); 
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Activation of premium status for the year (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                        
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status has been successfully extended for a year.',
                            'type' => 'success',
                          ]
                        );
                    }
                }
                
                if ($premium_data[0]['unsetdate'] > $setdata AND $premium_data[0]['active'] == 1) {
                    $unsetdata = $premium_data[0]['unsetdate'] + $year;
                    $score = $premium_data[0]['score'] + 360;
                    $premium_type = $premium_data[0]['premium_type'];
                    
                    if ($premium_type == 1 and $score >= 100)
                        $premium_type = 2;
                    elseif ($premium_type == 2 and $score >= 180)
                        $premium_type = 3;
                    
                    if ($this->updatepremiuminfo($server, $data, $unsetdata, $premium_type, $score)) { 
                        $data->donate = $data->donate-$price_year->value;
                        $data->save();
                        
                        $history['userid'] = $data->id;
                        $history['comment'] = 'Extension of premium status by one year (' .strtoupper($server). ')';
                        $history['type'] = 'premium';
                        $history['ip'] = $request->ip();
                        $this->sethistory($history);
                        
                        return redirect()->route('premium')->with(
                          [
                            'status' => 'Premium status has been successfully extended for a year.',
                            'type' => 'success',
                          ]
                        );
                    }
                }
                break;
            }
            default:
               break;
        }
    }
}
