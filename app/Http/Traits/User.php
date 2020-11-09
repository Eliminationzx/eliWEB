<?php
namespace App\Http\Traits;
use App\History;
use App\Realms;
use App\Armory_races;
use App\Armory_classes;
use Illuminate\Support\Facades\Cookie;
use DB;
use Cache;
use Carbon\Carbon;

trait user{

    public function getuserinfo($server, $data, $realmid = 0){
        $userinfo = null;
        
        if ($realmid > 0) {
            $userinfo = Cache::get('userinfo+'.$server.'realmid+'.$realmid.'+userid='.$data->id);   
                   
            if (!$userinfo AND $this->ischaractersdbavailable($server, $realmid)) {          
                $realminfo = Realms::where([
                  ['server', '=', $server],
                  ['realmid', '=', $realmid],
                ])->first();
                $userid = $data['userid_'.$server];
            
                $userinfo = DB::connection('mysql_'.$server.'_characters_'.$realminfo->realmid)
                    ->select('SELECT * FROM characters WHERE account = ? AND deleteInfos_Account IS NULL', array($userid));                           
                                                                     
                foreach($userinfo as &$userinfos) {
                    $userinfos->{'realm_id'} = $realminfo->realmid;
                    $userinfos->{'realm_name'} = $realminfo->name;
                    $userinfos->{'realm_maxlvl'} = $realminfo->maxlvl;
                    $raceinfo = Armory_races::find($userinfos->race);
                    $userinfos->{'race_name'} = $raceinfo != null ? $raceinfo->name : 'unknown';
                    $userinfos->{'factionid'} = $raceinfo != null ? $raceinfo->factionid : -1;
                    $classinfo = Armory_classes::find($userinfos->class);
                    $userinfos->{'class_name'} = $classinfo != null ? $classinfo->name : 'unknown';
                    $userinfos->{'play_time'} = $this->getplaytime($userinfos->totaltime);
                }               

                $cachelifetime = Carbon::now()->addMinutes(5); 
                Cache::put('userinfo+'.$server.'realmid+'.$realmid.'+userid='.$data->id, $userinfo, $cachelifetime);
            }
        }
        else {          
            $userinfo = Cache::get('userinfo+'.$server.'+userid='.$data->id);   
                   
            if (!$userinfo) {          
                $realminfo = Realms::where('server', $server)->get();    
                $userid = $data['userid_'.$server];
            
                foreach ($realminfo as $realminfos) {
					if (!$this->ischaractersdbavailable($server, $realminfos->realmid))
						continue;
					
                    $userinfo_tmp = DB::connection('mysql_'.$server.'_characters_'.$realminfos->realmid)
                          ->select('SELECT * FROM characters WHERE account = ? AND deleteInfos_Account IS NULL', array($userid));                           
                                                                     
                    foreach($userinfo_tmp as &$userinfos) {
                        $userinfos->{'realm_id'} = $realminfos->realmid;
                        $userinfos->{'realm_name'} = $realminfos->name;
                        $userinfos->{'realm_maxlvl'} = $realminfos->maxlvl;
                        $raceinfo = Armory_races::find($userinfos->race);
                        $userinfos->{'race_name'} = $raceinfo != null ? $raceinfo->name : 'unknown';
                        $userinfos->{'factionid'} =  $raceinfo != null ? $raceinfo->factionid : -1;
                        $classinfo = Armory_classes::find($userinfos->class);
                        $userinfos->{'class_name'} = $classinfo != null ? $classinfo->name : 'unknown';
                        $userinfos->{'play_time'} = $this->getplaytime($userinfos->totaltime);
                    }               
                    
                    if (!$userinfo)  
                        $userinfo = $userinfo_tmp;
                    else
                        $userinfo = array_merge_recursive($userinfo, $userinfo_tmp);
                }
         
                $cachelifetime = Carbon::now()->addMinutes(5); 
                Cache::put('userinfo+'.$server.'+userid='.$data->id, $userinfo, $cachelifetime);
            }
        }
        return $userinfo;
    }
    
    public function getdeletedcharactersinfo($server, $data) {  
        $charinfo = Cache::get('deletedcharactersinfo+'.$server.'+userid='.$data->id);  
                 
        if (!$charinfo) {
            $realminfo = Realms::where('server', $server)->get();    
            $userid = $data['userid_'.$server];
                
            foreach ($realminfo as $realminfos) {
                if (!$this->ischaractersdbavailable($server, $realminfos->realmid))
                    continue;
                
                $charinfo_tmp = DB::connection('mysql_'.$server.'_characters_'.$realminfos->realmid)
                          ->select('SELECT * FROM characters WHERE deleteInfos_Account = ?', array($userid));   
                          
                foreach($charinfo_tmp as &$charinfos) {
                    $charinfos->{'realm_id'} = $realminfos->realmid;
                    $charinfos->{'realm_name'} = $realminfos->name;
                    $charinfos->{'realm_maxlvl'} = $realminfos->maxlvl;
                    $raceinfo = Armory_races::find($charinfos->race);
                    $charinfos->{'race_name'} = $raceinfo != null ? $raceinfo->name : 'unknown';
                    $charinfos->{'factionid'} =  $raceinfo != null ? $raceinfo->factionid : -1;
                    $classinfo = Armory_classes::find($charinfos->class);
                    $charinfos->{'class_name'} = $classinfo != null ? $classinfo->name : 'unknown';
                    $charinfos->{'play_time'} = $this->getplaytime($charinfos->totaltime);
                }
                
                if (!$charinfo)
                    $charinfo = $charinfo_tmp;
                else
                    $charinfo = array_merge_recursive($charinfo, $charinfo_tmp);
            }
    
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('deletedcharactersinfo+'.$server.'+userid='.$data->id, $charinfo, $cachelifetime);
        }
        return $charinfo;
    }
    
    public function getcharinfo($server, $guid, $realmid){		
        $charinfo = Cache::get('charinfo+'.$server.'realmid+'.$realmid.'+guid='.$guid);  
                 
        if (!$charinfo AND $this->ischaractersdbavailable($server, $realmid)) {
            $realminfo = Realms::where([
              ['server', '=', $server],
              ['realmid', '=', $realmid],
            ])->first();         
           
            $charinfo = DB::connection('mysql_'.$server.'_characters_'.$realminfo->realmid)
                  ->select('SELECT * FROM characters WHERE guid = ? AND deleteInfos_Account IS NULL', array($guid));   

            foreach($charinfo as &$charinfos) {
                $charinfos->{'realm_id'} = $realminfo->realmid;
                $charinfos->{'realm_name'} = $realminfo->name;
                $charinfos->{'realm_maxlvl'} = $realminfo->maxlvl;
                $raceinfo = Armory_races::find($charinfos->race);
                $charinfos->{'race_name'} = $raceinfo != null ? $raceinfo->name : 'unknown';
                $charinfos->{'factionid'} =  $raceinfo != null ? $raceinfo->factionid : -1;
                $classinfo = Armory_classes::find($charinfos->class);
                $charinfos->{'class_name'} = $classinfo != null ? $classinfo->name : 'unknown';
                $charinfos->{'play_time'} = $this->getplaytime($charinfos->totaltime);
            } 
              
           $cachelifetime = Carbon::now()->addMinutes(5); 
           Cache::put('charinfo+'.$server.'realmid+'.$realminfo->realmid.'+guid='.$guid, $charinfo, $cachelifetime);
        }
        return $charinfo;
    }
    
  
    public function sethistory($data){      
        $history = new History();
        $history->userid = $data['userid'];
        $history->comment = $data['comment'];
        $history->type = $data['type'];
        $history->ip = $data['ip'];
        $history->save();
    }
    
    public function getpremiuminfo($server, $data) { 
		if (!$this->isauthdbavailable($server))
			return null;	
		
        $userid = $data['userid_'.$server];
        $premiuminfo = DB::connection('mysql_'. $server .'_auth')->select('SELECT * FROM account_premium WHERE id = ?', array($userid));
        $premiuminfo = json_decode(json_encode($premiuminfo), true);
        return $premiuminfo;
    }
    
    public function ispremium($server, $data) {
		if (!$this->isauthdbavailable($server))
			return false;
		
        $userid = $data['userid_'.$server];
        $premiuminfo = DB::connection('mysql_'. $server .'_auth')->select('SELECT * FROM account_premium WHERE id = ?', array($userid));
        $premiuminfo = json_decode(json_encode($premiuminfo), true);
        return $premiuminfo != null AND $premiuminfo[0]['active'] == 1;
    }
    
    public function getgameaccountinfo($server, $data) {
		
        $gameaccinfo = Cache::get('gameaccinfo+'.$server.'+userid='.$data->id); 
                 
        if (!$gameaccinfo AND $this->isauthdbavailable($server)) {          
            $userid = $data['userid_'.$server];
            $email = $data['email'];
            
            $gameaccinfo = DB::connection('mysql_'.$server.'_auth')
                  ->select('SELECT * FROM account WHERE id = ? AND email = ?', array($userid, $email));
            $gameaccinfo = json_decode(json_encode($gameaccinfo), true);             
                
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('gameaccinfo+'.$server.'+userid='.$data->id, $gameaccinfo, $cachelifetime);
        }
        
        return $gameaccinfo;
    }  
	
	public function getaccountbaninfo($server, $data) {
        $accountbaninfo = Cache::get('accountbaninfo+userid='. $data->id .'+server='. $server);    

        if (!$accountbaninfo AND $this->isauthdbavailable($server)) {
            $userid = $data['userid_'.$server];
            
            $accountbaninfo = DB::connection('mysql_'. $server .'_auth')->select("SELECT * FROM account_banned WHERE id = '$userid'"); 
            $accountbaninfo = json_decode(json_encode($accountbaninfo), true);
            
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('accountbaninfo+userid='. $data->id .'+server='. $server, $accountbaninfo, $cachelifetime);
        }
             
        return $accountbaninfo;
    }
    
    public function getipbaninfo($server, $ip) {
        $ipbaninfo = Cache::get('ipbaninfo+ip='. $ip .'+server='. $server); 
         
        if (!$ipbaninfo AND $this->isauthdbavailable($server)) {
            $ipbaninfo = DB::connection('mysql_'. $server .'_auth')->select("SELECT * FROM ip_banned WHERE ip = '$ip'"); 
            $ipbaninfo = json_decode(json_encode($ipbaninfo), true);
            
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('ipbaninfo+ip='. $ip .'+server='. $server, $ipbaninfo, $cachelifetime);
        }
             
        return $ipbaninfo;
    }
}