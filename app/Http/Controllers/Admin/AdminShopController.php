<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Shop_category;
use App\Shop_item;
use App\Providers\SoapClientExtendedProvider;
use App\Realms;
use App\Armory_itemicons;
use App\Armory_itemclasses;
use App\Armory_itemsubclasses;
use App\Armory_itemqualities;
use App\Armory_iteminvtypes;
use App\Armory_itembondings;
use App\Armory_itemstats;
use App\Armory_skill_lines;
use App\Armory_spells;
use App\Armory_classes;
use App\Armory_races;
use App\Setting;
use DB;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminShopController extends Controller
{
    public function index() {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
                                                   
        $shopcategories = Shop_category::where('server', $server)->get();
        
        foreach($shopcategories as &$shopcategory) {
                $shopcategory->{'item_count'} = $this->getcategoryitemcount($shopcategory->id, $shopcategory->server);
        }    
              
        $shopitems = Shop_item::where([
              ['server', '=', $server],
            ])->orderBy('created_at', 'ASC')->take(10)->get();
                                   
        foreach($shopitems as &$shopitem) {
            $shopitem->{'realm_name'} = $this->getitemrealmname($shopitem->server, $shopitem->realmid);
            
            $item_template = $this->getitemtemplate($shopitem->server, $shopitem->realmid, $shopitem->itemid);
            
            $shopitem->{'icon'} = $this->getitemiconbydisplayid(empty($item_template) ? -1 : $item_template[0]['displayid']);
            $shopitem->{'quality'} = $this->getitemquality(empty($item_template) ? -1 : $item_template[0]['Quality']);
            $shopitem->{'class'} = $this->getitemclass(empty($item_template) ? -1 : $item_template[0]['class']);
            $shopitem->{'skill'} = $this->getitemskillrequired(empty($item_template) ? -1 : $item_template[0]['RequiredSkill']);
            $shopitem->{'invtype'} = $this->getiteminvtype(empty($item_template) ? -1 : $item_template[0]['InventoryType']);
            $shopitem->{'bonding'} = $this->getitembonding(empty($item_template) ? -1 : $item_template[0]['bonding']);
            $shopitem->{'itemlevel'} = empty($item_template) ? 0 : $item_template[0]['ItemLevel'];
            $shopitem->{'requiredlevel'} = empty($item_template) ? 0 : $item_template[0]['RequiredLevel'];
            $shopitem->{'maxdurability'} = empty($item_template) ? 0 : $item_template[0]['MaxDurability'];
            $shopitem->{'dmg_min1'} = empty($item_template) ? 0 : $item_template[0]['dmg_min1'];
            $shopitem->{'dmg_max1'} = empty($item_template) ? 0 : $item_template[0]['dmg_max1'];
            $shopitem->{'dmg_min2'} = empty($item_template) ? 0 : $item_template[0]['dmg_min2'];
            $shopitem->{'dmg_max2'} = empty($item_template) ? 0 : $item_template[0]['dmg_max2'];
            $shopitem->{'dmg_persec'} = empty($item_template) ? 0 : $this->getitemdmgpersec($item_template[0]['dmg_min1'], $item_template[0]['dmg_max1'], $item_template[0]['delay']);
            $shopitem->{'delay'} = $this->getitemdelay(empty($item_template) ? 0 : $item_template[0]['delay']);         
            $shopitem->{'armor'} = empty($item_template) ? 0 : $item_template[0]['armor'];
            $shopitem->{'spell_1'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_1']);
            $shopitem->{'spell_2'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_2']);
            $shopitem->{'spell_3'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_3']);
            $shopitem->{'spell_4'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_4']);
            $shopitem->{'spell_5'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_5']);
            $shopitem->{'allowableclass'} = $this->getallowableclasses(empty($item_template) ? 0 : $item_template[0]['AllowableClass'], $server);
            $shopitem->{'allowablerace'} = $this->getallowableraces(empty($item_template) ? 0 : $item_template[0]['AllowableRace'], $server);           

            if (!empty($item_template)) {
                for ($i = 0; $i < $item_template[0]['StatsCount']; $i++) {                   
                    $shopitem->{$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_type'.($i + 1) : 'bonus_stat_type'.($i + 1)} = $this->getitemstat($item_template[0]['stat_type'.($i + 1)]);
                    $shopitem->{$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_value'.($i + 1) : 'bonus_stat_value'.($i + 1)} = $item_template[0]['stat_value'.($i + 1)];
                }
            } 
        }
        
        $shopitems_discount = Shop_item::where([
              ['server', '=', $server],
              ['rnd_discount', '>', 0],
            ])->get()->toArray();
            
        foreach($shopitems_discount as &$shopitem) {
                $shopitem['realm_name'] = $this->getitemrealmname($shopitem['server'], $shopitem['realmid']);
                
                $item_template = $this->getitemtemplate($shopitem['server'], $shopitem['realmid'], $shopitem['itemid']);
                
                $shopitem['icon'] = $this->getitemiconbydisplayid(empty($item_template) ? -1 : $item_template[0]['displayid']);
                $shopitem['quality'] = $this->getitemquality(empty($item_template) ? -1 : $item_template[0]['Quality']);
                $shopitem['class'] = $this->getitemclass(empty($item_template) ? -1 : $item_template[0]['class']);
                $shopitem['skill'] = $this->getitemskillrequired(empty($item_template) ? -1 : $item_template[0]['RequiredSkill']);
                $shopitem['invtype'] = $this->getiteminvtype(empty($item_template) ? -1 : $item_template[0]['InventoryType']);
                $shopitem['bonding'] = $this->getitembonding(empty($item_template) ? -1 : $item_template[0]['bonding']);
                $shopitem['itemlevel'] = empty($item_template) ? 0 : $item_template[0]['ItemLevel'];
                $shopitem['requiredlevel'] = empty($item_template) ? 0 : $item_template[0]['RequiredLevel'];
                $shopitem['maxdurability'] = empty($item_template) ? 0 : $item_template[0]['MaxDurability'];
                $shopitem['dmg_min1'] = empty($item_template) ? 0 : $item_template[0]['dmg_min1'];
                $shopitem['dmg_max1'] = empty($item_template) ? 0 : $item_template[0]['dmg_max1'];
                $shopitem['dmg_min2'] = empty($item_template) ? 0 : $item_template[0]['dmg_min2'];
                $shopitem['dmg_max2'] = empty($item_template) ? 0 : $item_template[0]['dmg_max2'];
                $shopitem['dmg_persec'] = empty($item_template) ? 0 : $this->getitemdmgpersec($item_template[0]['dmg_min1'], $item_template[0]['dmg_max1'], $item_template[0]['delay']);
                $shopitem['delay'] = $this->getitemdelay(empty($item_template) ? 0 : $item_template[0]['delay']);         
                $shopitem['armor'] = empty($item_template) ? 0 : $item_template[0]['armor'];
                $shopitem['spell_1'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_1']);
                $shopitem['spell_2'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_2']);
                $shopitem['spell_3'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_3']);
                $shopitem['spell_4'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_4']);
                $shopitem['spell_5'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_5']);
                $shopitem['allowableclass'] = $this->getallowableclasses(empty($item_template) ? 0 : $item_template[0]['AllowableClass'], $server);
                $shopitem['allowablerace'] = $this->getallowableraces(empty($item_template) ? 0 : $item_template[0]['AllowableRace'], $server);
                
                if (!empty($item_template)) {
                    for ($i = 0; $i < $item_template[0]['StatsCount']; $i++) {                   
                        $shopitem[$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_type'.($i + 1) : 'bonus_stat_type'.($i + 1)] = $this->getitemstat($item_template[0]['stat_type'.($i + 1)]);
                        $shopitem[$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_value'.($i + 1) : 'bonus_stat_value'.($i + 1)] = $item_template[0]['stat_value'.($i + 1)];
                    }
                } 
        }     
            
        $shopitems_discount = array_chunk($shopitems_discount, 4);
                    
        return view('admin.shop.shop',['data' => $data, 'shopcategories' => $shopcategories, 'shopitems' => $shopitems, 'shopitems_discount' => $shopitems_discount, 'server' => $server]);
    }
    
    public function getallowableraces($racemask, $server) {
        $races = Armory_races::where('servers', 'LIKE', '%'.$server.'%')->get()->toArray();
        $races = array_filter($races, function($element) use($racemask) {
            return $racemask AND ($racemask & (1 << $element['id'] - 1));
        });
        
        $racenames = null;
        foreach ($races as $key => $element) {
            $racenames .= $element['name']; 
            
            if ($key !== array_key_last($races) AND count($races) > 1) {
                $racenames .= ', '; 
            }
        }
        
        return $racenames;
    }
    
    public function getallowableclasses($classmask, $server) {
        $classes = Armory_classes::where('servers', 'LIKE', '%'.$server.'%')->get()->toArray();
        $classes = array_filter($classes, function($element) use($classmask) {
            return $classmask AND ($classmask & (1 << $element['id'] - 1));
        });
        
        $allowableclasses = null;
        foreach ($classes as $key => $element) {
            $allowableclasses .= '<font color="'.$element['color'].'">'.$element['name'].'</font>';
            
            if ($key !== array_key_last($classes) AND count($classes) > 1) {
                $allowableclasses .= ', ';
            }
        }
        
        return $allowableclasses;
    }
    
    public function getspellinfo($spellid) {
        return Armory_spells::find($spellid); 
    }
    
    public function getitemdmgpersec($dmg_min, $dmg_max, $delay) {
        return round((($dmg_max + $dmg_min) / 2) / $this->getitemdelay($delay), 2);
    }
    
    public function getitemdelay($delay) {
        return round($delay / 1000, 2);
    }
    
    public function getcategoryitemcount($categoryid, $server) {      
        return Shop_item::where([
                  ['categoryid', '=', $categoryid],
                  ['server', '=', $server],
                ])->get()->count();
    }
    
    public function getitemrealmname($server, $realmid) { 
        return Realms::where([
                  ['server', '=', $server],
                  ['realmid', '=', $realmid],
                ])->first()->name;
    }
    
    public function getitemtemplate($server, $realmid, $itemid) {
        $item_template = Cache::get('item_template+'.$server.'realmid+'.$realmid.'+itemid='.$itemid);   
        
        if (!$item_template AND $this->isworlddbavailable($server, $realmid)) {
            $item_template = DB::connection('mysql_'.$server.'_world_'.$realmid)
                        ->select('SELECT displayid, Quality, class, RequiredSkill, InventoryType, bonding, ItemLevel, RequiredLevel, MaxDurability, 
                        dmg_min1, dmg_max1, dmg_min2, dmg_max2, delay, armor, spellid_1, spellid_2, spellid_3, spellid_4, spellid_5,
                        AllowableClass, AllowableRace, StatsCount, stat_type1, stat_type2, stat_type3, stat_type4, stat_type5, stat_type6, stat_type7, stat_type8, stat_type9, stat_type10,
                        stat_value1, stat_value2, stat_value3, stat_value4, stat_value5, stat_value6, stat_value7, stat_value8, stat_value9, stat_value10 FROM item_template 
                        WHERE entry = ?', array($itemid));
            
            $item_template = json_decode(json_encode($item_template), true);
            
            $cachelifetime = Carbon::now()->addMinutes(5); 
            Cache::put('item_template+'.$server.'realmid+'.$realmid.'+itemid='.$itemid, $item_template, $cachelifetime);
        }
        
        return $item_template;               
    }
    
    public function getitemiconbydisplayid($displayid) {
        $itemicon = Armory_itemicons::find($displayid);       
        return empty($itemicon) ? 'inv_misc_questionmark' : strtolower($itemicon->name);
    }
    
    public function getitemquality($qualityid) {
        $quality = Armory_itemqualities::find($qualityid);
        return empty($quality) ? null : $quality;                     
    }
    
    public function getitembonding($bondingid) {
        $bonding = Armory_itembondings::find($bondingid);
        return empty($bonding) ? null : $bonding->name;              
    }
    
    public function getiteminvtype($invtypeid) {
        $invtype = Armory_iteminvtypes::find($invtypeid);
        return empty($invtype) ? null : $invtype->name;              
    }
    
    public function getitemstat($statid) {
        $itemstats = Armory_itemstats::find($statid);
        return empty($itemstats) ? null : $itemstats->name;              
    }
    
    public function getitemclass($classid) {
        $class = Armory_itemclasses::find($classid);
        return empty($class) ? 'UNKNOWN' : $class->name;
    }
    
    public function getitemskillrequired($skillid) {
        $skill = Armory_skill_lines::find($skillid);
        return empty($skill) ? null : $skill->name;
    }
    
    public function showcategory($category, $realmid = 0) {
        $data = Auth::user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $shopcategories = Shop_category::where('server', $server)->get();
        
        foreach($shopcategories as &$shopcategory) {
                $shopcategory->{'item_count'} = $this->getcategoryitemcount($shopcategory->id, $shopcategory->server);
        }  
        
        $realminfos = Realms::where('server', $server)->get();  
        
        $shopcategory = $shopcategories->where('name', $category)->first();
                
        if (empty($shopcategory))
            return redirect()->route('shop');        
                         
        $shopitems = Shop_item::where($realmid > 0 ? [
              ['categoryid', '=', $shopcategory->id],
              ['server', '=', $server],
              ['realmid', '=', $realmid],
            ] : [
              ['categoryid', '=', $shopcategory->id],
              ['server', '=', $server],
            ])->orderBy('id', 'desc')->paginate(10);               

        foreach($shopitems as &$shopitem) {
            $shopitem->{'realm_name'} = $this->getitemrealmname($shopitem->server, $shopitem->realmid);
            
            $item_template = $this->getitemtemplate($shopitem->server, $shopitem->realmid, $shopitem->itemid);
            
            $shopitem->{'icon'} = $this->getitemiconbydisplayid(empty($item_template) ? -1 : $item_template[0]['displayid']);
            $shopitem->{'quality'} = $this->getitemquality(empty($item_template) ? -1 : $item_template[0]['Quality']);
            $shopitem->{'class'} = $this->getitemclass(empty($item_template) ? -1 : $item_template[0]['class']);
            $shopitem->{'skill'} = $this->getitemskillrequired(empty($item_template) ? -1 : $item_template[0]['RequiredSkill']);
            $shopitem->{'invtype'} = $this->getiteminvtype(empty($item_template) ? -1 : $item_template[0]['InventoryType']);
            $shopitem->{'bonding'} = $this->getitembonding(empty($item_template) ? -1 : $item_template[0]['bonding']);
            $shopitem->{'itemlevel'} = empty($item_template) ? 0 : $item_template[0]['ItemLevel'];
            $shopitem->{'requiredlevel'} = empty($item_template) ? 0 : $item_template[0]['RequiredLevel'];
            $shopitem->{'maxdurability'} = empty($item_template) ? 0 : $item_template[0]['MaxDurability'];
            $shopitem->{'dmg_min1'} = empty($item_template) ? 0 : $item_template[0]['dmg_min1'];
            $shopitem->{'dmg_max1'} = empty($item_template) ? 0 : $item_template[0]['dmg_max1'];
            $shopitem->{'dmg_min2'} = empty($item_template) ? 0 : $item_template[0]['dmg_min2'];
            $shopitem->{'dmg_max2'} = empty($item_template) ? 0 : $item_template[0]['dmg_max2'];
            $shopitem->{'dmg_persec'} = empty($item_template) ? 0 : $this->getitemdmgpersec($item_template[0]['dmg_min1'], $item_template[0]['dmg_max1'], $item_template[0]['delay']);
            $shopitem->{'delay'} = $this->getitemdelay(empty($item_template) ? 0 : $item_template[0]['delay']);         
            $shopitem->{'armor'} = empty($item_template) ? 0 : $item_template[0]['armor'];
            $shopitem->{'spell_1'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_1']);
            $shopitem->{'spell_2'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_2']);
            $shopitem->{'spell_3'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_3']);
            $shopitem->{'spell_4'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_4']);
            $shopitem->{'spell_5'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_5']);
            $shopitem->{'allowableclass'} = $this->getallowableclasses(empty($item_template) ? 0 : $item_template[0]['AllowableClass'], $server);
            $shopitem->{'allowablerace'} = $this->getallowableraces(empty($item_template) ? 0 : $item_template[0]['AllowableRace'], $server);

            if (!empty($item_template)) {
                for ($i = 0; $i < $item_template[0]['StatsCount']; $i++) {
                    $shopitem->{$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_type'.($i + 1) : 'bonus_stat_type'.($i + 1)} = $this->getitemstat($item_template[0]['stat_type'.($i + 1)]);
                    $shopitem->{$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_value'.($i + 1) : 'bonus_stat_value'.($i + 1)} = $item_template[0]['stat_value'.($i + 1)];
                }
            }        
        }   

        return view('admin.shop.showcategory',['data' => $data, 'shopcategories' => $shopcategories, 'shopcategory' => $shopcategory, 'shopitems' => $shopitems, 'server' => $server, 'realminfos' => $realminfos]);
    }
    
    public function ismainstat($stat_type){
        return $stat_type <= 7;
    }

    public function search(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');      
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
      
        $searchstr = $request->input('searchstr');
        
        preg_match_all('/[\p{L}\p{Z}\h\v\-]+/u', $searchstr, $matches_w);
        preg_match_all('/[\p{Nd}]+/', $searchstr, $matches_d);
             
        $matches = array_merge_recursive($matches_w[0], $matches_d[0]);
        
        $shopitems = null;
        
        foreach ($matches as $match) {
            if (Trim($match) === '')
                continue;

            $shopitems_tmp = Shop_item::where([
                      ['itemid', '=', $match],
                      ['server', '=', $server],
                    ])->orWhere([['name', 'LIKE', '%'.$match.'%'],['server', '=', $server]])->get()->toArray();
                    
            if (!$shopitems)
                $shopitems = $shopitems_tmp;
            else 
                $shopitems = array_merge_recursive($shopitems, $shopitems_tmp);
        }
        
        if (empty($shopitems)) {
            return redirect()->route('shop')->with([
                'status' => 'Unfortunately, nothing was found at your request.',
                'type' => 'danger',
              ]
            );
        }
        
        $shopitems = array_unique($shopitems, SORT_REGULAR);
           
        foreach ($shopitems as &$shopitem) {
            $shopitem['realm_name'] = $this->getitemrealmname($shopitem['server'], $shopitem['realmid']);
            
            $item_template = $this->getitemtemplate($shopitem['server'], $shopitem['realmid'], $shopitem['itemid']);
            
            $shopitem['icon'] = $this->getitemiconbydisplayid(empty($item_template) ? -1 : $item_template[0]['displayid']);
            $shopitem['quality'] = $this->getitemquality(empty($item_template) ? -1 : $item_template[0]['Quality']);
            $shopitem['class'] = $this->getitemclass(empty($item_template) ? -1 : $item_template[0]['class']);
            $shopitem['skill'] = $this->getitemskillrequired(empty($item_template) ? -1 : $item_template[0]['RequiredSkill']);
            $shopitem['invtype'] = $this->getiteminvtype(empty($item_template) ? -1 : $item_template[0]['InventoryType']);
            $shopitem['bonding'] = $this->getitembonding(empty($item_template) ? -1 : $item_template[0]['bonding']);
            $shopitem['itemlevel'] = empty($item_template) ? 0 : $item_template[0]['ItemLevel'];
            $shopitem['requiredlevel'] = empty($item_template) ? 0 : $item_template[0]['RequiredLevel'];
            $shopitem['maxdurability'] = empty($item_template) ? 0 : $item_template[0]['MaxDurability'];
            $shopitem['dmg_min1'] = empty($item_template) ? 0 : $item_template[0]['dmg_min1'];
            $shopitem['dmg_max1'] = empty($item_template) ? 0 : $item_template[0]['dmg_max1'];
            $shopitem['dmg_min2'] = empty($item_template) ? 0 : $item_template[0]['dmg_min2'];
            $shopitem['dmg_max2'] = empty($item_template) ? 0 : $item_template[0]['dmg_max2'];
            $shopitem['dmg_persec'] = empty($item_template) ? 0 : $this->getitemdmgpersec($item_template[0]['dmg_min1'], $item_template[0]['dmg_max1'], $item_template[0]['delay']);
            $shopitem['delay'] = $this->getitemdelay(empty($item_template) ? 0 : $item_template[0]['delay']);         
            $shopitem['armor'] = empty($item_template) ? 0 : $item_template[0]['armor'];
            $shopitem['spell_1'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_1']);
            $shopitem['spell_2'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_2']);
            $shopitem['spell_3'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_3']);
            $shopitem['spell_4'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_4']);
            $shopitem['spell_5'] = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_5']);
            $shopitem['allowableclass'] = $this->getallowableclasses(empty($item_template) ? 0 : $item_template[0]['AllowableClass'], $server);
            $shopitem['allowablerace'] = $this->getallowableraces(empty($item_template) ? 0 : $item_template[0]['AllowableRace'], $server);
                    
            if (!empty($item_template)) {
                for ($i = 0; $i < $item_template[0]['StatsCount']; $i++) {                   
                    $shopitem[$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_type'.($i + 1) : 'bonus_stat_type'.($i + 1)] = $this->getitemstat($item_template[0]['stat_type'.($i + 1)]);
                    $shopitem[$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_value'.($i + 1) : 'bonus_stat_value'.($i + 1)] = $item_template[0]['stat_value'.($i + 1)];
                }
            }  
        }        
                                        
        return view('admin.shop.searchshop', ['data' => $data, 'shopitems' => $shopitems]);
    }
    
    public function formcreateshop() {
        $data = Auth::user();
        $categories = Shop_category::all();
        
        if ($data->can('create-shop') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
                
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $realminfos = Realms::where('server', $server)->get();  

        return view('admin.shop.formcreateshop', ['data' => $data, 'realminfos' => $realminfos, 'categories' => $categories]);
    }

    public function createshop(Request $request) {
        $data = Auth::user();
        
        if ($data->can('create-shop') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');

        $shopitem = new Shop_item();
        $shopitem->categoryid = $request->input('categoryid');
        $shopitem->server = $server;
        $shopitem->realmid = $request->input('realmid');
        $shopitem->itemid = $request->input('itemid');
        $shopitem->name = $request->input('name');
        $shopitem->price = $request->input('price');
        $shopitem->count = $request->input('count');
        $shopitem->save();
		return redirect()->route('shop')->with([
                'status' => 'Shop item is successfully created!',
                'type' => 'success',
              ]
            );
    }

    public function formupdateshop(Request $request) {
        $data = $request->user();
        if ($data->can('update-shop') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->input('id');
        $shopitem = Shop_item::find($id);
	    if ($shopitem == null) {
            return redirect()->route('shop')->with([
                'status' => 'Shop item is not found!',
                'type' => 'danger',
              ]
            );
        }     
        
        $realminfos = Realms::where('server', $server)->get();  

        return view('admin.shop.formupdateshop', ['data' => $data, 'shopitem' => $shopitem, 'realminfos' => $realminfos]);
    }

    public function updateshop(Request $request) {
        $data = $request->user();
        if ($data->can('update-shop') === false) {
            abort(403);
        }

        $shopitem = Shop_item::find($request->input('idshop'));
		if ($shopitem == null) {
            return redirect()->route('shop')->with([
                'status' => 'Shop item is not found!',
                'type' => 'danger',
              ]
            );
        }     
		
        $shopitem->itemid = $request->input('itemid');
        $shopitem->realmid = $request->input('realmid');
        $shopitem->name = $request->input('name');
        $shopitem->price = $request->input('price');
        $shopitem->count = $request->input('count');
        $shopitem->save();
		
		return redirect()->route('shop')->with([
                'status' => 'Shop item is updated!',
                'type' => 'success',
              ]
            );
    }

    public function formpayment(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        $itemid = $request->input('id');
        $shopitem = Shop_item::find($itemid);
		if ($shopitem == null) {
            return redirect()->route('shop')->with([
                'status' => 'Shop item is not found!',
                'type' => 'danger',
              ]
            );
        }     
		
		$shopitem->price = $this->ispremium($shopitem->server, $data) ? ceil($shopitem->price * (100 - $shopitem->rnd_discount) / 100) : $shopitem->price;
        
        $item_template = $this->getitemtemplate($shopitem->server, $shopitem->realmid, $shopitem->itemid);      
        $shopitem->{'icon'} = $this->getitemiconbydisplayid(empty($item_template) ? -1 : $item_template[0]['displayid']);
        $shopitem->{'quality'} = $this->getitemquality(empty($item_template) ? -1 : $item_template[0]['Quality']);
        $shopitem->{'class'} = $this->getitemclass(empty($item_template) ? -1 : $item_template[0]['class']);
        $shopitem->{'skill'} = $this->getitemskillrequired(empty($item_template) ? -1 : $item_template[0]['RequiredSkill']);
        $shopitem->{'invtype'} = $this->getiteminvtype(empty($item_template) ? -1 : $item_template[0]['InventoryType']);
        $shopitem->{'bonding'} = $this->getitembonding(empty($item_template) ? -1 : $item_template[0]['bonding']);
        $shopitem->{'itemlevel'} = empty($item_template) ? 0 : $item_template[0]['ItemLevel'];
        $shopitem->{'requiredlevel'} = empty($item_template) ? 0 : $item_template[0]['RequiredLevel'];
        $shopitem->{'maxdurability'} = empty($item_template) ? 0 : $item_template[0]['MaxDurability'];
        $shopitem->{'dmg_min1'} = empty($item_template) ? 0 : $item_template[0]['dmg_min1'];
        $shopitem->{'dmg_max1'} = empty($item_template) ? 0 : $item_template[0]['dmg_max1'];
        $shopitem->{'dmg_min2'} = empty($item_template) ? 0 : $item_template[0]['dmg_min2'];
        $shopitem->{'dmg_max2'} = empty($item_template) ? 0 : $item_template[0]['dmg_max2'];
        $shopitem->{'dmg_persec'} = empty($item_template) ? 0 : $this->getitemdmgpersec($item_template[0]['dmg_min1'], $item_template[0]['dmg_max1'], $item_template[0]['delay']);
        $shopitem->{'delay'} = $this->getitemdelay(empty($item_template) ? 0 : $item_template[0]['delay']);         
        $shopitem->{'armor'} = empty($item_template) ? 0 : $item_template[0]['armor'];
        $shopitem->{'spell_1'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_1']);
        $shopitem->{'spell_2'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_2']);
        $shopitem->{'spell_3'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_3']);
        $shopitem->{'spell_4'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_4']);
        $shopitem->{'spell_5'} = $this->getspellinfo(empty($item_template) ? -1 : $item_template[0]['spellid_5']);
        $shopitem->{'allowableclass'} = $this->getallowableclasses(empty($item_template) ? 0 : $item_template[0]['AllowableClass'], $server);
        $shopitem->{'allowablerace'} = $this->getallowableraces(empty($item_template) ? 0 : $item_template[0]['AllowableRace'], $server);

        if (!empty($item_template)) {
            for ($i = 0; $i < $item_template[0]['StatsCount']; $i++) {                   
                $shopitem->{$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_type'.($i + 1) : 'bonus_stat_type'.($i + 1)} = $this->getitemstat($item_template[0]['stat_type'.($i + 1)]);
                $shopitem->{$this->ismainstat($item_template[0]['stat_type'.($i + 1)]) ? 'main_stat_value'.($i + 1) : 'bonus_stat_value'.($i + 1)} = $item_template[0]['stat_value'.($i + 1)];
            }
        }
        
        $userinfo = $this->getuserinfo($server, $data, $shopitem->realmid);
        $accgameinfo = $this->getgameaccountinfo($server, $data);
        
        $recruiterid = $accgameinfo[0]['recruiter'];             
        $recruiterdata = User::where('userid_'.$server, $recruiterid)->first();   
        $recruiterinfo = $recruiterdata != null ? $this->getuserinfo($server, $recruiterdata) : null;
     
        return view('admin.shop.formpayment', ['data' => $data, 'userinfo' => $userinfo, 'accgameinfo' => $accgameinfo, 'recruiterinfo' => $recruiterinfo, 'shopitem' => $shopitem, 'server' => $server]);
    }

    public function payments(Request $request) {
        $data = $request->user();
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $itemid = $request->input('itemid');
        $itemcount = $request->input('itemcount');
        $shopitem = Shop_item::find($itemid);
        $guid = $request->input('guid');
        
        if ($shopitem == null) {
            return redirect()->route('shop')->with([
                'status' => '¡No se encuentra el artículo de la tienda!',
                'type' => 'danger',
              ]
            );
        }     
                            
        if ($itemcount < 1 || $itemcount > 100) {
            return redirect()->route('shop')->with([
                'status' => '¡Has especificado un número inaceptable!',
                'type' => 'danger',
              ]
            );
        }

        
        $price = $this->ispremium($shopitem->server, $data) ? ceil($shopitem->price * (100 - $shopitem->rnd_discount) / 100) : $shopitem->price;
        $totalprice = $price*$itemcount;
        
        if ($data->donate < $totalprice) {
            return redirect()->route('shop')->with([
                'status' => 'Fondos insuficientes en su cuenta, ¡recargue su saldo!',
                'type' => 'danger',
              ]
            );
        }

        if (empty($guid)) {
            return redirect()->route('shop')->with([
                'status' => '¡No elegiste un personaje!',
                'type' => 'danger',
              ]
            );
        }       
        
        $charinfo = $this->getcharinfo($server, $guid, $shopitem->realmid);
        if (empty($charinfo)) {
            return redirect()->route('shop')->with([
                'status' => 'Character not found!',
                'type' => 'danger',
              ]
            );
        }

        $charinfo = json_decode(json_encode($charinfo), true);
      
        $reciver = $charinfo[0]['name'];       
        $command = 'send items ' .$reciver. ' "Tu pedido en la tienda online '.config('app.name_prj').'" "¡Gracias por comprar!" ' .$shopitem->itemid. ':'. $itemcount;           
        $soapclient = new SoapClientExtendedProvider($server, $charinfo[0]['realm_id']);        
        $soapclient->cmd($command);
		$soapmessages = $soapclient->getMessages();
		
        if (!$soapmessages){
            $data->donate = $data->donate - $totalprice;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = ($itemcount > 1 ? 'Comprar items ' : 'Comprar item ') . '"' . $shopitem->name . '" character ' .  $charinfo[0]['name'] . ' (' . strtoupper ($server) . ' / '. $charinfo[0]['realm_name'] . ') for ' . $totalprice . ' D';
            $history['type'] = 'payment';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
            
            return redirect()->route('shop')->with([
                'status' => '¡Compra completada con éxito, el artículo enviado al correo del personaje seleccionado!',
                'type' => 'success',
              ]
            );
        } else {
            return redirect()->route('shop')->with([
                'status' => $soapmessages[0],
                'type' => 'danger',
              ]
            );
        }
    }

    public function success() {
        $data = Auth::user();
        return view('admin.shop.paymentsuccess', ['data' => $data]);
    }
    
    public function failure() {
        $data = Auth::user();
        return view('admin.shop.paymentfail', ['data' => $data]);
    }

    public function deleteshop(Request $request) {
        $data = $request->user();
        if ($data->can('delete-shop') === false) {
            abort(403);
        }
        
        $id = $request->input('element_id');
        $shopitem = Shop_item::find($id);
        $shopitem->delete();
    }
    
    public function updaterandomdiscount(Request $request) {
        $oauth_token = $request->input('oauth_token');
        
        if ($oauth_token != env('OAUTH_RNDDISCOUNT_TOKEN')) {
             abort(403);
        }
        
        $rnd_min = Setting::where('key', 'rnd_discount_min')->first();
        $rnd_max = Setting::where('key', 'rnd_discount_max')->first();
        $rnd_discount = rand($rnd_min->value, $rnd_max->value);
        
        $servers = explode(',', env('APP_GAME_SERVER_LIST'));

        foreach ($servers as $server) {
            Shop_item::where([['server', '=', $server], ['rnd_discount', '!=', 0]])->update(array('rnd_discount' => 0)); // cleanup                                                  
            Shop_item::where('server', $server)->inRandomOrder()->take(8)->update(array('rnd_discount' => $rnd_discount)); // update random 8 items
        }
    }
}
