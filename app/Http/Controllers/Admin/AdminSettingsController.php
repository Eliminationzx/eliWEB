<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{
    public function getallsettings(){
        $data = Auth::user();
        if ($data->can('view-settings') === false) {
            abort(403);
        }
        $settings = Setting::all();
        return view('admin.system.settings.getallsettings', ['data' => $data,  'settings' => $settings]);
    }

    public function updatesettings(Request $request){
        $data = $request->user();
        if ($data->can('update-settings') === false) {
            abort(403);
        }
        
        $param = $_POST;
        foreach ($param as $key => $value) {
            if($key !== '_token') {
                $UpdateSetting = Setting::updateOrCreate(
                  ['key' => $key],
                  ['value' => $value]
                );
            }
        }
        return redirect()->route('admin.settings')->with([
            'status' => 'Settings saved successfully!',
            'type' => 'success',
          ]
        );
    }
}
