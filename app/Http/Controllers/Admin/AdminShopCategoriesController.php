<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminShopCategoriesController extends Controller
{
    public function getallshopcategories() {
        $data = Auth::user();
        if ($data->can('view-shopcategories') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $shopcategories = Shop_category::where('server', $server)->orderBy("id", 'desc')->paginate(10);
        return view('admin.system.shopcategories.getallshopcategories',compact(['shopcategories', 'data']));
    }

    public function formcreateshopcategories() {
        $data = Auth::user();
        if ($data->can('create-shopcategories') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        return view('admin.system.shopcategories.formcreateshopcategories',compact(['data']));
    }

    public function createshopcategories(Request $request) {
        $data = $request->user();
        if ($data->can('create-shopcategories') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $name = $request->name;
        $display_name = $request->display_name;
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
                
        if ($this->categoryexist($name))
            return redirect()->route('admin.shopcategories')->with('status', 'A category with this variable name already exists!');
        
        $shopcategory = new Shop_category();
        $shopcategory->name  = $name;
        $shopcategory->local = $display_name; // optional
        $shopcategory->server = $server;
        $shopcategory->save();

        return redirect()->route('admin.shopcategories')->with('status', 'Category successfully created!');
    }
    
    public function categoryexist($name) {
        return Shop_category::where('name', $name)->first() !== null;
    }
    
    public function categoryexistwithexception($name, $except) {
        return Shop_category::where([['name','=', $name], ['id', '!=', $except]])->first() !== null;
    }

    public function formupdateshopcategories($id) {
        $data = Auth::user();
        if ($data->can('update-shopcategories') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $shopcategory = Shop_category::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        return view('admin.system.shopcategories.formupdateshopcategories',compact(['shopcategory', 'data']));
    }

    public function updateshopcategories(Request $request) {
        $data = $request->user();
        if ($data->can('update-shopcategories') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $name = $request->name;
        $display_name = $request->display_name;
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->shopcategoryid;
        $shopcategory = Shop_category::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
				
		if (empty($shopcategory))
			return redirect()->route('admin.shopcategories');
                
        if ($this->categoryexistwithexception($name, $shopcategory->id))
            return redirect()->route('admin.shopcategories')->with('status', 'A category with this variable name already exists!');
          
        $shopcategory->name = $name;
        $shopcategory->local = $display_name;
        $shopcategory->save();

        return redirect()->route('admin.shopcategories')->with('status', 'Category successfully updated!');
    }

    public function deleteshopcategories(Request $request){
        $data = $request->user();
        if ($data->can('delete-shopcategories') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->element_id;
        $shopcategory = Shop_category::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        $shopcategory->delete();
    }
}
