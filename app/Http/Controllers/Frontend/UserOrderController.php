<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Review;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\Product\App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\GlobalSetting\App\Models\GlobalSetting;

class UserOrderController extends Controller
{
    public function order(): Renderable
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->paginate(5);
        return view('frontend.user.order', compact('user', 'orders'));
    }

    public function order_details($id): Renderable
    {
        $user = Auth::user();
        $order = Order::with('items')->where('user_id', $user->id)->where('id', $id)->first();
        return view('frontend.user.order_details', compact('user', 'order'));
    }

    public function continue_order(Request $request): RedirectResponse
    {
        $rules = [
            'order_type' => 'required',
            'additional_notes' => 'nullable',
        ];

        if ($request->order_type == 'delivery') {
            if (auth()->check()) {
                $rules['address_id'] = 'required|exists:user_addresses,id';
            } else {
                $rules = array_merge($rules, [
                    'name' => 'required|string|max:255',
                    'email' => 'max:255',
                    'phone' => 'required|string|max:15',
                    'address' => 'required|string|max:255',
                    'delivery_type' => 'required|in:home,office',
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric',
                ]);
            }
        }else{
            $rules = array_merge($rules, [
                'contact_name' => 'required|string|max:255',
                'contact_email' => 'max:255',
                'contact_phone' => 'required|string|max:15',
            ]);
        }

        // Custom error messages for validation
        $customMessages = [
            'order_type.required' => trans('translate.Order type is required'),
            'delivery_time.required' => trans('translate.Delivery time is required'),
            'slots.required' => trans('translate.Time slot is required'),
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'phone.required' => trans('translate.Phone is required'),
            'address.required' => trans('translate.Address is required'),
            'delivery_type.required' => trans('translate.Delivery type is required'),
            'address_id.required' => trans('translate.Address is required'),
        ];

        // Perform validation
        $this->validate($request, $rules, $customMessages);

        // Get cart session data
        $carts = session('cart');
        $subtotal = $this->calculateCartSubtotal($carts);
        $restaurant_id = Product::find($carts[0]['product_id'])?->restaurant?->id;

        $orderData = [
            'order_type' => $request->order_type,
            'delivery_time' => $request->delivery_time,
            'slots' => $request->slots,
            'additional_notes' => $request->additional_notes,
            'restaurant_id' => $restaurant_id,
            'subtotal' => $subtotal,
        ];

        if ($request->order_type == 'delivery') {
            if (auth()->check()) {
                $deliveryCharge = $this->getDeliveryChargeForAuthenticatedUser($request->address_id);
                $orderData['address_id'] = $request->address_id;
                $user_address = UserAddress::findOrFail($request->address_id);
                $orderData = array_merge($orderData, [
                    'name' => $user_address->name,
                    'email' => $user_address->email,
                    'phone' => $user_address->phone,
                    'address' => $user_address->address,
                    'delivery_type' => $user_address->delivery_type,
                    'lat' => $user_address->latitude,
                    'lon' => $user_address->longitude,
                ]);
            } else {
                $deliveryCharge = $this->getDeliveryChargeForGuestUser($request->latitude, $request->longitude);
                $orderData = array_merge($orderData, [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'delivery_type' => $request->delivery_type,
                    'lat' => $request->latitude,
                    'lon' => $request->longitude,
                ]);
            }
            $orderData['delivery_charge'] = $deliveryCharge;
        } else {
            $deliveryCharge = 0;
            $orderData['delivery_charge'] = $deliveryCharge;
            $orderData['name'] = $request->contact_name;
            $orderData['phone'] = $request->contact_phone;
            $orderData['email'] = $request->contact_email;
        }

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        if (session()->has('applied_coupon')) {
            $couponData = session('applied_coupon');
            $orderData['coupon_code'] = $couponData['code'];
            $orderData['discount_type'] = $couponData['discount_type'];
            $orderData['discount_value'] = $couponData['discount_value'];
            $orderData['discount_amount'] = $couponData['discount_amount'];
            $orderData['new_total'] = ($subtotal + $deliveryCharge) - $couponData['discount_amount'];
        } else {
            $orderData['new_total'] = $subtotal + $deliveryCharge;
        }

        if (auth()->check()){
            $orderData['is_guest'] = 0;
        }else{
            $orderData['is_guest'] = 1;
        }

        // Store order data in session
        session(['order_data' => $orderData]);

        return redirect()->route('view.payment');
    }

    private function calculateCartSubtotal($carts): float|int
    {
        $subtotal = 0;

        foreach ($carts as $item) {
            $subtotal += $item['total'];
        }

        return $subtotal;
    }

    private function getDeliveryChargeForAuthenticatedUser($addressId): float|int
    {
        $carts = session('cart');
        $userAddress = UserAddress::find($addressId);
        $restaurantLat = Product::find($carts[0]['product_id'])->restaurant->latitude;
        $restaurantLon = Product::find($carts[0]['product_id'])->restaurant->longitude;
        $userLat = $userAddress->lat;
        $userLon = $userAddress->lon;

        $distance = $this->calculateDistance($userLat, $userLon, $restaurantLat, $restaurantLon);
        $chargePerKm = GlobalSetting::where('key', 'delivery_charge')->first()->value;

        return $distance * $chargePerKm;
    }

    private function getDeliveryChargeForGuestUser($guestLat, $guestLon): float|int
    {
        $carts = session('cart');
        $restaurantLat = Product::find($carts[0]['product_id'])->restaurant->latitude;
        $restaurantLon = Product::find($carts[0]['product_id'])->restaurant->longitude;

        $distance = $this->calculateDistance($guestLat, $guestLon, $restaurantLat, $restaurantLon);
        $chargePerKm = GlobalSetting::where('key', 'delivery_charge')->first()->value;

        return $distance * $chargePerKm;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float|int
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function review_submit(Request $request, $food_id){

       $request->validate([
            'review' => 'required',
            'rating' => 'required',
            'order_id' => 'required',
            'restaurant_id' => 'required'
        ]);

        $review = Review::where('product_id', $food_id)->where('order_id', $request->order_id)->where('restaurant_id', $request->restaurant_id)->where('user_id', Auth::user()->id)->first();

        if($review){
            $message = trans('translate.You already submitted review');
            $notification = array('message' => $message, 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }

        $product = Product::findOrFail($food_id);

        $order = Order::findOrFail($request->order_id);

        $review = new Review();
        $review->product_id = $food_id;
        $review->restaurant_id = $request->restaurant_id;
        $review->order_id = $request->order_id;
        $review->user_id = Auth::user()->id;
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->status = 0;
        $review->save();

        $message = trans('translate.Review submited successful');
        $notification = array('message' => $message, 'alert-type' => 'success');
        return redirect()->back()->with($notification);

    }


}
