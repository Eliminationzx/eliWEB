<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use App\Referal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class YandexController extends Controller
{
    public function index(Request $request) {
        $yahash = $request->input('sha1_hash');
        $notification_type = $request->input('notification_type');
        $operation_id = $request->input('operation_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $datetime = $request->input('datetime');
        $sender = $request->input('sender');
        $codepro = $request->input('codepro');
        $label = $request->input('label');
        $notification_secret = env('PAYMENT_NOTIFICATION_SECRET_KEY');

		if (!empty($yahash) AND !empty($operation_id) AND !empty($amount)){
            //Storage::append('yandexcallback.log', 'Мы получили необходимые данные. Начинаем обработку платежа.');
        } else {
			$error[] = 'yandexcallback__error';
            //Storage::append('yandexcallback.log', 'Мы ничего не получили.');
		}
        
        /* Hash formating and SHA1 crypt
         */
        $myhash = $notification_type . '&' . $operation_id . '&' . $amount . '&' . $currency . '&' . $datetime . '&' . $sender . '&' . $codepro . '&' . $notification_secret . '&' . $label;
        $myhash = hash('sha1', $myhash);
		
		$amount = ceil($amount);
        
        if ($amount <= 0) {
			$error[] = 'yandexcallback__error';
            //Storage::append('yandexcallback.log', 'Введённая сумма меньше или равна нулю.');
        }
		
        // Keys comparison
        if (strcasecmp($yahash, $myhash) != 0) {
            $error[] = 'yandexcallback__error';
            //Storage::append('yandexcallback.log', 'Хеши ключа не совпадают.');
        }
		
        if(empty($error)) {                   
            $user = User::find($label);                      
			$user->donate = $user->donate + $amount;
			$user->save();
			
			$referalinfo = Referal::where('userid', $user->id)->first();             
			$recruiterdata = $referalinfo != null ? User::find($referalinfo->referalid) : null;
			$reward_pct = Setting::where('key', 'recruiter_reward_pct')->first();
			
			if ($recruiterdata AND $reward_pct->value > 0) {
				$reward = ceil($amount * $reward_pct->value / 100);
				$recruiterdata->donate = $recruiterdata->donate + $reward;
				$recruiterdata->save();
				
				$history['userid'] = $recruiterdata->id;
				$history['comment'] = 'Charge '.$reward.' donation points for referal';
				$history['type'] = 'rewards';
				$history['ip'] = $request->ip();
				$this->sethistory($history);
			}

			$history['userid'] = $label;
			$history['comment'] = 'Recharging on ' . $amount .  ' donation points';
			$history['type'] = 'charges';
			$history['ip'] = $request->ip();
			$this->sethistory($history);
        }
    }
}
