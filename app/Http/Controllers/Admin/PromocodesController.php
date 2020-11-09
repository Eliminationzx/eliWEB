<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Promo_code;
use App\Promo_log;
use App\Promo_type;
use App\Providers\SoapClientExtendedProvider;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PromocodesController extends Controller
{
    public function index(){
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $userinfo = $this->getuserinfo($server, $data);
        
        return view('admin.account.promo', ['data' => $data, 'userinfo' => $userinfo]);
    }
    
    public function usepromocode(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $code = $request->input('promocode');
        
        $current_time = time();
        
        $promocode = Promo_code::where([['code', '=' , $code], ['server', '=', $server]])->first();
            
        if (empty($promocode)) {
            return redirect()->route('promocodes')->with([
                'status' => 'The promo code is incorrect or does not exist!',
                'type' => 'danger',
              ]
            );
        }
        
        if ($promocode->usage_count == 0) {
            return redirect()->route('promocodes')->with([
                'status' => 'Promocode expended!',
                'type' => 'danger',
              ]
            ); 
        }
        
        if ($promocode->unused_date > 0 AND $promocode->unused_date < $current_time) {
            return redirect()->route('promocodes')->with([
                'status' => 'The promotional code has expired!',
                'type' => 'danger',
              ]
            ); 
        }
        
        if ($this->ispromocodeused($promocode->id, $data->id)) {
            return redirect()->route('promocodes')->with([
                'status' => 'You have already used this promo code!',
                'type' => 'danger',
              ]
            ); 
        }       
        
        $guid = $request->input('guid');
        
        if (empty($guid)) {
            return redirect()->route('promocodes')->with([
                'status' => 'You did not choose a character!',
                'type' => 'danger',
              ]
            );
        }
        
        $charinfo = $this->getcharinfo($server, $guid, $promocode->realmid);
        
        if (empty($charinfo)) {
            return redirect()->route('promocodes')->with([
                'status' => 'The character is not found or does not meet the conditions for activating the promotion code!',
                'type' => 'danger',
              ]
            ); 
        }
        
        $charinfo = json_decode(json_encode($charinfo), true);      
        $command = null;
        
        $type = Promo_type::where('id', $promocode->typeid)->first();     
        switch ($type->name) {
            case 'gold': {
               $reciver = $charinfo[0]['name'];
               $gold_converted = $promocode->data0 * 10000;
               $command = 'send money ' .$reciver. ' "Activation of promotional code '.config('app.name_prj').'" "You activated the promotional code on '.$promocode->data0. ' gold coins!" ' .$gold_converted;    
               break;
            }
            case 'currency':
            case 'item': {
               $reciver = $charinfo[0]['name'];
               $item_id = $promocode->data0;
               $item_count = $promocode->data1;
               $realmid = $charinfo[0]['realm_id'];
               $item_name = $this->getitemname($server, $realmid, $item_id);
               $command = 'send items ' . $reciver . ' "Activation of promotional code '.config('app.name_prj').'" "You activated the promotional code for '.$item_name.'" ' .$item_id. ':'. $item_count .'';
               break;
            }
            default: {
                return redirect()->route('promocodes')->with([
                    'status' => 'Unknown type of promo code!',
                    'type' => 'danger',
                  ]
                );
            }                
        }
         
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);
        $soapmessages = $soapclient->getMessages();

        if (!$soapmessages){           
            if ($promocode->usage_count > 0) {
                $promocode->usage_count = $promocode->usage_count - 1;
                $promocode->save();
            }
            
            $promolog = new Promo_log();
            $promolog->userid = $data->id;
            $promolog->codeid = $promocode->id;
            $promolog->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Activation of promotional code '.$promocode->code.' for character ' . $charinfo[0]['name'] . '(' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ')';
            $history['type'] = 'promocodes';
            $history['ip'] = $request->ip();
            $this->sethistory($history);           
            
            return redirect()->route('promocodes')->with([
                'status' => 'Promo code '.$promocode->code.' successfully activated!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('promocodes')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }
    
   public function getitemname($server, $realmid, $itemid) {
        $item_template = DB::connection('mysql_'.$server.'_world_'.$realmid)
                        ->select("SELECT name FROM item_template 
                        WHERE entry = '$itemid'");
            
        $item_template = json_decode(json_encode($item_template), true);
        return $item_template[0]['name'];               
    }
    
    public function ispromocodeused($codeid, $userid) {
        return Promo_log::where([['userid', '=', $userid],['codeid', '=', $codeid]])->first() !== null;
    }
}
