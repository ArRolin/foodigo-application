<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Api\BaseController;
use App\Models\Cart;
use App\Models\CartAddon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Modules\Addon\App\Models\Addon;
use Modules\Coupon\App\Models\Coupon;
use Modules\Product\App\Models\Product;

class CartController extends BaseController
{
    /**
     * Get all cart items for authenticated user
     */
    public function getCartItems(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Get cart items with product and restaurant details
            $cartItems = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->with(['product' => function($query) {
                    $query->with(['restaurant', 'category'])
                          ->withAvg('reviews', 'rating')
                          ->withCount('reviews');
                }, 'restaurant'])
                ->get();

            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $cartCount = $cartItems->count();

            // Format response data
            $formattedCartItems = $cartItems->map(function ($cartItem) {
                return [
                    'cart_id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'size' => $cartItem->size,
                    'size_price' => $cartItem->size_price,
                    'qty' => $cartItem->qty,
                    'addons' => $cartItem->addons,
                    'addon_price' => $cartItem->addon_price,
                    'total_price' => $cartItem->total_price,
                    'product' => $cartItem->product ? [
                        'id' => $cartItem->product->id,
                        'name' => $cartItem->product->name,
                        'slug' => $cartItem->product->slug,
                        'image' => $cartItem->product->image,
                        'short_description' => $cartItem->product->short_description,
                        'restaurant' => $cartItem->product->restaurant ? [
                            'id' => $cartItem->product->restaurant->id,
                            'name' => $cartItem->product->restaurant->restaurant_name,
                            'slug' => $cartItem->product->restaurant->slug,
                            'image' => $cartItem->product->restaurant->image,
                        ] : null,
                        'category' => $cartItem->product->category ? [
                            'id' => $cartItem->product->category->id,
                            'name' => $cartItem->product->category->name,
                            'slug' => $cartItem->product->category->slug,
                        ] : null,
                        'average_rating' => $cartItem->product->reviews_avg_rating ?? 0,
                        'total_reviews' => $cartItem->product->reviews_count ?? 0,
                    ] : null,
                    'restaurant' => $cartItem->restaurant ? [
                        'id' => $cartItem->restaurant->id,
                        'name' => $cartItem->restaurant->restaurant_name,
                        'slug' => $cartItem->restaurant->slug,
                        'image' => $cartItem->restaurant->image,
                    ] : null,
                    'created_at' => $cartItem->created_at,
                    'updated_at' => $cartItem->updated_at,
                ];
            });

            $data = [
                'cart_items' => $formattedCartItems,
                'subtotal' => $subtotal,
                'cart_count' => $cartCount,
                'total_items' => $cartItems->sum('qty'),
                'applied_coupon' => null // Will be implemented with coupon system
            ];

            return $this->sendResponse($data, 'Cart items retrieved successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve cart items', [], 500);
        }
    }

    /**
     * Add product to cart
     */
    public function addProduct(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'size' => 'required|string',
            'qty' => 'integer|min:1',
            'addons' => 'array',
            'addons_qty' => 'array'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            list($size, $price) = explode(',', $request->size);

            // Check if product already exists in cart
            $existingCartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->where('status', 'active')
                ->first();

            if ($existingCartItem) {
                return $this->sendError('Product already exists in cart', [], 400);
            }

            // Get product details
            $product = Product::with('restaurant')->find($request->product_id);
            if (!$product) {
                return $this->sendError('Product not found', [], 404);
            }

            // Check if products are from different restaurants
            $existingCartItems = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->get();

            if ($existingCartItems->count() > 0) {
                $firstCartItem = $existingCartItems->first();
                if ($firstCartItem->restaurant_id != $product->restaurant_id) {
                    return $this->sendError('You cannot add products from multiple restaurants', [], 403);
                }
            }

            // Calculate addon prices
            $addons = $request->input('addons', []);
            $addons_qty = $request->input('addons_qty', []);
            $qty = $request->input('qty', 1);
            $addonsWithQty = [];
            $addonsPrice = 0;

            foreach ($addons as $addon) {
                $quantity = $addons_qty[$addon] ?? 1;
                $addonsWithQty[$addon] = $quantity;

                $find_addon = Addon::where('id', $addon)->first();
                if ($find_addon) {
                    $addonsPrice += $find_addon->price * $quantity;
                }
            }

            // Calculate total price
            $size_price = (float) $price;
            $total_price = ($size_price * $qty) + $addonsPrice;

            // Create cart item
            $cartItem = Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'restaurant_id' => $product->restaurant_id,
                'size' => $size,
                'size_price' => $size_price,
                'qty' => $qty,
                'addons' => $addonsWithQty,
                'addon_price' => $addonsPrice,
                'total_price' => $total_price,
                'status' => 'active',
            ]);

            // Load relationships for response
            $cartItem->load(['product.restaurant', 'product.category']);

            // Get updated cart summary
            $cartSummary = $this->getCartSummary($user->id);

            $data = [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'size' => $cartItem->size,
                    'qty' => $cartItem->qty,
                    'total_price' => $cartItem->total_price,
                    'product' => $cartItem->product ? [
                        'name' => $cartItem->product->name,
                        'image' => $cartItem->product->image,
                    ] : null,
                ],
                'cart_summary' => $cartSummary
            ];

            return $this->sendResponse($data, 'Product added to cart successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to add product to cart', [], 500);
        }
    }

    /**
     * Remove product from cart
     */
    public function removeProduct(Request $request, $product_id): JsonResponse
    {
        try {
            $user = $request->user();
            
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->where('status', 'active')
                ->first();

            if (!$cartItem) {
                return $this->sendError('Product not found in cart', [], 404);
            }

            $cartItem->delete();

            // Get updated cart summary
            $cartSummary = $this->getCartSummary($user->id);

            return $this->sendResponse($cartSummary, 'Product removed from cart successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to remove product from cart', [], 500);
        }
    }

    /**
     * Increment cart item quantity
     */
    public function incrementCartItem(Request $request, $product_id): JsonResponse
    {
        try {
            $user = $request->user();
            
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->where('status', 'active')
                ->first();

            if (!$cartItem) {
                return $this->sendError('Product not found in cart', [], 404);
            }

            $cartItem->qty += 1;
            $cartItem->total_price = ($cartItem->size_price * $cartItem->qty) + $cartItem->addon_price;
            $cartItem->save();

            // Get updated cart summary
            $cartSummary = $this->getCartSummary($user->id);

            return $this->sendResponse($cartSummary, 'Cart updated successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to update cart', [], 500);
        }
    }

    /**
     * Decrement cart item quantity
     */
    public function decrementCartItem(Request $request, $product_id): JsonResponse
    {
        try {
            $user = $request->user();
            
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->where('status', 'active')
                ->first();

            if (!$cartItem) {
                return $this->sendError('Product not found in cart', [], 404);
            }

            $cartItem->qty -= 1;

            if ($cartItem->qty <= 0) {
                $cartItem->delete();
                $message = 'Product removed from cart';
            } else {
                $cartItem->total_price = ($cartItem->size_price * $cartItem->qty) + $cartItem->addon_price;
                $cartItem->save();
                $message = 'Cart updated successfully';
            }

            // Get updated cart summary
            $cartSummary = $this->getCartSummary($user->id);

            return $this->sendResponse($cartSummary, $message);

        } catch (\Exception $e) {
            return $this->sendError('Failed to update cart', [], 500);
        }
    }

    /**
     * Update cart item
     */
    public function updateCartItem(Request $request, $product_id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'size' => 'required|string',
            'qty' => 'integer|min:1',
            'addons' => 'array',
            'addons_qty' => 'array'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            list($size, $price) = explode(',', $request->size);

            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->where('status', 'active')
                ->first();

            if (!$cartItem) {
                return $this->sendError('Product not found in cart', [], 404);
            }

            // Calculate addon prices
            $addons = $request->input('addons', []);
            $addons_qty = $request->input('addons_qty', []);
            $qty = $request->input('qty', 1);
            $addonsWithQty = [];
            $addonsPrice = 0;

            foreach ($addons as $addon) {
                $quantity = $addons_qty[$addon] ?? 1;
                $addonsWithQty[$addon] = $quantity;

                $find_addon = Addon::where('id', $addon)->first();
                if ($find_addon) {
                    $addonsPrice += $find_addon->price * $quantity;
                }
            }

            // Update cart item
            $cartItem->size = $size;
            $cartItem->size_price = (float) $price;
            $cartItem->qty = $qty;
            $cartItem->addons = $addonsWithQty;
            $cartItem->addon_price = $addonsPrice;
            $cartItem->total_price = ($cartItem->size_price * $qty) + $addonsPrice;
            $cartItem->save();

            // Get updated cart summary
            $cartSummary = $this->getCartSummary($user->id);

            return $this->sendResponse($cartSummary, 'Cart updated successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to update cart', [], 500);
        }
    }

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            $couponCode = $request->coupon_code;

            // Get cart subtotal
            $cartSummary = $this->getCartSummary($user->id);
            $subtotal = $cartSummary['subtotal'];

            $coupon = Coupon::where('code', $couponCode)->first();

            if (!$coupon) {
                return $this->sendError('Coupon code does not exist!', [], 404);
            }

            if ($coupon->status !== 'enable') {
                return $this->sendError('Coupon is not enabled!', [], 400);
            }

            if ($coupon->expired_date < now()) {
                return $this->sendError('Coupon code has expired!', [], 400);
            }

            if ($subtotal < $coupon->min_purchase_price) {
                return $this->sendError('Minimum purchase price not met!', [], 400);
            }

            // Calculate discount
            $discountAmount = 0;
            if ($coupon->discount_type === 'percentage') {
                $discountAmount = ($subtotal * $coupon->discount_amount) / 100;
            } elseif ($coupon->discount_type === 'amount') {
                $discountAmount = $coupon->discount_amount;
            }

            if ($discountAmount > $subtotal) {
                $discountAmount = $subtotal;
            }

            $newTotal = $subtotal - $discountAmount;

            $data = [
                'coupon' => [
                    'code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount_value' => $coupon->discount_amount,
                    'discount_amount' => $discountAmount,
                    'new_total' => $newTotal
                ],
                'cart_summary' => $cartSummary
            ];

            return $this->sendResponse($data, 'Coupon applied successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to apply coupon', [], 500);
        }
    }

    /**
     * Remove coupon from cart
     */
    public function removeCoupon(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Get cart summary without coupon
            $cartSummary = $this->getCartSummary($user->id);

            return $this->sendResponse($cartSummary, 'Coupon removed successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to remove coupon', [], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clearCart(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->delete();

            return $this->sendResponse([], 'Cart cleared successfully');

        } catch (\Exception $e) {
            return $this->sendError('Failed to clear cart', [], 500);
        }
    }

    /**
     * Get cart summary for user
     */
    private function getCartSummary($userId): array
    {
        $cartItems = Cart::where('user_id', $userId)
            ->where('status', 'active')
            ->get();

        $subtotal = $cartItems->sum('total_price');
        $cartCount = $cartItems->count();
        $totalItems = $cartItems->sum('qty');

        return [
            'cart_items' => $cartItems,
            'subtotal' => $subtotal,
            'cart_count' => $cartCount,
            'total_items' => $totalItems,
        ];
    }
}
