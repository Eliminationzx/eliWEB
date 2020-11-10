<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Setting;
use App\User;

class SpinController extends Controller
{
    public function index(){
        $data = Auth::user();
        $spin_cost = Setting::where('key', 'spin_cost')->first();    
        $spin_reward = Setting::where('key', 'spin_reward')->first();           
        return view('admin.spin.spin', ['data' => $data, 'spin_cost' => $spin_cost, 'spin_reward' => $spin_reward]);
    }
    
    public function payforspin(Request $request) {

        $token = Crypt::encrypt(env('OAUTH_SPIN_TOKEN'));

        $data = $request->user();
        
        $price = Setting::where('key', 'spin_cost')->first();
        $reward = Setting::where('key', 'spin_reward')->first();
        
        $allow = $data->donate >= $price->value;
        
        if ($allow) {
            $data->donate = $data->donate - $price->value;
            $data->save();
        }
        
        return response()->json(['donate' => $data->donate, 'price' => $price->value, 'reward' => $reward->value, 'allow' => $allow, 'token' => $token]);
    }
    
    public function reward(Request $request) {
        
        $spinToken = Crypt::decrypt($request->header('SpinToken'));   
        if ($spinToken != env('OAUTH_SPIN_TOKEN')) {
            abort(403);
         }
         
        $reward = $request->input('reward');       
        $data = $request->user(); 

        if ($reward > 0) {            
            $data->donate = $data->donate + $reward;
            $data->save();
            
            $history['userid'] = $data->id;
            $history['comment'] = 'Winning the test of luck, the award '.$reward.' D';
            $history['type'] = 'reward';
            $history['ip'] = $request->ip();
            $this->sethistory($history);
        }
        
        return response()->json(['donate' => $data->donate]);
    }
}
