<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use Modules\Order\App\Models\OrderItem;
use Modules\Currency\App\Models\Currency;
use Modules\SmsSetting\App\Models\SmsSetting;
use Modules\SmsSetting\App\Models\SmsTemplate;
use Modules\EmailSetting\App\Models\EmailTemplate;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Modules\PaymentGateway\App\Models\PaymentGateway;
use Stripe\Checkout\Session as StripeCheckoutSession;
use Modules\Restaurant\Entities\Restaurant;
use Stripe\Checkout\Session as StripSession;
use Stripe\Price;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Product\App\Models\Product;
use App\Models\Cart as UserCart;

class PaymentController extends BaseController
{
    public function api_bank_payment(Request $request){
        
        // Validate request
        $validator = Validator::make($request->all(), [
         'transaction_info' => 'required|string|max:255',
         'order_data' => 'required|array',
         'order_data.address_id' => 'required|integer',
         'order_data.order_type' => 'required|in:delivery,pickup',
         'order_data.delivery_instructions' => 'nullable|string|max:500',
         'order_data.coupon_code' => 'nullable|string',
         ]);
 
         if ($validator->fails()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Validation failed',
                 'errors' => $validator->errors()
             ], 422);
         }
 
         $user = $request->user();
         if (!$user) {
             return response()->json([
                 'success' => false,
                 'message' => 'Unauthorized'
             ], 401);
         }
 
         $address = UserAddress::find($request->order_data['address_id']);
         if (!$address) {
             return response()->json([
                 'success' => false,
                 'message' => 'Address not found'
             ], 404);
         }
 
         $cart = Cart::where('user_id', $user->id)->get();
         if ($cart->isEmpty()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Cart is empty'
             ], 404);
         }
 
         $order_info = $request->order_data;
         $order_info['restaurant_id'] = $cart->first()->product->restaurant_id;
         $order_info['is_guest'] = $user->id ? 0 : 1;
         $order_info['address_id'] = $address->id;
         $order_info['coupon_code'] = $request->order_data['coupon_code'] ?? '';
         $order_info['discount_amount'] = $request->order_data['discount_amount'] ?? 0;
         $order_info['delivery_charge'] = $request->order_data['delivery_charge'] ?? 0;
         $order_info['vat'] = $request->order_data['vat'] ?? 0;
         $order_info['subtotal'] = $cart->sum('total_price');
         $order_info['new_total'] = $order_info['subtotal'] + $order_info['delivery_charge'] + $order_info['vat'] - $order_info['discount_amount'];
         $order_info['payment_method'] = 'Bank Transfer';
         $order_info['payment_status'] = 'pending';
         $order_info['tnx_info'] = $request->transaction_info;
 
 
         $order = $this->createOrder($order_info, $cart, $order_info['payment_method'], $order_info['payment_status'], $order_info['tnx_info'], $user->id, $address);
 
         Cart::where('user_id', $user->id)->delete();
 
         return response()->json([
             'success' => true,
             'message' => 'Order placed successfully',
             'order' => $order
         ], 200);
        
 
     }

     
    public function pay_with_stripe(Request $request)
    {
        try {
            // Remove the early return that was preventing execution
            // return $request->all();

            if(env('APP_MODE') == 'DEMO'){
                $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
                return response()->json(['message' => $notification], 403);
            }

            $stripe_currency_id = optional(PaymentGateway::where('key','stripe_currency_id')->first())->value;
            $stripe_secret      = optional(PaymentGateway::where('key','stripe_secret')->first())->value ?? env('STRIPE_SECRET');
            $currency           = Currency::find($stripe_currency_id);

            if (!$stripe_secret) {
                Log::error('Stripe secret key not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Stripe configuration error'
                ], 500);
            }

            if (!$currency) {
                Log::error('Stripe currency not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Currency configuration error'
                ], 500);
            }

            \Stripe\Stripe::setApiKey($stripe_secret);

            // Fix: Use Sanctum guard instead of JWT guard for API
           $user = Auth::guard('sanctum')->user(); 

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            $address = UserAddress::find($request->address_id);
            if (!$address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Address not found'
                ], 404);
            }

            $cart = Cart::where('user_id', $user->id)->get();
            if ($cart->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 404);
            }

            $order_info['restaurant_id'] = $cart->first()->product->restaurant_id;
            $order_info['is_guest'] = $user->id ? 0 : 1;
            $order_info['address_id'] = $address->id;
            $order_info['coupon_code'] = $request->coupon_code ?? '';
            $order_info['discount_amount'] = $request->discount_amount ?? 0;
            $order_info['delivery_charge'] = $request->delivery_charge ?? 0;
            $order_info['vat'] = $request->vat ?? 0;
            $order_info['order_type'] = $request->order_type;
            $order_info['subtotal'] = $cart->sum('total_price');
            $order_info['new_total'] = $order_info['subtotal'] + $order_info['delivery_charge'] + $order_info['vat'] - $order_info['discount_amount'];
            $order_info['payment_method'] = 'Stripe';
            $order_info['payment_status'] = 'success';

            $lineItems = [];

            foreach ($cart as $item) {
                $sub_total = $order_info['subtotal'] + $order_info['delivery_charge'] + $order_info['vat'] - $order_info['discount_amount'];;
                
                $product = Product::find($item->product_id);

                $price = Price::create([
                    'unit_amount' => $sub_total * 100, // Price in cents
                    'currency' => $currency->currency_code,
                    'product_data' => [
                        'name' => $product?->name ?? 'Test name',
                    ],
                ]);

                $lineItems[] = [
                    'price' => $price->id,
                    'quantity' => 1,
                ];
            }
            

            // Generate a unique payment token for this session
            $paymentToken = Str::random(32);
            
            $checkoutSession = StripSession::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment-api.webview-stripe-success') . '?payment_token=' . $paymentToken,
                'cancel_url' => route('payment-api.webview-stripe-faild'),
            ]);
            
            // Store payment data in cache instead of session for better reliability
            $paymentData = [
                'auth_user' => $user,
                'checkoutSessionId' => $checkoutSession->id,
                'order_info' => $order_info,
                'address' => $address,
                'cart' => $cart,
                'user_id' => $user->id,
                'created_at' => now()
            ];
            
            // Store in cache for 30 minutes (enough time for payment completion)
            Cache::put("stripe_payment_{$paymentToken}", $paymentData, 1800);
            
            // Also try to store in session as fallback for web context
            try {
                Session::put('auth_user', $user);
                Session::put('checkoutSessionId', $checkoutSession->id);
                Session::put('order_info', $order_info);
                Session::put('address', $address);
                Session::put('cart', $cart);
                Session::put('payment_token', $paymentToken);
            } catch (Exception $e) {
                Log::info('Session storage failed, using cache only: ' . $e->getMessage());
            }

            Log::info('Stripe checkout session created successfully', [
                'user_id' => $user->id,
                'session_id' => $checkoutSession->id,
                'payment_token' => $paymentToken
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stripe checkout session created successfully',
                'data' => [
                    'checkout_url' => $checkoutSession->url,
                    'payment_token' => $paymentToken
                ]
            ]);
        } catch (Exception $e) {
            Log::error('Stripe payment creation failed: ' . $e->getMessage(), [
                'user_id' => $request->user()?->id ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Payment creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function webview_stripe_success(Request $request){
        try {
            Log::info('Stripe success callback received', [
                'request_data' => $request->all(),
                'has_payment_token' => $request->has('payment_token'),
                'payment_token' => $request->get('payment_token')
            ]);

            $stripe_currency_id = optional(PaymentGateway::where('key','stripe_currency_id')->first())->value;
            $stripe_secret      = optional(PaymentGateway::where('key','stripe_secret')->first())->value ?? env('STRIPE_SECRET');
            $currency           = Currency::find($stripe_currency_id);

            \Stripe\Stripe::setApiKey($stripe_secret);

            // Try to get data from multiple sources for reliability
            $checkoutSessionId = null;
            $order_info = null;
            $address = null;
            $user = null;
            $cart = null;
            
            // First try to get from URL parameter (most reliable)
            if ($request->has('payment_token')) {
                $paymentData = Cache::get("stripe_payment_{$request->payment_token}");
                Log::info('Payment data from cache', [
                    'payment_token' => $request->payment_token,
                    'data_found' => !empty($paymentData),
                    'data_keys' => $paymentData ? array_keys($paymentData) : []
                ]);
                
                if ($paymentData) {
                    $checkoutSessionId = $paymentData['checkoutSessionId'];
                    $order_info = $paymentData['order_info'];
                    $address = $paymentData['address'];
                    $user = $paymentData['auth_user'];
                    $cart = $paymentData['cart'];
                }
            }
            
            // Fallback to session data
            if (!$checkoutSessionId) {
                Log::info('Trying session fallback');
                $checkoutSessionId = Session::get('checkoutSessionId');
                $order_info = Session::get('order_info');
                $address = Session::get('address');
                $user = Session::get('auth_user');
                $cart = Session::get('cart');
                
                Log::info('Session data retrieved', [
                    'has_session' => !empty($checkoutSessionId),
                    'session_keys' => Session::all()
                ]);
            }
            
            // Final fallback - try to get from cache using session token
            if (!$checkoutSessionId && Session::has('payment_token')) {
                Log::info('Trying cache with session token fallback');
                $paymentData = Cache::get("stripe_payment_" . Session::get('payment_token'));
                if ($paymentData) {
                    $checkoutSessionId = $paymentData['checkoutSessionId'];
                    $order_info = $paymentData['order_info'];
                    $address = $paymentData['address'];
                    $user = $paymentData['auth_user'];
                    $cart = $paymentData['cart'];
                }
            }

            Log::info('Payment data summary', [
                'checkoutSessionId' => !empty($checkoutSessionId),
                'order_info' => !empty($order_info),
                'address' => !empty($address),
                'user' => !empty($user),
                'cart' => !empty($cart)
            ]);

            if($checkoutSessionId && $order_info && $address && $user && $cart){

                try {
                    $stripe_session = StripSession::retrieve($checkoutSessionId);

                    if($stripe_session->payment_status == 'paid'){
                        $transaction_id = $stripe_session->payment_intent;

                        $order = $this->createOrder($order_info, $cart, "Stripe", "success", $transaction_id, $user->id, $address);

                        Cart::where('user_id', $user->id)->delete();

                        // Clean up cache and session
                        if ($request->has('payment_token')) {
                            Cache::forget("stripe_payment_{$request->payment_token}");
                        }
                        if (Session::has('payment_token')) {
                            Cache::forget("stripe_payment_" . Session::get('payment_token'));
                        }
                        
                        Session::forget(['auth_user', 'checkoutSessionId', 'order_info', 'address', 'cart', 'payment_token']);

                        Log::info('Order created successfully', [
                            'order_id' => $order->id,
                            'user_id' => $user->id
                        ]);

                        return response()->json([
                            'success' => true,
                            'message' => 'Order placed successfully',
                            'order' => $order
                        ], 200);

                    }else{
                        Log::warning('Stripe payment not paid', [
                            'payment_status' => $stripe_session->payment_status,
                            'session_id' => $checkoutSessionId
                        ]);
                        
                        return response()->json([
                            'success' => false,
                            'message' => 'Payment is failed'
                        ], 404);
                    }
                } catch (\Exception $e) {
                    Log::error('Stripe payment verification failed: ' . $e->getMessage(), [
                        'session_id' => $checkoutSessionId,
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Server error occurred, please try again'
                    ], 404);
                }
            }else{
                Log::error('Payment data not found for Stripe success callback', [
                    'missing_data' => [
                        'checkoutSessionId' => empty($checkoutSessionId),
                        'order_info' => empty($order_info),
                        'address' => empty($address),
                        'user' => empty($user),
                        'cart' => empty($cart)
                    ]
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Payment data not found, please try again'
                ], 404);
            }
        } catch (Exception $e) {
            Log::error('Unexpected error in Stripe success callback: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error occurred'
            ], 500);
        }
    }

    public function webview_stripe_faild(Request $request){

        return response()->json([
            'success' => false,
            'message' => 'Your payment is faild, please try again',
        ], 404);
    }


    public function createOrder($order_info, $cart, $payment_method, $payment_status, $tnx_info, $user_id, $address_info)
    {

        $restaurant = Restaurant::find($order_info['restaurant_id']);

        $order = new Order();
        $order->user_id = $user_id;
        $order->restaurant_id = $order_info['restaurant_id'];
        $order->order_type = $order_info['order_type'];
        $order->address_id = ($order_info['order_type'] == 'delivery' || $order_info['order_type'] == 'pickup') && $order_info['is_guest'] == 1 ? UserAddress::where('user_id', $user_id)?->first()?->id ?? null :  $order_info['address_id'] ?? null;
        $order->delivery_day = $restaurant->max_processing_time;
        $order->time_slot_id = $restaurant->time_slot_separate;
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
        $order->order_status = 1;
        $order->delivery_address = json_encode($address_info);
        $order->save();

        foreach ($cart as $food) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $food['product_id'];
            $orderItem->size = json_encode([$food['size'] => $food['size_price'] ?? 0]);
            $orderItem->addons = json_encode($food['addons']);
            $orderItem->qty = $food['qty'];
            $orderItem->total = $food['total_price'];
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
    
    public function paypal_webview(Request $request){
        
        return $user = Auth::guard('sanctum')->user(); 

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


    public function razorpay_webview(Request $request){
        try {
            if(env('APP_MODE') == 'DEMO'){
                return response()->json([
                    'success' => false,
                    'message' => 'This Is Demo Version. You Can Not Change Anything'
                ], 403);
            }

            // Get Razorpay configuration from PaymentGateway settings
            $razorpay_key = optional(PaymentGateway::where('key','razorpay_key')->first())->value ?? env('RAZORPAY_KEY');
            $razorpay_secret = optional(PaymentGateway::where('key','razorpay_secret')->first())->value ?? env('RAZORPAY_SECRET');
            $razorpay_currency_id = optional(PaymentGateway::where('key','razorpay_currency_id')->first())->value;
            $currency = Currency::find($razorpay_currency_id);

            if (!$razorpay_key || !$razorpay_secret) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay configuration not found'
                ], 500);
            }

            if (!$currency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay currency not found'
                ], 500);
            }

            // Get authenticated user
            $user = Auth::guard('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Get cart items
            $cart = Cart::where('user_id', $user->id)->get();
            if ($cart->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 404);
            }

            // Calculate total amount
            $subtotal = $cart->sum('total_price');
            $delivery_charge = $request->delivery_charge ?? 0;
            $vat = $request->vat ?? 0;
            $discount_amount = $request->discount_amount ?? 0;
            $total_amount = $subtotal + $delivery_charge + $vat - $discount_amount;

            // Generate unique payment token
            $paymentToken = Str::random(32);

            // Prepare order data
            $order_data = [
                'restaurant_id' => $cart->first()->product->restaurant_id,
                'order_type' => $request->order_type ?? 'delivery',
                'delivery_instructions' => $request->delivery_instructions ?? '',
                'coupon_code' => $request->coupon_code ?? '',
                'discount_amount' => $discount_amount,
                'delivery_charge' => $delivery_charge,
                'vat' => $vat,
                'subtotal' => $subtotal,
                'total_amount' => $total_amount,
                'address_id' => $request->address_id,
                'user_id' => $user->id
            ];

            // Store payment data in cache
            $paymentData = [
                'auth_user' => $user,
                'order_data' => $order_data,
                'cart' => $cart,
                'razorpay_key' => $razorpay_key,
                'razorpay_secret' => $razorpay_secret,
                'currency' => $currency,
                'created_at' => now()
            ];

            Cache::put("razorpay_payment_{$paymentToken}", $paymentData, 1800); // 30 minutes

            // Also try to store in session as fallback
            try {
                Session::put('auth_user', $user);
                Session::put('order_data', $order_data);
                Session::put('cart', $cart);
                Session::put('payment_token', $paymentToken);
                Session::put('razorpay_key', $razorpay_key);
                Session::put('razorpay_secret', $razorpay_secret);
                Session::put('currency', $currency);
            } catch (Exception $e) {
                Log::info('Session storage failed, using cache only: ' . $e->getMessage());
            }

            // Return the payment data for frontend to create Razorpay order
            return response()->json([
                'success' => true,
                'message' => 'Razorpay payment data prepared successfully',
                'data' => [
                    'payment_token' => $paymentToken,
                    'razorpay_key' => $razorpay_key,
                    'amount' => $total_amount * 100, // Razorpay expects amount in paise
                    'currency' => $currency->currency_code,
                    'order_data' => $order_data,
                    'cart_summary' => [
                        'item_count' => $cart->count(),
                        'subtotal' => $subtotal,
                        'delivery_charge' => $delivery_charge,
                        'vat' => $vat,
                        'discount_amount' => $discount_amount,
                        'total_amount' => $total_amount
                    ]
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Razorpay webview preparation failed: ' . $e->getMessage(), [
                'user_id' => $request->user()?->id ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Payment preparation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function razorpay_webview_payment(Request $request){
        try {
            Log::info('Razorpay payment callback received', [
                'request_data' => $request->all(),
                'has_payment_token' => $request->has('payment_token'),
                'payment_token' => $request->get('payment_token')
            ]);

            // Get Razorpay configuration
            $razorpay_key = optional(PaymentGateway::where('key','razorpay_key')->first())->value ?? env('RAZORPAY_KEY');
            $razorpay_secret = optional(PaymentGateway::where('key','razorpay_secret')->first())->value ?? env('RAZORPAY_SECRET');

            if (!$razorpay_key || !$razorpay_secret) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay configuration not found'
                ], 500);
            }

            // Try to get payment data from multiple sources
            $paymentData = null;
            $user = null;
            $order_data = null;
            $cart = null;

            // First try to get from URL parameter
            if ($request->has('payment_token')) {
                $paymentData = Cache::get("razorpay_payment_{$request->payment_token}");
                if ($paymentData) {
                    $user = $paymentData['auth_user'];
                    $order_data = $paymentData['order_data'];
                    $cart = $paymentData['cart'];
                }
            }

            // Fallback to session data
            if (!$paymentData) {
                $user = Session::get('auth_user');
                $order_data = Session::get('order_data');
                $cart = Session::get('cart');
            }

            // Final fallback - try to get from cache using session token
            if (!$paymentData && Session::has('payment_token')) {
                $paymentData = Cache::get("razorpay_payment_" . Session::get('payment_token'));
                if ($paymentData) {
                    $user = $paymentData['auth_user'];
                    $order_data = $paymentData['order_data'];
                    $cart = $paymentData['cart'];
                }
            }

            if (!$user || !$order_data || !$cart) {
                Log::error('Payment data not found for Razorpay callback');
                return response()->json([
                    'success' => false,
                    'message' => 'Payment data not found, please try again'
                ], 404);
            }

            // Verify Razorpay payment
            $api = new Api($razorpay_key, $razorpay_secret);
            $input = $request->all();

            if (empty($input['razorpay_payment_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment ID not provided'
                ], 400);
            }

            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);
                $payId = $response->id;

                // Get address information
                $address = UserAddress::find($order_data['address_id']);
                if (!$address) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Address not found'
                    ], 404);
                }

                // Create order
                $order = $this->createOrder($order_data, $cart, 'Razorpay', 'success', $payId, $user->id, $address);

                // Clear cart
                Cart::where('user_id', $user->id)->delete();

                // Clean up cache and session
                if ($request->has('payment_token')) {
                    Cache::forget("razorpay_payment_{$request->payment_token}");
                }
                if (Session::has('payment_token')) {
                    Cache::forget("razorpay_payment_" . Session::get('payment_token'));
                }
                
                Session::forget(['auth_user', 'order_data', 'cart', 'payment_token', 'razorpay_key', 'razorpay_secret', 'currency']);

                Log::info('Razorpay order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'payment_id' => $payId
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'order' => $order,
                    'payment_id' => $payId
                ], 200);

            } catch (Exception $e) {
                Log::error('Razorpay payment verification failed: ' . $e->getMessage(), [
                    'payment_id' => $input['razorpay_payment_id'] ?? 'unknown',
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed: ' . $e->getMessage()
                ], 400);
            }

        } catch (Exception $e) {
            Log::error('Unexpected error in Razorpay payment callback: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error occurred',
                'url' => url()->current()
            ], 500);
        }
    }

    /**
     * Web-based Razorpay webview for displaying payment form
     */
    public function razorpay_webview_web(Request $request){
        try {
            if(env('APP_MODE') == 'DEMO'){
                return view('frontend.webview.razorpay', [
                    'payment_data' => [
                        'success' => false,
                        'message' => 'This Is Demo Version. You Can Not Change Anything'
                    ]
                ]);
            }

            // Get payment token from request
            $payment_token = $request->get('payment_token');
            if (!$payment_token) {
                return view('frontend.webview.razorpay', [
                    'payment_data' => [
                        'success' => false,
                        'message' => 'Payment token not provided'
                    ]
                ]);
            }

            // Get payment data from cache
            $paymentData = Cache::get("razorpay_payment_{$payment_token}");
            if (!$paymentData) {
                return view('frontend.webview.razorpay', [
                    'payment_data' => [
                        'success' => false,
                        'message' => 'Payment data not found or expired'
                    ]
                ]);
            }

            // Prepare payment data for view
            $razorpay_key = $paymentData['razorpay_key'];
            $currency = $paymentData['currency'];
            $order_data = $paymentData['order_data'];
            $cart = $paymentData['cart'];

            $subtotal = $cart->sum('total_price');
            $delivery_charge = $order_data['delivery_charge'] ?? 0;
            $vat = $order_data['vat'] ?? 0;
            $discount_amount = $order_data['discount_amount'] ?? 0;
            $total_amount = $subtotal + $delivery_charge + $vat - $discount_amount;

            $payment_data = [
                'success' => true,
                'data' => [
                    'payment_token' => $payment_token,
                    'razorpay_key' => $razorpay_key,
                    'amount' => $total_amount * 100, // Razorpay expects amount in paise
                    'currency' => $currency->currency_code,
                    'order_data' => $order_data,
                    'cart_summary' => [
                        'item_count' => $cart->count(),
                        'subtotal' => $subtotal,
                        'delivery_charge' => $delivery_charge,
                        'vat' => $vat,
                        'discount_amount' => $discount_amount,
                        'total_amount' => $total_amount
                    ]
                ]
            ];

            return view('frontend.webview.razorpay', compact('payment_data'));

        } catch (Exception $e) {
            Log::error('Razorpay webview web preparation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('frontend.webview.razorpay', [
                'payment_data' => [
                    'success' => false,
                    'message' => 'Payment preparation failed: ' . $e->getMessage()
                ]
            ]);
        }
    }

    

}
