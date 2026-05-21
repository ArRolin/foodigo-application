<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Api\BaseController;
use App\Models\Cart;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Modules\Currency\App\Models\Currency;
use Modules\Restaurant\Entities\Restaurant;
use Modules\PaymentGateway\App\Models\PaymentGateway;

class CheckoutController extends BaseController
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


    /**
     * Get checkout information including cart, addresses, and payment methods
     */
    public function getCheckoutInfo(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Get user's cart items
            $cartItems = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->with(['product' => function($query) {
                    $query->with(['restaurant', 'category'])
                          ->withAvg('reviews', 'rating')
                          ->withCount('reviews');
                }, 'restaurant'])
                ->get();

            if ($cartItems->isEmpty()) {
                return $this->sendError('Your cart is empty! Please add food first', [], 400);
            }

            // Get user addresses
            $addresses = UserAddress::where('user_id', $user->id)->get();

            $payment_data = PaymentGateway::all();


            $payment_setting = array();
    
            foreach($payment_data as $data_item){
                $payment_setting[$data_item->key] = $data_item->value;
            }
    
            $payment_setting = (object) $payment_setting;

            // Calculate cart totals
            $subtotal = $cartItems->sum('total_price');
            $deliveryFee = $this->calculateDeliveryFee($cartItems, $request);
            $tax = $this->calculateTax($subtotal);
            $total = $subtotal + $deliveryFee + $tax;

            // Get restaurant information
            $restaurant = $cartItems->first()->restaurant;

            // Check delivery availability
            $deliveryAvailable = $this->checkDeliveryAvailability($restaurant, $request);

            $data = [
                'cart_summary' => [
                    'total_items' => $cartItems->sum('qty'),
                    'cart_count' => $cartItems->count(),
                    'subtotal' => $subtotal,
                    'delivery_fee' => $deliveryFee,
                    'tax' => $tax,
                    'total' => $total,
                ],
                'cart_items' => $cartItems->map(function ($cartItem) {
                    return [
                        'cart_id' => $cartItem->id,
                        'product_id' => $cartItem->product_id,
                        'product_name' => $cartItem->product->name ?? 'Unknown Product',
                        'product_image' => $cartItem->product->image ?? null,
                        'size' => $cartItem->size,
                        'qty' => $cartItem->qty,
                        'unit_price' => $cartItem->size_price,
                        'addon_price' => $cartItem->addon_price,
                        'total_price' => $cartItem->total_price,
                        'addons' => $cartItem->addons,
                    ];
                }),
                'restaurant' => $restaurant ? [
                    'id' => $restaurant->id,
                    'name' => $restaurant->restaurant_name,
                    'slug' => $restaurant->slug,
                    'image' => $restaurant->image,
                    'address' => $restaurant->address,
                    'phone' => $restaurant->phone,
                    'delivery_time' => $restaurant->delivery_time ?? '30-45 min',
                    'minimum_order' => $restaurant->minimum_order ?? 0,
                    'delivery_fee' => $restaurant->delivery_fee ?? 0,
                    'max_delivery_distance' => $restaurant->max_delivery_distance ?? 10,
                ] : null,
                'addresses' => $addresses->map(function ($address) {
                    return [
                        'id' => $address->id,
                        'name' => $address->name,
                        'phone' => $address->phone,
                        'email' => $address->email,
                        'address' => $address->address,
                        'delivery_type' => $address->delivery_type,
                        'lat' => $address->lat,
                        'lon' => $address->lon,
                        'is_default' => $address->is_default ?? false,
                    ];
                }),
                'payment_methods' => $payment_setting,
                'delivery_available' => $deliveryAvailable,
                'order_types' => [
                    'delivery' => [
                        'available' => $deliveryAvailable,
                        'estimated_time' => '30-45 minutes',
                        'fee' => $deliveryFee,
                    ],
                    'pickup' => [
                        'available' => true,
                        'estimated_time' => '15-20 minutes',
                        'fee' => 0,
                    ],
                ],
            ];

            return $this->sendResponse($data, 'Checkout information retrieved successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve checkout information', [], 500);
        }
    }

    /**
     * Get all available payment methods
     */
    public function getPaymentMethods(): JsonResponse
    {
        try {

            $payment_data = PaymentGateway::all();


            $payment_setting = array();
    
            foreach($payment_data as $data_item){
                $payment_setting[$data_item->key] = $data_item->value;
            }
    
            $payment_setting = (object) $payment_setting;


            return $this->sendResponse([
                'payment_methods' => $payment_setting,
            ], 'Payment methods retrieved successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve payment methods', [], 500);
        }
    }

    /**
     * Validate checkout data and prepare order
     */
    public function validateCheckout(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'address_id' => 'required|exists:user_addresses,id',
                'order_type' => 'required|in:delivery,pickup',
                'delivery_instructions' => 'nullable|string|max:500',
                'coupon_code' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors()->toArray());
            }

            $user = $request->user();
            
            // Verify address belongs to user
            $address = UserAddress::where('id', $request->address_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$address) {
                return $this->sendError('Invalid address selected', [], 400);
            }

            // Get cart items
            $cartItems = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->with(['product.restaurant'])
                ->get();

            if ($cartItems->isEmpty()) {
                return $this->sendError('Your cart is empty', [], 400);
            }

            // Get restaurant information
            $restaurant = $cartItems->first()->restaurant;
            
            // Check delivery availability if delivery order
            $deliveryAvailable = false;
            $distance = 0;
            $deliveryFee = 0;
            
            if ($request->order_type === 'delivery') {
                $deliveryAvailable = $this->checkDeliveryAvailability($restaurant, $request, $address);
                
                if (!$deliveryAvailable) {
                    return $this->sendError('Delivery not available to this address', [], 400);
                }
                
                // Calculate distance and delivery fee
                if ($address->lat && $address->lon && $restaurant->latitude && $restaurant->longitude) {
                    $distance = $this->calculateDistance(
                        $restaurant->latitude,
                        $restaurant->longitude,
                        $address->lat,
                        $address->lon
                    );
                    
                    $deliveryFee = $this->calculateDeliveryFee($restaurant, $distance);
                } else {
                    $deliveryFee = $restaurant->delivery_fee ?? 0;
                }
            }

            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $tax = $this->calculateTax($subtotal);
            $total = $subtotal + $deliveryFee + $tax;

            // Apply coupon if provided
            $couponDiscount = 0;
            $finalTotal = $total;
            
            if ($request->coupon_code) {
                $couponResult = $this->applyCoupon($request->coupon_code, $subtotal);
                if ($couponResult['success']) {
                    $couponDiscount = $couponResult['discount'];
                    $finalTotal = $total - $couponDiscount;
                }
            }

            // Check minimum order requirement
            $minimumOrderMet = $subtotal >= ($restaurant->minimum_order ?? 0);
            
            // Prepare detailed response
            $response = [
                'validation' => [
                    'address_valid' => true,
                    'delivery_available' => $request->order_type === 'delivery' ? $deliveryAvailable : true,
                    'payment_method_valid' => true,
                    'cart_valid' => true,
                    'distance_valid' => $request->order_type === 'delivery' ? ($distance <= ($restaurant->max_delivery_distance ?? 10)) : true,
                    'minimum_order_met' => $minimumOrderMet,
                ],
                'order_summary' => [
                    'cart_items_count' => $cartItems->count(),
                    'total_quantity' => $cartItems->sum('qty'),
                    'order_type' => $request->order_type,
                    'payment_method' => $request->payment_method,
                ],
                'delivery_info' => $request->order_type === 'delivery' ? [
                    'distance_km' => round($distance, 2),
                    'max_delivery_distance' => $restaurant->max_delivery_distance ?? 10,
                    'delivery_available' => $deliveryAvailable,
                    'estimated_delivery_time' => $this->calculateEstimatedDeliveryTime($distance),
                    'delivery_instructions' => $request->delivery_instructions,
                ] : null,
                'pricing_breakdown' => [
                    'subtotal' => round($subtotal, 2),
                    'delivery_fee' => round($deliveryFee, 2),
                    'tax_amount' => round($tax, 2),
                    'tax_rate' => round($this->getTaxRate() * 100, 1) . '%',
                    'coupon_discount' => round($couponDiscount, 2),
                    'total_amount' => round($finalTotal, 2),
                ],
                'restaurant_info' => [
                    'id' => $restaurant->id,
                    'name' => $restaurant->restaurant_name,
                    'address' => $restaurant->address,
                    'phone' => $restaurant->phone,
                    'delivery_fee_base' => $restaurant->delivery_fee ?? 0,
                    'minimum_order' => $restaurant->minimum_order ?? 0,
                    'max_delivery_distance' => $restaurant->max_delivery_distance ?? 10,
                ],
                'address_info' => [
                    'id' => $address->id,
                    'name' => $address->name,
                    'address' => $address->address,
                    'phone' => $address->phone,
                    'email' => $address->email,
                    'delivery_type' => $address->delivery_type,
                    'coordinates' => [
                        'lat' => $address->lat,
                        'lon' => $address->lon,
                    ],
                ],
                'next_steps' => [
                    'can_proceed' => $minimumOrderMet && $deliveryAvailable,
                    'message' => $minimumOrderMet && $deliveryAvailable 
                        ? 'Checkout validation successful. You can now proceed to payment.' 
                        : 'Checkout validation completed with issues.',
                    'required_actions' => $this->getRequiredActions($minimumOrderMet, $deliveryAvailable, $subtotal, $restaurant->minimum_order ?? 0),
                ]
            ];

            return $this->sendResponse($response, 'Checkout validation successful');

        } catch (\Exception $e) {
            return $this->sendError('Failed to validate checkout', [], 500);
        }
    }

    /**
     * Get payment gateways with configuration
     */
    private function getPaymentGateways(): array
    {
        $paymentData = PaymentGateway::all();
        $paymentGateways = [];

        foreach ($paymentData as $gateway) {
            $config = json_decode($gateway->value, true);
            
            if ($config && isset($config['status']) && $config['status'] === 'enable') {
                $paymentGateways[] = [
                    'key' => $gateway->key,
                    'name' => $this->getPaymentMethodName($gateway->key),
                    'description' => $this->getPaymentMethodDescription($gateway->key),
                    'icon' => $this->getPaymentMethodIcon($gateway->key),
                    'status' => $config['status'],
                    'config' => $config,
                    'supported_currencies' => $this->getSupportedCurrencies($gateway->key),
                    'processing_fee' => $config['processing_fee'] ?? 0,
                    'processing_fee_type' => $config['processing_fee_type'] ?? 'fixed',
                ];
            }
        }

        return $paymentGateways;
    }

    /**
     * Get payment method display name
     */
    private function getPaymentMethodName(string $key): string
    {
        $names = [
            'stripe' => 'Credit/Debit Card (Stripe)',
            'paypal' => 'PayPal',
            'razorpay' => 'Razorpay',
            'flutterwave' => 'Flutterwave',
            'paystack' => 'Paystack',
            'mollie' => 'Mollie',
            'iyzico' => 'Iyzico',
            'mercadopago' => 'MercadoPago',
            'paytm' => 'Paytm',
            'phonepe' => 'PhonePe',
            'cash_on_delivery' => 'Cash on Delivery',
            'bank_transfer' => 'Bank Transfer',
        ];

        return $names[$key] ?? ucfirst(str_replace('_', ' ', $key));
    }

    /**
     * Get payment method description
     */
    private function getPaymentMethodDescription(string $key): string
    {
        $descriptions = [
            'stripe' => 'Pay securely with your credit or debit card',
            'paypal' => 'Pay with your PayPal account or credit card',
            'razorpay' => 'Secure payment gateway for Indian customers',
            'flutterwave' => 'African payment gateway supporting multiple methods',
            'paystack' => 'Nigerian payment gateway for seamless transactions',
            'mollie' => 'European payment gateway with multiple options',
            'iyzico' => 'Turkish payment gateway for local customers',
            'mercadopago' => 'Latin American payment gateway',
            'paytm' => 'Indian digital payment platform',
            'phonepe' => 'Indian UPI-based payment solution',
            'cash_on_delivery' => 'Pay with cash when your order is delivered',
            'bank_transfer' => 'Direct bank transfer to our account',
        ];

        return $descriptions[$key] ?? 'Secure payment method';
    }

    /**
     * Get payment method icon
     */
    private function getPaymentMethodIcon(string $key): string
    {
        $icons = [
            'stripe' => 'credit-card',
            'paypal' => 'paypal',
            'razorpay' => 'razorpay',
            'flutterwave' => 'flutterwave',
            'paystack' => 'paystack',
            'mollie' => 'mollie',
            'iyzico' => 'iyzico',
            'mercadopago' => 'mercadopago',
            'paytm' => 'paytm',
            'phonepe' => 'phonepe',
            'cash_on_delivery' => 'money-bill',
            'bank_transfer' => 'university',
        ];

        return $icons[$key] ?? 'credit-card';
    }

    /**
     * Get supported currencies for payment method
     */
    private function getSupportedCurrencies(string $key): array
    {
        $currencies = [
            'stripe' => ['USD', 'EUR', 'GBP', 'CAD', 'AUD'],
            'paypal' => ['USD', 'EUR', 'GBP', 'CAD', 'AUD'],
            'razorpay' => ['INR', 'USD'],
            'flutterwave' => ['NGN', 'USD', 'EUR', 'GBP'],
            'paystack' => ['NGN', 'USD', 'GHS', 'ZAR'],
            'mollie' => ['EUR', 'USD', 'GBP'],
            'iyzico' => ['TRY', 'USD', 'EUR'],
            'mercadopago' => ['ARS', 'BRL', 'CLP', 'COP', 'MXN', 'PEN', 'UYU'],
            'paytm' => ['INR'],
            'phonepe' => ['INR'],
            'cash_on_delivery' => ['USD', 'EUR', 'GBP', 'INR'],
            'bank_transfer' => ['USD', 'EUR', 'GBP', 'INR'],
        ];

        return $currencies[$key] ?? ['USD'];
    }

    /**
     * Calculate delivery fee based on distance
     */
    private function calculateDeliveryFee($restaurant, float $distance): float
    {
        $baseDeliveryFee = $restaurant->delivery_fee ?? 0;
        
        // Add distance-based fee
        if ($distance > 5) { // 5km base distance
            $extraDistance = $distance - 5;
            $baseDeliveryFee += ($extraDistance * 0.5); // $0.50 per extra km
        }

        return round($baseDeliveryFee, 2);
    }

    /**
     * Calculate tax
     */
    private function calculateTax(float $subtotal): float
    {
        $taxRate = $this->getTaxRate();
        return round($subtotal * $taxRate, 2);
    }

    /**
     * Get tax rate from settings
     */
    private function getTaxRate(): float
    {
        // This should come from your global settings
        // For now, using a default value
        return 0.08; // 8% tax rate
    }

    /**
     * Check delivery availability
     */
    private function checkDeliveryAvailability($restaurant, Request $request, $address = null): bool
    {
        if (!$restaurant) {
            return false;
        }

        // Check if restaurant is open and available
        if ($restaurant->is_banned === 'enable' || $restaurant->admin_approval === 'disable') {
            return false;
        }

        // Check delivery distance if address provided
        if ($address && $address->lat && $address->lon) {
            $distance = $this->calculateDistance(
                $restaurant->latitude ?? 0,
                $restaurant->longitude ?? 0,
                $address->lat,
                $address->lon
            );

            $maxDistance = $restaurant->max_delivery_distance ?? 10;
            if ($distance > $maxDistance) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate distance between two points
     */
    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        
        return round($miles * 1.609344, 2); // Convert to kilometers
    }

    /**
     * Calculate estimated delivery time based on distance
     */
    private function calculateEstimatedDeliveryTime(float $distance): string
    {
        if ($distance <= 2) {
            return '20-30 minutes';
        } elseif ($distance <= 5) {
            return '30-45 minutes';
        } elseif ($distance <= 8) {
            return '45-60 minutes';
        } else {
            return '60-90 minutes';
        }
    }

    /**
     * Get required actions based on validation results
     */
    private function getRequiredActions(bool $minimumOrderMet, bool $deliveryAvailable, float $subtotal, float $minimumOrder): array
    {
        $actions = [];
        
        if (!$minimumOrderMet) {
            $actions[] = [
                'type' => 'minimum_order',
                'message' => "Minimum order amount is $" . number_format($minimumOrder, 2) . ". Current subtotal: $" . number_format($subtotal, 2),
                'required_amount' => $minimumOrder - $subtotal,
                'action' => 'Add more items to cart'
            ];
        }
        
        if (!$deliveryAvailable) {
            $actions[] = [
                'type' => 'delivery_unavailable',
                'message' => 'Delivery is not available to this address',
                'action' => 'Choose a different address or select pickup'
            ];
        }
        
        return $actions;
    }

    /**
     * Apply coupon to order
     */
    private function applyCoupon(string $couponCode, float $subtotal): array
    {
        // This would integrate with your existing coupon system
        // For now, returning a simple structure
        return [
            'success' => false,
            'discount' => 0,
            'message' => 'Coupon system not implemented yet'
        ];
    }
}
