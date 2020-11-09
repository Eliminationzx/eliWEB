<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Session;
use URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use App\Setting;
use App\User;
use App\Referal;
use App\History;

class DonateController extends Controller
{
	private $_api_context;
	
	public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
	
    public function index(){
        $data = Auth::user();
		$price = Setting::where('key', 'donation_price')->first();
		$currency = Setting::where('key', 'donation_currency')->first();
        return view('admin.account.donate', ['data' => $data, 'price' => $price, 'currency' => $currency]);
    }
	
	public function donateWithpaypal(Request $request)
    {	
		$data = $request->user();
		$quantity = ceil($request->get('d_count'));
		
		if ($quantity < 1) {
			return redirect()->back()->with([
					'status' => 'The number of donation points is incorrect.',
					'type' => 'danger',
				  ]);
		}
		
		$payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
			
		$item_name = Setting::where('key', 'donation_item_name')->first();
		$price = Setting::where('key', 'donation_price')->first();
		$currency = Setting::where('key', 'donation_currency')->first();
		$trans_descr = Setting::where('key', 'donation_trans_descr')->first();
 
        $item_1->setName($item_name->value) /** item name **/
            ->setCurrency($currency->value)
            ->setQuantity($quantity)
            ->setPrice($price->value); /** unit price **/
 
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
 
        $amount = new Amount();
        $amount->setCurrency($currency->value)
            ->setTotal($quantity * $price->value);
 
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($trans_descr->value);
 
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('donate.getdonatestatus')) /** Specify return URL **/
            ->setCancelUrl(URL::route('donate.getdonatestatus'));
 
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
 
            $payment->create($this->_api_context);
 
        } catch (\PayPal\Exception\PPConnectionException $ex) {
 
            if (\Config::get('app.debug')) {
 				return redirect()->back()->with([
					'status' => 'Connection timeout.',
					'type' => 'danger',
				  ]);
            } else {
				return redirect()->back()->with([
					'status' => 'Some error occur, sorry for inconvenient.',
					'type' => 'danger',
				  ]);
            }
        }
 
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
 
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
 
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
 
		return redirect()->back()->with([
				'status' => 'Unknown error occurred',
				'type' => 'danger',
			  ]);
	}
	
	public function getDonateStatus()
    {   
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
		
        /** clear the session payment ID and user ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
			return redirect()->route('donate')->with([
							'status' => 'Donation failed',
							'type' => 'danger',
						  ]);
        }
 
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
 
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
 
        if ($result->getState() == 'approved') {
			$transaction = $payment->getTransactions()[0];
			$amount = $transaction->getAmount();
			$price = Setting::where('key', 'donation_price')->first();
			$donate = ceil($amount->getTotal() / $price->value);
			
			$user = Auth::user();
			$user->donate = $user->donate + $donate;
			$user->save();
			
			$referalinfo = Referal::where('userid', $user->id)->first();             
			$recruiterdata = $referalinfo != null ? User::find($referalinfo->referalid) : null;
			$reward_pct = Setting::where('key', 'recruiter_reward_pct')->first();
			
			if ($recruiterdata AND $reward_pct->value > 0) {
				$reward = ceil($donate * $reward_pct->value / 100);
				$recruiterdata->donate = $recruiterdata->donate + $reward;
				$recruiterdata->save();
				
				$history['userid'] = $recruiterdata->id;
				$history['comment'] = 'Charge '.$reward.' donation points for referal';
				$history['type'] = 'rewards';
				$history['ip'] = \Request::ip();
				$this->sethistory($history);
			}

			$history['userid'] = $user->id;
			$history['comment'] = 'Recharging on ' . $donate .  ' donation points';
			$history['type'] = 'charges';
			$history['ip'] = \Request::ip();
			$this->sethistory($history);
			
            return redirect()->route('donate')->with([
						'status' => 'Donation success.',
						'type' => 'success',
					  ]);
        }
 
		return redirect()->route('donate')->with([
						'status' => 'Donation failed.',
						'type' => 'danger',
					  ]);
    }
}
