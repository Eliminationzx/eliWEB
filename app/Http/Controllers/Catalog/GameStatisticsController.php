<?php

namespace App\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Realms;
use Carbon\Carbon;
use Cookie;
use Mail;
use DB;
use Cache;

class GameStatisticsController extends Controller
{
    public function getserverinfo($server) {           
        $realminfo = Cache::get('realminfo+gamestatistic+'.$server);   
        
        if (!$realminfo) {
            
            $realminfo = Realms::where('server', $server)->get();
            
            foreach ($realminfo as &$realminfos) {           
                $realminfos->{ 'online' } = $this->getonlinecount($realminfos->realmid, $realminfos->server);
                $realminfos->{ 'status' } = $this->getserverstatus($realminfos->realmid, $realminfos->server);
            }
            
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('realminfo+gamestatistic+'.$server, $realminfo, $cachelifetime);
        }
        
        return $realminfo;
    }
    
    public function getserverinfos() {          
        $realminfo = Cache::get('realminfo+gamestatistic');   
        
        if (!$realminfo) {          
            $servers = explode(',', env('APP_GAME_SERVER_LIST'));

            foreach ($servers as $server) {                
                $realminfo_tmp = Realms::where('server', $server)->get()->ToArray();
                
                foreach ($realminfo_tmp as &$realminfos) {           
                    $realminfos['online'] = $this->getonlinecount($realminfos['realmid'], $realminfos['server']);
                    $realminfos['status'] = $this->getserverstatus($realminfos['realmid'], $realminfos['server']);
                }
                
                if (!$realminfo)
                    $realminfo = $realminfo_tmp;
                else 
                    $realminfo = array_merge_recursive($realminfo, $realminfo_tmp);
            }
            
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('realminfo+gamestatistic', $realminfo, $cachelifetime);
        }
        
        return $realminfo;
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
}
