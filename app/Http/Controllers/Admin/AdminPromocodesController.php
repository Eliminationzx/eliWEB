<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Promo_code;
use App\Promo_type;
use App\Realms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminPromocodesController extends Controller
{
    public function getallpromocodes() {
        $data = Auth::user();
        if ($data->can('view-promocodes') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $promocodes = Promo_code::where('server', $server)->orderBy("id", 'desc')->paginate(10);
        foreach ($promocodes as &$promocode) {
            $realminfo = Realms::where([['id', '=', $promocode->realmid], ['server', '=', $promocode->server]])->first();
            $type = Promo_type::where('id', $promocode->typeid)->first();
            $promocode->{'realm_name'} = $realminfo->name;
            $promocode->{'type_name'} = $type->name;
        }
        
        return view('admin.system.promocodes.getallpromocodes',compact(['promocodes', 'data']));
    }

    public function formcreatepromocodes() {
        $data = Auth::user();
        if ($data->can('create-promocodes') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $realminfos = Realms::where('server', $server)->get();
        $types = Promo_type::all();
        return view('admin.system.promocodes.formcreatepromocodes',compact(['realminfos', 'types', 'data']));
    }

    public function createpromocodes(Request $request) {
        $data = $request->user();
        if ($data->can('create-promocodes') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $realmid = $request->input('realmid');
        $typeid = $request->input('typeid');
        $name = $request->input('name');
        $code = $request->input('code');
        $data0 = $request->input('data0');
        $data1 = $request->input('data1');
        $usage_count = $request->input('usage_count');
        $unused_date = $request->input('unused_date');
           
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
                
        if ($this->promocodeexist($code))
            return redirect()->route('admin.promocodes')->with('status', 'Such a promo code already exists!');
        
        $promocode = new Promo_code();
        $promocode->server = $server;
        $promocode->name = $name;
        $promocode->realmid = $realmid;
        $promocode->typeid = $typeid;
        $promocode->code = $code;
        $promocode->data0 = $data0;
        $promocode->data1 = $data1;
        $promocode->usage_count = $usage_count;
        $promocode->unused_date = strtotime($unused_date);
        $promocode->save();

        return redirect()->route('admin.promocodes')->with('status', 'Promocode successfully created!');
    }
    
    public function promocodeexistwithexception($code, $except) {
        return Promo_code::where([['code', '=', $code], ['id', '!=', $except]])->first() !== null;
    }
    
    public function promocodeexist($code) {
        return Promo_code::where('code', $code)->first() !== null;
    }

    public function formupdatepromocodes($id) {
        $data = Auth::user();
        if ($data->can('update-promocodes') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $promocode = Promo_code::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        $realminfos = Realms::where('server', $server)->get();
        $types = Promo_type::all();
        return view('admin.system.promocodes.formupdatepromocodes',compact(['promocode', 'types', 'realminfos', 'data']));
    }

    public function updatepromocodes(Request $request) {
        $data = $request->user();
        if ($data->can('update-promocodes') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $realmid = $request->input('realmid');
        $name = $request->input('name');
        $typeid = $request->input('typeid');
        $code = $request->input('code');
        $data0 = $request->input('data0');
        $data1 = $request->input('data1');
        $usage_count = $request->input('usage_count');
        $unused_date = $request->input('unused_date');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->input('codeid');
        $promocode = Promo_code::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
				
	    if (empty($promocode))
			return redirect()->route('admin.promocodes');
                
        if ($this->promocodeexistwithexception($code, $promocode->id))
            return redirect()->route('admin.promocodes')->with('status', 'Such a promo code already exists!');

        $promocode->typeid = $typeid;
        $promocode->realmid = $realmid;
        $promocode->name = $name;
        $promocode->code = $code;
        $promocode->data0 = $data0;
        $promocode->data1 = $data1;
        $promocode->usage_count = $usage_count;
        $promocode->unused_date = strtotime($unused_date);
        $promocode->save();

        return redirect()->route('admin.promocodes')->with('status', 'Promocode successfully updated!');
    }

    public function deletepromocodes(Request $request){
        $data = $request->user();
        if ($data->can('delete-promocodes') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->element_id;
        $promocode = Promo_code::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        $promocode->delete();
    }
}
