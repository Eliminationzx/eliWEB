<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class DonateController extends Controller
{
    public function index(){
        $data = Auth::user();      
        return view('admin.account.donate', ['data' => $data]);
    }
	
	public function execute(Request $request){
		if (strpos(env('PAYMENT_URL'), 'free-kassa') !== false) {
			$redirect_url = env('PAYMENT_URL');	
			$merchant_id = $request->input('m');
			$order_id = $request->input('o');
			$currency = $request->input('i');
			$amount = $request->input('oa');
			$email = $request->input('em');
			$phone = $request->input('phone');
			$lang = $request->input('lang');
			
			if ($amount < 32)
			{
				return redirect()->back()->with([
					'status' => 'Минимальная сумма пополнения 32 рубля',
					'type' => 'danger',
				  ]);
			}
			
			$notification_secret = env('PAYMENT_NOTIFICATION_SECRET_KEY');
			$hash = md5($merchant_id.':'.$amount.':'.$notification_secret.':'.$order_id);
				
			$redirect_url .= "?m=".$merchant_id."&o=".$order_id."&oa=".$amount."&i=".$currency."&s=".$hash."&em=".$email."&lang=".$lang."&phone=".$phone;
			
			return redirect($redirect_url);
		}
		
        return redirect()->back()->with([
					'status' => 'The payment system is disabled',
					'type' => 'danger',
				  ]);
    }
}
