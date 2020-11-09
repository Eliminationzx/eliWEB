<?php
namespace App\Http\Traits;
use App\Setting;
use App\Realms;
use DB;
use Cache;
use Carbon\Carbon;

trait sitesettings{

	public function isdbavailable($server, $db, $realmid = 0) {
        $state = $realmid > 0 ? env('DB_'.strtoupper($server).'_'.strtoupper($db).'_'.$realmid.'_STATE') : env('DB_'.strtoupper($server).'_'.strtoupper($db).'_STATE');	
		return $state == 1;
	}
	
	public function isauthdbsavailable() {
		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
		foreach ($servers as $server) {
			if (!$this->isdbavailable($server, 'auth'))
				return false;
		}
		return true;
	}
	
	public function ischaractersdbsavailable() {
		$servers = explode(',', env('APP_GAME_SERVER_LIST'));
		foreach ($servers as $server) {
			$realminfos = Realms::where('server', $server)->get();    
            foreach ($realminfos as $realminfo) {
				if (!$this->isdbavailable($server, 'characters', $realminfo->realmid))
					return false;		
			}
		}
		return true;
	}
	
	public function hasbattlenet($server) {
		switch ($server) {
			case 'legion':
			case 'wod':
			case 'bfa':
				return true;
		}
		return false;
	}
	
	public function ischaractersdbavailable($server, $realmid) {
		return $this->isdbavailable($server, 'characters', $realmid);
	}
	
	public function isauthdbavailable($server) {
		return $this->isdbavailable($server, 'auth');
	}
	
	public function isworlddbavailable($server, $realmid) {
		return $this->isdbavailable($server, 'world', $realmid);
	}
	
	    public function getplaytime($u_time) {
        return $this->convertunixtime($u_time);
    }
    
    public function getsumplaytime($data) {
        $u_time = 0;
        foreach ($data as $datainfo) {
            $u_time += $datainfo->totaltime;
        }
        
        return $this->convertunixtime($u_time);
    }
    
    public function convertunixtime($u_time) {
        $days = floor($u_time / (24*60*60));
        $hours = floor(($u_time - ($days*24*60*60)) / (60*60));
        $minutes = floor(($u_time - ($days*24*60*60)-($hours*60*60)) / 60);
        $seconds = ($u_time - ($days*24*60*60) - ($hours*60*60) - ($minutes*60)) % 60;
        $timestr = $days.'d '.$hours.'h '.$minutes.'m '.$seconds.'s';
        return $timestr;
    }
    
    public function servervalidation($server) {
        return in_array($server, explode(',', env('APP_GAME_SERVER_LIST')));
    }  
}