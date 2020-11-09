<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use DB;
use App\Providers\SoapClientExtendedProvider;

class CharactersController extends Controller
{
    public function race() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        $price = Setting::where('key', 'race')->first();
        $accgameinfo = $this->getgameaccountinfo($server, $data);
        $recruiterinfo = null;
		
		if (!empty($accgameinfo)) {			
			$recruiterid = $accgameinfo[0]['recruiter'];             
			$recruiterdata = User::where('userid_'.$server, $recruiterid)->first();
            if ($recruiterdata)			
				$recruiterinfo = $this->getuserinfo($server, $recruiterdata); 
		}
        
        return view('admin.character.race',
          ['data' => $data, 'userinfo' => $userinfo, 'price' => $price, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'server' => $server]);
    }

    public function changerace(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        $price = Setting::where('key', 'race')->first();
		
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
        
        if ($data->donate < $price->value) {
            return redirect()->route('characters.race')->with([
                'status' => 'No hay suficientes fondos en su cuenta, ¡recargue su saldo!',
                'type' => 'danger',
              ]
            );
        }

        if (empty($guid)) {
            return redirect()->route('characters.race')->with([
                'status' => '¡No elegiste un personaje!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('characters.race')->with([
                'status' => '¡Personaje no encontrado!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);
        
        $command ='char changerace ' .$charinfo[0]['name'];           
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);
        $soapmessages = $soapclient->getMessages();

        if (!$soapmessages){
            $data->donate = $data->donate - $price->value;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Comprar un cambio de raza para un personaje ' . $charinfo[0]['name'] . '(' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ') por ' . $price->value . ' D';
            $history['type'] = 'payment';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('characters.race')->with([
                'status' => 'La función de cambio de raza se ha activado con éxito, ¡mira la selección de personajes!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('characters.race')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }
    
    public function faction() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        $price = Setting::where('key', 'faction')->first();
        $accgameinfo = $this->getgameaccountinfo($server, $data);
        $recruiterinfo = null;
		
		if (!empty($accgameinfo)) {	
			$recruiterid = $accgameinfo[0]['recruiter'];             
			$recruiterdata = User::where('userid_'.$server, $recruiterid)->first();
		    if ($recruiterdata)
				$recruiterinfo = $this->getuserinfo($server, $recruiterdata); 
        }
		
        return view('admin.character.faction',
          ['data' => $data, 'userinfo' => $userinfo, 'price' => $price, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'server' => $server]);
    }

    public function changefaction(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        $price = Setting::where('key', 'faction')->first();
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

        if ($data->donate < $price->value) {
            return redirect()->route('characters.faction')->with([
                'status' => 'No hay suficientes fondos en su cuenta, ¡recargue su saldo!',
                'type' => 'danger',
              ]
            );
        }

        if (empty($guid)) {
            return redirect()->route('characters.faction')->with([
                'status' => '¡No elegiste un personaje!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('characters.faction')->with([
                'status' => '¡Personaje no encontrado!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);
        
        $command ='char changefaction ' .$charinfo[0]['name'];  
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);      
        $soapmessages = $soapclient->getMessages();
        
        if (!$soapmessages){
            $data->donate = $data->donate - $price->value;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Comprar un cambio de facción para un personaje ' . $charinfo[0]['name'] . '(' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ') por ' . $price->value . ' D';
            $history['type'] = 'payment';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('characters.faction')->with([
                'status' => 'La función de cambio de facción se ha activado con éxito, ¡mira la selección de personajes!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('characters.faction')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }

    public function name() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        $price = Setting::where('key', 'name')->first();
        $accgameinfo = $this->getgameaccountinfo($server, $data);
        $recruiterinfo = null;
		
		if (!empty($accgameinfo)) {
			$recruiterid = $accgameinfo[0]['recruiter'];             
			$recruiterdata = User::where('userid_'.$server, $recruiterid)->first();
			if ($recruiterdata)
				$recruiterinfo = $this->getuserinfo($server, $recruiterdata) ; 
		}
        
        return view('admin.character.name',
          ['data' => $data, 'userinfo' => $userinfo, 'price' => $price, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'server' => $server]);
    }

    public function changename(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        $price = Setting::where('key', 'name')->first();
		
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

        if ($data->donate < $price->value) {
            return redirect()->route('characters.name')->with([
                'status' => 'No hay suficientes fondos en su cuenta, ¡recargue su saldo!',
                'type' => 'danger',
              ]
            );
        }

        if (empty($guid)) {
            return redirect()->route('characters.name')->with([
                'status' => '¡No elegiste un personaje!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('characters.name')->with([
                'status' => '¡Personaje no encontrado!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);
        
        $command ='char rename ' .$charinfo[0]['name'];           
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);      
        $soapmessages = $soapclient->getMessages();
        
        if (!$soapmessages){
            $data->donate = $data->donate - $price->value;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Comprar un cambio de nombre para un personaje ' . $charinfo[0]['name'] . '(' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ') por ' . $price->value . ' D';
            $history['type'] = 'payment';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('characters.name')->with([
                'status' => 'La función de cambio de nombre se ha activado correctamente, ¡mira la selección de personajes!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('characters.name')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }
    
    public function repair() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        $accgameinfo = $this->getgameaccountinfo($server, $data);
        $recruiterinfo = null;
		
		if (!empty($accgameinfo)) {
			$recruiterid = $accgameinfo[0]['recruiter'];             
			$recruiterdata = User::where('userid_'.$server, $recruiterid)->first();
            if ($recruiterdata)			
				$recruiterinfo = $this->getuserinfo($server, $recruiterdata); 
        }
		
        return view('admin.character.repair',
          ['data' => $data, 'userinfo' => $userinfo, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'server' => $server]);
    }

    public function dorepair(Request $request) {
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
            return redirect()->route('characters.repair')->with([
                'status' => '¡No elegiste un personaje!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('characters.repair')->with([
                'status' => '¡Personaje no encontrado!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);

        $command ='unstuck ' .$charinfo[0]['name'].' inn';           
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);      
        $soapmessages = $soapclient->getMessages();
         
        if (!$soapmessages){         
            $history['userid'] = $data->id;
            $history['comment'] = 'Personaje de reparación ' . $charinfo[0]['name'] . '(' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ')';
            $history['type'] = 'repair';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('characters.repair')->with([
                'status' => '¡Reparamos con éxito al personaje y lo enviamos a la taberna!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('characters.repair')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }
    
    public function restore() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $deletedcharinfo = $this->getdeletedcharactersinfo($server, $data);
		
        return view('admin.character.restore',
          ['data' => $data, 'deletedcharinfo' => $deletedcharinfo, 'server' => $server]);
    }

    public function dorestore(Request $request) {
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
            return redirect()->route('characters.restore')->with([
                'status' => '¡No elegiste un personaje!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = $this->getcharinfo($server, $guid, $realmid);
        if (empty($charinfo)) {
            return redirect()->route('characters.restore')->with([
                'status' => '¡Personaje no encontrado!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);

        $command ='character deleted restore ' .$charinfo[0]['name'].' ';           
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);      
        $soapmessages = $soapclient->getMessages();
         
        if (!$soapmessages){         
            $history['userid'] = $data->id;
            $history['comment'] = 'Character restoration ' . $charinfo[0]['name'] . '(' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ')';
            $history['type'] = 'restore';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('characters.restore')->with([
                'status' => 'The character has been successfully restored!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('characters.restore')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }
}
