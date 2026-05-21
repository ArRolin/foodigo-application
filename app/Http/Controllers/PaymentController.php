<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Razorpay\Api\Api;
use App\Helper\EmailHelper;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Mail\NewOrderConfirmation;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Log;
use Modules\Order\App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Modules\Order\App\Models\OrderItem;
use Modules\Currency\App\Models\Currency;
use Modules\SmsSetting\App\Models\SmsSetting;
use Modules\SmsSetting\App\Models\SmsTemplate;
use Modules\EmailSetting\App\Models\EmailTemplate;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Modules\PaymentGateway\App\Models\PaymentGateway;
Use Stripe;

class PaymentController extends Controller
{

    public $payment_setting;

    public function __construct()
    {
        $payment_data = PaymentGateway::all();


            $this->payment_setting = array();

            foreach($payment_data as $data_item){
                $payment_setting[$data_item->key] = $data_item->value;
            }

            $this->payment_setting  = (object) $payment_setting;
    }

    public function pay_with_stripe(Request $request): \Illuminate\Http\RedirectResponse
    {

        if(env('APP_MODE') == 'DEMO'){
            $notification = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notification=array('message'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $stripe_currency_id =  PaymentGateway::where('key', 'stripe_currency_id')->first()->value;
        $stripe_secret =  PaymentGateway::where('key', 'stripe_secret')->first()->value;
        $currency = Currency::where('id', $stripe_currency_id)->first();
        $currency_rate = $currency->currency_rate;
        $payableAmount = round(session('order_data.new_total') * $currency_rate,2);
        Stripe\Stripe::setApiKey($stripe_secret);

        $result = Stripe\Charge::create ([
            "amount" => $payableAmount * 100,
            "currency" => $currency->currency_code,
            "source" => $request->stripeToken,
            "description" => env('APP_NAME')
        ]);

        $order_info = session('order_data');
        $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

        if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
            $user_address = new UserAddress();
            $user_address->user_id = $user_id;
            $user_address->name = $order_info['name'];
            $user_address->email = $order_info['email'];
            $user_address->phone = $order_info['phone'];
            $user_address->address = $order_info['address'];
            $user_address->delivery_type = $order_info['delivery_type'];
            $user_address->lat = $order_info['lat'];
            $user_address->lon = $order_info['lon'];
            $user_address->save();
        }

        $address_info = [
            'user_id' => $user_id,
            'contact_person_name' =>  $order_info['name'],
            'contact_person_number' =>  $order_info['phone'],
            'contact_person_email' =>  $order_info['email'],
            'address_type' => $order_info['delivery_type'] ?? '',
            'address' => $order_info['address'] ?? '',
            'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
            'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
        ];

        $cart = session('cart', []);
        $order = $this->createOrder($order_info, $cart,'Stripe', 'success', $result->balance_transaction, $user_id, $address_info);

        if (Auth::check()){
            $notification = trans('translate.Your order has been placed. Thanks for your order');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('user.order-details', $order->id)->with($notification);
        }else{
            $notification = trans('translate.Your order has been placed. Thanks for your order');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('home')->with($notification);
        }



    }

    public function bank_payment(Request $request, $amount){

        $request->validate([
            'tnx_info' => 'required|max:255'
        ],[
            'tnx_info.required' => trans('translate.Transaction field is required')
        ]);

        $txt_info = $request->tnx_info;

        $order_info = session('order_data');
        $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

        if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
            $user_address = new UserAddress();
            $user_address->user_id = $user_id;
            $user_address->name = $order_info['name'];
            $user_address->email = $order_info['email'];
            $user_address->phone = $order_info['phone'];
            $user_address->address = $order_info['address'];
            $user_address->delivery_type = $order_info['delivery_type'];
            $user_address->lat = $order_info['lat'];
            $user_address->lon = $order_info['lon'];
            $user_address->save();
        }

        $address_info = [
            'user_id' => $user_id,
            'contact_person_name' =>  $order_info['name'],
            'contact_person_number' =>  $order_info['phone'],
            'contact_person_email' =>  $order_info['email'],
            'address_type' => $order_info['delivery_type'] ?? '',
            'address' => $order_info['address'] ?? '',
            'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
            'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
        ];

        $cart = session('cart', []);
        $order = $this->createOrder($order_info, $cart,'Bank Payment', 'success', $txt_info, $user_id, $address_info);

        if (Auth::check()){
            $notification = trans('translate.Your order has been placed. Thanks for your order');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('user.order-details', $order->id)->with($notification);
        }else{
            $notification = trans('translate.Your order has been placed. Thanks for your order');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('home')->with($notification);
        }

        $order = $this->create_order($auth_user, $service, $service_package, $package_name, $package_main_price, 'Bank Payment', 'pending', $request->tnx_info);

        $notify_message = trans('translate.Your payment has been made. please wait for admin payment approval');
        $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->route('buyer.orders')->with($notify_message);

    }

    public function paypal_payment(Request $request, $amount){

        if(env('APP_MODE') == 'DEMO'){
            $notification = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notification=array('message'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $paypal_currency = Currency::findOrFail($this->payment_setting->paypal_currency_id);
        $payable_amount = round($amount * $paypal_currency->currency_rate);
        Session::put('payable_amount', $payable_amount);
        config(['paypal.mode' => $this->payment_setting->paypal_account_mode]);
        if($this->payment_setting->paypal_account_mode == 'sandbox'){
            config(['paypal.sandbox.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.sandbox.client_secret' => $this->payment_setting->paypal_secret_key]);
        }else{
            config(['paypal.live.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.live.client_secret' => $this->payment_setting->paypal_secret_key]);
            config(['paypal.live.app_id' => 'APP-80W284485P519543T']);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal-success-payment'),
                "cancel_url" => route('paypal-faild-payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $paypal_currency->currency_code,
                        "value" => $payable_amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            $notification = trans('translate.Something went wrong, please try again');
            return response()->json(['status' => 'faild' , 'message' => $notification]);

        } else {
            $notification = trans('translate.Something went wrong, please try again');
            return response()->json(['status' => 'faild' , 'message' => $notification]);
        }

    }


    public function paypal_success_payment(Request $request){

        $txt_info = $request->PayerID;
        $paypal_currency = Currency::findOrFail($this->payment_setting->paypal_currency_id);

        config(['paypal.mode' => $this->payment_setting->paypal_account_mode]);

        if($this->payment_setting->paypal_account_mode == 'sandbox'){
            config(['paypal.sandbox.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.sandbox.client_secret' => $this->payment_setting->paypal_secret_key]);
        }else{
            config(['paypal.live.client_id' => $this->payment_setting->paypal_client_id]);
            config(['paypal.live.client_secret' => $this->payment_setting->paypal_secret_key]);
            config(['paypal.live.app_id' => 'APP-80W284485P519543T']);
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {


            $order_info = session('order_data');
            $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

            if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
                $user_address = new UserAddress();
                $user_address->user_id = $user_id;
                $user_address->name = $order_info['name'];
                $user_address->email = $order_info['email'];
                $user_address->phone = $order_info['phone'];
                $user_address->address = $order_info['address'];
                $user_address->delivery_type = $order_info['delivery_type'];
                $user_address->lat = $order_info['lat'];
                $user_address->lon = $order_info['lon'];
                $user_address->save();
            }

            $address_info = [
                'user_id' => $user_id,
                'contact_person_name' =>  $order_info['name'],
                'contact_person_number' =>  $order_info['phone'],
                'contact_person_email' =>  $order_info['email'],
                'address_type' => $order_info['delivery_type'] ?? '',
                'address' => $order_info['address'] ?? '',
                'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
                'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
            ];

            $cart = session('cart', []);

            $order = $this->createOrder($order_info, $cart,'Paypal', 'success', $txt_info, $user_id, $address_info);

            if (Auth::check()){
                $notification = trans('translate.Your order has been placed. Thanks for your order');
                $notification = array('message'=>$notification,'alert-type'=>'success');
                return redirect()->route('user.order-details', $order->id)->with($notification);
            }else{
                $notification = trans('translate.Your order has been placed. Thanks for your order');
                $notification = array('message'=>$notification,'alert-type'=>'success');
                return redirect()->route('home')->with($notification);
            }

        } else {

            $notification = trans('translate.Something went wrong, please try again');
            $notification = array('message'=>$notification,'alert-type'=>'error');
            return redirect()->route('home')->with($notification);
        }

    }


    public function razorpay_payment(Request $request, $amount){

         if(env('APP_MODE') == 'DEMO'){
            $notification = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notification=array('message'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $txt_info = $request->razorpay_payment_id;
        $input = $request->all();
        $api = new Api($this->payment_setting->razorpay_key,$this->payment_setting->razorpay_secret);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payId = $response->id;

                $order_info = session('order_data');
                $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

                if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
                    $user_address = new UserAddress();
                    $user_address->user_id = $user_id;
                    $user_address->name = $order_info['name'];
                    $user_address->email = $order_info['email'];
                    $user_address->phone = $order_info['phone'];
                    $user_address->address = $order_info['address'];
                    $user_address->delivery_type = $order_info['delivery_type'];
                    $user_address->lat = $order_info['lat'];
                    $user_address->lon = $order_info['lon'];
                    $user_address->save();
                }

                $address_info = [
                    'user_id' => $user_id,
                    'contact_person_name' =>  $order_info['name'],
                    'contact_person_number' =>  $order_info['phone'],
                    'contact_person_email' =>  $order_info['email'],
                    'address_type' => $order_info['delivery_type'] ?? '',
                    'address' => $order_info['address'] ?? '',
                    'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
                    'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
                ];

                $cart = session('cart', []);


                $order = $this->createOrder($order_info, $cart,'Razorpay', 'success', $txt_info, $user_id, $address_info);

                 if (Auth::check()){
                    $notification = trans('translate.Your order has been placed. Thanks for your order');
                    $notification = array('message'=>$notification,'alert-type'=>'success');
                    return redirect()->route('user.order-details', $order->id)->with($notification);
                }else{
                    $notification = trans('translate.Your order has been placed. Thanks for your order');
                    $notification = array('message'=>$notification,'alert-type'=>'success');
                    return redirect()->route('home')->with($notification);
                }

            }catch (Exception $e) {
                $notification = trans('translate.Something went wrong, please try again');
                $notification = array('message'=>$notification,'alert-type'=>'error');
                return redirect()->route('home')->with($notification);
            }
        }else{
            $notification = trans('translate.Something went wrong, please try again');
            $notification = array('message'=>$notification,'alert-type'=>'error');
            return redirect()->route('home')->with($notification);
        }
    }

    public function flutterwave_payment(Request $request, $amount){
        $curl = curl_init();
        $txt_info = $request->tnx_id;
        Session::put('tnx_id', $txt_info);
        $url = "https://api.flutterwave.com/v3/transactions/$txt_info/verify";
        $token = $this->payment_setting->flutterwave_secret_key;
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if($response->status == 'success'){

            $notify_message = trans('translate.Your order has been placed. Thanks for your order');
            return response()->json(['status' => 'success' , 'message' => $notify_message]);

        }else{
            $notify_message = trans('translate.Something went wrong, please try again');
            return response()->json(['status' => 'faild' , 'message' => $notify_message]);
        }


    }
    public function flutterwave_payment_success(Request $request){
        $txt_info = Session::get('tnx_id');
        $order_info = session('order_data');
        $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

        if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
            $user_address = new UserAddress();
            $user_address->user_id = $user_id;
            $user_address->name = $order_info['name'];
            $user_address->email = $order_info['email'];
            $user_address->phone = $order_info['phone'];
            $user_address->address = $order_info['address'];
            $user_address->delivery_type = $order_info['delivery_type'];
            $user_address->lat = $order_info['lat'];
            $user_address->lon = $order_info['lon'];
            $user_address->save();
        }

        $address_info = [
            'user_id' => $user_id,
            'contact_person_name' =>  $order_info['name'],
            'contact_person_number' =>  $order_info['phone'],
            'contact_person_email' =>  $order_info['email'],
            'address_type' => $order_info['delivery_type'] ?? '',
            'address' => $order_info['address'] ?? '',
            'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
            'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
        ];

        $cart = session('cart', []);


            $order = $this->createOrder($order_info, $cart,'Flutterwave', 'success', $txt_info, $user_id, $address_info);

        if (Auth::check()){
                $notification = trans('translate.Your order has been placed. Thanks for your order');
                $notification = array('message'=>$notification,'alert-type'=>'success');
                return redirect()->route('user.order-details', $order->id)->with($notification);
            }else{
                $notification = trans('translate.Your order has been placed. Thanks for your order');
                $notification = array('message'=>$notification,'alert-type'=>'success');
                return redirect()->route('home')->with($notification);
            }


    }

    public function paystack_payment(Request $request, $amount){
        $reference = $request->reference;
        $txt_info = $request->tnx_id;
        Session::put('tnx_id', $txt_info);
        $secret_key = $this->payment_setting->paystack_secret_key;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST =>0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secret_key",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if($final_data->status == true) {



            $notify_message = trans('translate.Your order has been placed. Thanks for your order');
            return response()->json(['status' => 'success' , 'message' => $notify_message]);

        }else{
            $notify_message = trans('translate.Something went wrong, please try again');
            return response()->json(['status' => 'faild' , 'message' => $notify_message]);
        }

    }
    public function paystack_paymen_successt(Request $request){
        $txt_info = Session::get('tnx_id');
        $order_info = session('order_data');
        $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

        if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
            $user_address = new UserAddress();
            $user_address->user_id = $user_id;
            $user_address->name = $order_info['name'];
            $user_address->email = $order_info['email'];
            $user_address->phone = $order_info['phone'];
            $user_address->address = $order_info['address'];
            $user_address->delivery_type = $order_info['delivery_type'];
            $user_address->lat = $order_info['lat'];
            $user_address->lon = $order_info['lon'];
            $user_address->save();
        }

        $address_info = [
            'user_id' => $user_id,
            'contact_person_name' =>  $order_info['name'],
            'contact_person_number' =>  $order_info['phone'],
            'contact_person_email' =>  $order_info['email'],
            'address_type' => $order_info['delivery_type'] ?? '',
            'address' => $order_info['address'] ?? '',
            'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
            'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
        ];

        $cart = session('cart', []);


        $order = $this->createOrder($order_info, $cart,'Paystack', 'success', $txt_info, $user_id, $address_info);

        if (Auth::check()){
            $notification = trans('translate.Your order has been placed. Thanks for your order');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('user.order-details', $order->id)->with($notification);
        }else{
            $notification = trans('translate.Your order has been placed. Thanks for your order');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('home')->with($notification);
        }

    }

    public function mollie_payment(Request $request){
        $amount = $request->amount;
        if(env('APP_MODE') == 'DEMO'){
            $notify_message = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notify_message=array('message'=>$notify_message,'alert-type'=>'error');
            return redirect()->back()->with($notify_message);
        }

        $auth_user = Auth::guard('web')->user();

        $package_main_price = $amount;

        try{
            $mollie_currency = Currency::findOrFail($this->payment_setting->mollie_currency_id);

            $price = $package_main_price * $mollie_currency->currency_rate;
            $price = sprintf('%0.2f', $price);

            $mollie_api_key = $this->payment_setting->mollie_key;

            $currency = strtoupper($mollie_currency->currency_code);

            Mollie::api()->setApiKey($mollie_api_key);

            $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => $currency,
                    'value' => ''.$price.'',
                ],
                'description' => env('APP_NAME'),
                'redirectUrl' => route('mollie-callback'),
            ]);

            $payment = Mollie::api()->payments()->get($payment->id);

            Session::put('amount', $price);
            Session::put('payment_id', $payment->id);

            return redirect($payment->getCheckoutUrl(), 303);

        }catch (Exception $e) {
            Log::info($e->getMessage());
            $notify_message = trans('translate.Please provide valid mollie api key');
            $notify_message = array('message'=>$notify_message,'alert-type'=>'error');
            return redirect()->back()->with($notify_message);
        }


    }


    public function mollie_callback(Request $request){

        $mollie_api_key = $this->payment_setting->mollie_key;
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()){

            $order_info = session('order_data');
            $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

            if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
                $user_address = new UserAddress();
                $user_address->user_id = $user_id;
                $user_address->name = $order_info['name'];
                $user_address->email = $order_info['email'];
                $user_address->phone = $order_info['phone'];
                $user_address->address = $order_info['address'];
                $user_address->delivery_type = $order_info['delivery_type'];
                $user_address->lat = $order_info['lat'];
                $user_address->lon = $order_info['lon'];
                $user_address->save();
            }

            $address_info = [
                'user_id' => $user_id,
                'contact_person_name' =>  $order_info['name'],
                'contact_person_number' =>  $order_info['phone'],
                'contact_person_email' =>  $order_info['email'],
                'address_type' => $order_info['delivery_type'] ?? '',
                'address' => $order_info['address'] ?? '',
                'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
                'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
            ];

            $cart = session('cart', []);
            $order = $this->createOrder($order_info, $cart,'Mollie', 'success', session()->get('payment_id'), $user_id, $address_info);

            $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
            $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
            return redirect()->route('user.order-details', $order->id)->with($notify_message);

        }else{

            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message'=>$notify_message,'alert-type'=>'error');
            return redirect()->route('payment')->with($notify_message);
        }


    }

    public function pay_via_instamojo(Request $request){


        if (env('APP_MODE') == 'DEMO') {
            $notification = trans('translate.This Is Demo Version. You Can Not Change Anything');
            $notification = array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }

        $price =  round(session('order_data.new_total'), 2);

        $user = Auth::guard('web')->user();

        $instamojo_currency = Currency::findOrFail($this->payment_setting->instamojo_currency_id);

        $price = $price * $instamojo_currency->currency_rate;
        $price = round($price,2);

        $environment = $this->payment_setting->instamojo_account_mode;
        $api_key = $this->payment_setting->instamojo_api_key;
        $auth_token = $this->payment_setting->instamojo_auth_token;

        if ($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url . 'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"
            )
        );

        $order_info = session('order_data');

        $payload = array(
            'purpose' => env("APP_NAME"),
            'amount' => 10,
            'phone' => '918160651749',
            'buyer_name' => $order_info['name'] ?? 'John Doe',
            'redirect_url' => route('response-instamojo'),
            'send_email' => true,
            'webhook' => 'http://www.test.com/webhook/',
            'send_sms' => true,
            'email' => $order_info['email'] ?? 'default@gmail.com',
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);

        if ($response == null) {
            $notification = trans('translate.Unable to connect with Instamojo');
            $notification = array('message' => $notification, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }

        return redirect($response->payment_request->longurl);


    }


    public function instamojo_response(Request $request){


        $environment = $this->payment_setting->instamojo_account_mode;
        $api_key = $this->payment_setting->instamojo_api_key;
        $auth_token = $this->payment_setting->instamojo_auth_token;

        if ($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"
            )
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message'=>$notify_message,'alert-type'=>'error');
            return redirect()->route('payment')->with($notify_message);
        } else {
            $data = json_decode($response);
        }

        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {

                $order_info = session('order_data');
                $user_id = $order_info['is_guest'] == 1 ? $this->generateUniqueUserId() : Auth::user()->id;

                if ($order_info['order_type'] == 'delivery' && $order_info['is_guest'] == 1){
                    $user_address = new UserAddress();
                    $user_address->user_id = $user_id;
                    $user_address->name = $order_info['name'];
                    $user_address->email = $order_info['email'];
                    $user_address->phone = $order_info['phone'];
                    $user_address->address = $order_info['address'];
                    $user_address->delivery_type = $order_info['delivery_type'];
                    $user_address->lat = $order_info['lat'];
                    $user_address->lon = $order_info['lon'];
                    $user_address->save();
                }

                $address_info = [
                    'user_id' => $user_id,
                    'contact_person_name' =>  $order_info['name'],
                    'contact_person_number' =>  $order_info['phone'],
                    'contact_person_email' =>  $order_info['email'],
                    'address_type' => $order_info['delivery_type'] ?? '',
                    'address' => $order_info['address'] ?? '',
                    'longitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lat'] : '',
                    'latitude' => $order_info['order_type'] == 'delivery' ? (string)$order_info['lon'] : '',
                ];

                $cart = session('cart', []);
                $order = $this->createOrder($order_info, $cart,'Instamojo', 'success', $request->get('payment_id'), $user_id, $address_info);

                $notify_message = trans('translate.Your payment has been made successful. Thanks for your new purchase');
                $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
                return redirect()->route('user.order-details', $order->id)->with($notify_message);

            }
        } else {

            $notify_message = trans('translate.Something went wrong, please try again');
            $notify_message = array('message'=>$notify_message,'alert-type'=>'error');
            return redirect()->route('payment')->with($notify_message);
        }


    }

    public function createOrder($order_info, $cart, $payment_method, $payment_status, $tnx_info, $user_id, $address_info): Order
    {
        $order = new Order();
        $order->user_id = $user_id;
        $order->restaurant_id = $order_info['restaurant_id'];
        $order->order_type = $order_info['order_type'];
        $order->address_id = ($order_info['order_type'] == 'delivery' || $order_info['order_type'] == 'pickup') && $order_info['is_guest'] == 1 ? UserAddress::where('user_id', $user_id)?->first()?->id ?? null :  $order_info['address_id'] ?? null;
        $order->delivery_day = $order_info['delivery_time'];
        $order->time_slot_id = $order_info['slots'];
        $order->coupon =$order_info['coupon_code'] ?? '';
        $order->discount_amount =$order_info['discount_amount'] ?? 0;
        $order->delivery_charge = $order_info['delivery_charge'] ?? 0;
        $order->vat = $order_info['vat'] ?? 0;
        $order->total = $order_info['subtotal'];
        $order->grand_total = $order_info['new_total'];
        $order->payment_method = $payment_method;
        $order->payment_status = $payment_status;
        $order->tnx_info = $tnx_info;
        $order->is_guest = $order_info['is_guest'];
        if($payment_status == 'success'){
            $order->order_status = 1;
        }
        $order->delivery_address = json_encode($address_info);
        $order->save();

        foreach ($cart as $food) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $food['product_id'];
            $orderItem->size = json_encode($food['size']);
            $orderItem->addons = json_encode($food['addons']);
            $orderItem->qty = $food['qty'];
            $orderItem->total = $food['total'];
            $orderItem->save();
        }

        session()->forget('order_data');
        session()->forget('cart');


        EmailHelper::mail_setup();

        $template = EmailTemplate::find(5);
        $message = $template->description;
        $subject = $template->subject;

        $message = str_replace('{{order_id}}',$order->id,$message);

        try{

            if($order_info['is_guest'] && $order_info['is_guest'] == 1){

                $message = str_replace('{{user_name}}',$address_info['contact_person_name'] ?? '',$message);

                Mail::to($address_info['contact_person_email'])->send(new NewOrderConfirmation($message,$subject));

            }else{
                $user = User::find($user_id);
                $message = str_replace('{{user_name}}',$user->name,$message);
                $message = str_replace('{{order_id}}',$order->id,$message);

                Mail::to($user->email)->send(new NewOrderConfirmation($message,$subject));
            }



        }catch(Exception $ex){
            Log::info($ex->getMessage());
        }


        try{

            $sms_setting = SmsSetting::where('key', 'new_order_to_user')->first();

            if($sms_setting->value == 'active'){
                $template = SmsTemplate::where('template_key', 'new_order_to_user')->first();

                if($template){
                    $message = $template->description;
                    $subject = $template->subject;

                    if($order_info['is_guest'] && $order_info['is_guest'] == 1){

                        $message = str_replace('{{order_id}}',$order->id,$message);
                        $message = str_replace('{{user_name}}',$address_info['contact_person_name'] ?? '',$message);

                        if($address_info['contact_person_number']){
                            sendMobileOTP($address_info['contact_person_number'] ?? '0', $message);
                        }

                    }else{
                        $user = User::find($user_id);
                        $message = str_replace('{{user_name}}',$user->name,$message);

                        if($user->phone){
                            sendMobileOTP($user->phone, $message);
                        }

                    }

                }
            }

        }catch(Exception $ex){
            Log::info($ex->getMessage());
        }


        return $order;
    }

    private function generateUniqueUserId(): int
    {
        do {
            $userId = random_int(100000, 999999);

            $userExists = User::where('id', $userId)->exists();

        } while ($userExists);

        return $userId;
    }
}
