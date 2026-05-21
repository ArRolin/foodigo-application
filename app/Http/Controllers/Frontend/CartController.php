<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Addon\App\Models\Addon;
use Modules\Coupon\App\Models\Coupon;
use Modules\Page\App\Models\Homepage;
use Modules\Page\App\Models\HomepageTranslation;
use Modules\Product\App\Models\Product;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function view_all_carts()
    {
        $carts = session()->get('cart', []);
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();


        return view('frontend.carts.cart', compact('carts', 'home_translate', 'homepage'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|ValidationException
     */

    public function add_product(Request $request)
    {
        $rules = [
            'product_id' => 'required',
            'size' => 'required',
        ];

        $customMessages = [
            'product_id.required' => trans('translate.Product id is required'),
            // 'size.required' => trans('translate.Size is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        list($size, $price) = explode(',', $request['size']);

        $cart = session()->get('cart', []);
        $existingProduct = collect($cart)->firstWhere('product_id', $request->input('product_id'));

        if(collect($cart)->count() > 0) {
            $current_product = Product::where('id', $request->input('product_id'))->first();
            $ex_product = Product::where('id', collect($cart)->first()['product_id'])->first();

            if ($ex_product && $current_product && $ex_product->restaurant->id != $current_product->restaurant->id) {
                $message = trans('translate.You cannot add multiple restaurant product');

                return response()->json([
                    'message' => $message,
                ], 403);
            }
        }



        if ($existingProduct) {
            $message = trans('translate.Item already added');

            return response()->json([
                'message' => $message,
            ], 403);

        } else {

            $product_id = $request->input('product_id');
            $product_data = Product::find($product_id);
            $size = $size;
            $size_price = calculateFinalPrice($product_data, $price);
            $addons = $request->input('addons', []);
            $addons_qty = $request->input('addons_qty', []);
            $qty = $request->input('qty', 1);
            $addonsWithQty = [];
            $addonsPrice = 0;

            foreach ($addons as $index => $addon) {
                $quantity = $addons_qty[$addon] ?? 1;

                $addonsWithQty[$addon] = $quantity;

                $find_addon = Addon::where('id', $addon)->first();

                if ($find_addon) {
                    $addonsPrice += $find_addon->price * $quantity;
                }
            }

            $price = ($size_price * $qty) + $addonsPrice;

            $cartItem = [
                'product_id' => $product_id,
                'size' => [
                    $size => $size_price,
                ],
                'addons' => $addonsWithQty,
                'addon_price' => $addonsPrice,
                'qty' => $qty,
                'price' => $size_price,
                'total' => $price,
            ];

            $cart[] = $cartItem;
            session()->put('cart', $cart);


            if (session()->has('applied_coupon')) {
                session()->forget('applied_coupon');
            }
        }

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        $carts = session()->get('cart', []);

        $mini_cart = view('frontend.carts.mini_cart', [
            'carts' => $carts
        ])->render();


        $message = trans('translate.Item added successfully');

        return response()->json([
            'message' => $message,
            'mini_cart' => $mini_cart,
        ]);

    }

    public function remove_product(Request $request, $product_id)
    {
        $cart = $request->session()->get('cart', []);
        $productIndex = array_search($product_id, array_column($cart, 'product_id'));
        unset($cart[$productIndex]);
        $cart = array_values($cart);

        $message = trans('translate.Item removed successfully');
        $request->session()->put('cart', $cart);

        session()->forget('applied_coupon');

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        $carts = session()->get('cart', []);

        $mini_cart = view('frontend.carts.mini_cart', [
            'carts' => $carts
        ])->render();

        return response()->json([
            'message' => $message,
            'mini_cart' => $mini_cart,
            'cart_qty' => count($carts),
        ]);



    }


    public function remove_manual_product(Request $request, $product_id): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $productIndex = array_search($product_id, array_column($cart, 'product_id'));
        unset($cart[$productIndex]);
        $cart = array_values($cart);

        $message = trans('translate.Item removed successfully');
        $notification = ['message' => $message, 'alert-type' => 'success'];
        $request->session()->put('cart', $cart);

        session()->forget('applied_coupon');

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        return redirect()->back()->with($notification);
    }



    public function cart_increment(Request $request, $product_id)
    {
        $cart = $request->session()->get('cart', []);
        $productIndex = array_search($product_id, array_column($cart, 'product_id'));

        if ($productIndex !== false) {
            $cart[$productIndex]['qty'] += 1;
            $cart[$productIndex]['total'] = ($cart[$productIndex]['qty'] * $cart[$productIndex]['price']) + $cart[$productIndex]['addon_price'];
            $request->session()->put('cart', $cart);


            if (session()->has('applied_coupon')) {
                session()->forget('applied_coupon');
            }

        } else {
            $message = trans('translate.Product not found');

            return response()->json([
                'message' => $message,
            ], 403);

        }

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }


        $carts = session()->get('cart', []);

        $mini_cart = view('frontend.carts.mini_cart', [
            'carts' => $carts
        ])->render();

        $message = trans('translate.Cart updated successfully');

        return response()->json([
            'message' => $message,
            'mini_cart' => $mini_cart,
        ]);

    }

    public function cart_decrement(Request $request, $product_id)
    {

        $cart = $request->session()->get('cart', []);
        $productIndex = array_search($product_id, array_column($cart, 'product_id'));
        if ($productIndex !== false) {
            $cart[$productIndex]['qty'] -= 1;
            if ($cart[$productIndex]['qty'] <= 0) {
                unset($cart[$productIndex]);
                $message = trans('translate.Item removed from cart');
            } else {
                $cart[$productIndex]['total'] = ($cart[$productIndex]['qty'] * $cart[$productIndex]['price']) + $cart[$productIndex]['addon_price'];

            }
            $cart = array_values($cart);
            $request->session()->put('cart', $cart);

            if (session()->has('applied_coupon')) {
                session()->forget('applied_coupon');
            }
        } else {
            $message = trans('translate.Product not found');

            return response()->json([
                'message' => $message,
            ], 403);

        }

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        $carts = session()->get('cart', []);

        $mini_cart = view('frontend.carts.mini_cart', [
            'carts' => $carts
        ])->render();

        $message = trans('translate.Cart updated successfully');
        return response()->json([
            'message' => $message,
            'mini_cart' => $mini_cart,
        ]);
    }

    public function cart_update(Request $request, $product_id): RedirectResponse
    {

        list($size, $price) = explode(',', $request['size']);

        $cart = $request->session()->get('cart', []);
        $productIndex = array_search($product_id, array_column($cart, 'product_id'));

        if ($productIndex !== false) {
            $size = $size;
            $size_price = $price;
            $addons = $request->input('addons', []);
            $addons_qty = $request->input('addons_qty', []) ?: [1];
            $qty = $request->input('qty', 1);
            $addonsWithQty = [];
            $adonsPrice = 0;

            foreach ($addons as $index => $addon) {
                $quantity = $addons_qty[$addon] ?? 1;
                $addonsWithQty[$addon] = $quantity;

                $find_addon = Addon::where('id', $addon)->first();

                if ($find_addon) {
                    $adonsPrice += $find_addon->price * $quantity;
                }
            }

            $price = ($size_price * $qty) + $adonsPrice;

            // Update the existing item in the cart
            $cart[$productIndex] = [
                'product_id' => $product_id,
                'size' => [
                    $size => $size_price,
                ],
                'addons' => $addonsWithQty,
                'addon_price' => $adonsPrice,
                'qty' => $qty,
                'price' => $size_price,
                'total' => $price,
            ];

            session()->put('cart', $cart);
            $message = trans('translate.Cart updated successfully');
            $notification = ['message' => $message, 'alert-type' => 'success'];
            if (session()->has('applied_coupon')) {
                session()->forget('applied_coupon');
            }
        } else {
            $message = trans('translate.Product not found');
            $notification = ['message' => $message, 'alert-type' => 'error'];
        }

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        return redirect()->back()->with($notification);
    }

    public function apply_coupon(Request $request): JsonResponse
    {

        $couponCode = $request->coupon;
        $subtotal = $request->subtotal;
        $delivery_charge = $request->delivery;

        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => trans('translate.Coupon code does not exist!')]);
        }
        if ($coupon->status !== 'enable') {
            return response()->json(['success' => false, 'message' => trans('translate.Coupon is not enabled!')]);
        }
        if ($coupon->expired_date < now()) {
            return response()->json(['success' => false, 'message' => trans('translate.Coupon code has expired!')]);
        }

        if ($subtotal < $coupon->min_purchase_price) {
            return response()->json(['success' => false, 'message' => trans('translate.Minimum purchase price not met!')]);
        }

        $discountAmount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discountAmount = ($subtotal * $coupon->discount_amount) / 100;
        } elseif ($coupon->discount_type === 'amount') {
            // Fixed amount discount
            $discountAmount = $coupon->discount_amount;
        }

        if ($discountAmount > $subtotal) {
            $discountAmount = $subtotal;
        }

        $newTotal = $subtotal - $discountAmount;

        session([
            'applied_coupon' => [
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_amount,
                'discount_amount' => $discountAmount,
                'new_total' => $newTotal
            ]
        ]);

        if (session()->has('order_data')) {
            session()->forget('order_data');
        }

        return response()->json([
            'success' => true,
            'discount' => $discountAmount,
            'new_total' => $newTotal
        ]);
    }

    public function remove_coupon(Request $request): \Illuminate\Http\JsonResponse
    {
        if (session()->has('applied_coupon')) {
            session()->forget('applied_coupon');

            if (session()->has('order_data')) {
                session()->forget('order_data');
            }

            return response()->json(['success' => true, 'message' => trans('translate.Coupon removed successfully!')]);
        }

        return response()->json(['success' => false, 'message' => trans('translate.No coupon to remove!')]);
    }


}
