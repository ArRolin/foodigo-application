<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\Review;
use App\Models\UserAddress;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends BaseController
{
    /**
     * Get user dashboard data
     */
    public function getDashboard(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $orders = Order::where('user_id', $user->id)
                ->with(['restaurant', 'items'])
                ->latest()
                ->take(5)
                ->get();

            $totalOrders = Order::where('user_id', $user->id)->count();
            $completedOrders = Order::where('user_id', $user->id)->where('order_status', 'delivered')->count();
            $cancelledOrders = Order::where('user_id', $user->id)->where('order_status', 'cancelled')->count();
            $pendingOrders = Order::where('user_id', $user->id)->whereIn('order_status', ['pending', 'in_progress'])->count();

            $totalSpent = Order::where('user_id', $user->id)
                ->where('order_status', 'delivered')
                ->sum('grand_total');

            $addresses = UserAddress::where('user_id', $user->id)->get();

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'image' => $user->image,
                ],
                'statistics' => [
                    'total_orders' => $totalOrders,
                    'completed_orders' => $completedOrders,
                    'cancelled_orders' => $cancelledOrders,
                    'pending_orders' => $pendingOrders,
                    'total_spent' => $totalSpent,
                ],
                'recent_orders' => $orders,
                'addresses' => $addresses
            ];

            return $this->sendResponse($data, 'Dashboard data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get user orders with pagination
     */
    public function getOrders(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $orders = Order::where('user_id', $user->id)
                ->with(['restaurant', 'items'])
                ->latest()
                ->paginate(10);

            return $this->sendPaginatedResponse($orders, 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get single order details
     */
    public function getOrderDetails(Request $request, $orderId): JsonResponse
    {
        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)
                ->where('id', $orderId)
                ->with(['restaurant', 'items.products', 'deliveryMan'])
                ->first();
            if (!$order) {
                return $this->sendError('Order not found', [], 404);
            }
            return $this->sendResponse($order, 'Order details retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Request $request, $orderId): JsonResponse
    {
        try {
            $user = $request->user();

            $order = Order::where('user_id', $user->id)
                ->where('id', $orderId)
                ->first();

            if (!$order) {
                return $this->sendError('Order not found', [], 404);
            }

            if (!in_array($order->order_status, ['pending', 'confirmed'])) {
                return $this->sendError('Order cannot be cancelled', [], 400);
            }

            $order->order_status = 'cancelled';
            $order->save();

            return $this->sendResponse($order, 'Order cancelled successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get user reviews
     */
    public function getReviews(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $reviews = Review::where('user_id', $user->id)
                ->with(['product'])
                ->latest()
                ->paginate(10);

            return $this->sendPaginatedResponse($reviews, 'Reviews retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Submit product/restaurant review
     */
    public function submitReview(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'product_id' => 'nullable|exists:products,id',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();

            // Verify order belongs to user
            $order = Order::where('id', $request->order_id)
                ->where('user_id', $user->id)
                ->where('order_status', 5)
                ->first();

            if (!$order) {
                return $this->sendError('Invalid order or order not delivered', [], 400);
            }

            // Check if review already exists
            $existingReview = Review::where('user_id', $user->id)
                ->where('order_id', $request->order_id)
                ->where('product_id', $request->product_id)
                ->where('restaurant_id', $request->restaurant_id)
                ->first();

            if ($existingReview) {
                return $this->sendError('Review already submitted for this item', [], 400);
            }

            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'restaurant_id' => $request->restaurant_id,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'review' => $request->comment,
                'status' => '0',
            ]);

            return $this->sendResponse($review, 'Review submitted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get user addresses
     */
    public function getAddresses(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $addresses = UserAddress::where('user_id', $user->id)->get();

            return $this->sendResponse($addresses, 'Addresses retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Add new address
     */
    public function addAddress(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:home,office,other',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'landmark' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();

            $address = UserAddress::create([
                'user_id' => $user->id,
                'delivery_type' => $request->type,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'lat' => $request->latitude,
                'lon' => $request->longitude,
            ]);

            return $this->sendResponse($address, 'Address added successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Update address
     */
    public function updateAddress(Request $request, $addressId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:home,office,other',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();

            $address = UserAddress::where('user_id', $user->id)
                ->where('id', $addressId)
                ->first();

            if (!$address) {
                return $this->sendError('Address not found', [], 404);
            }

            $address->update([
                'delivery_type' => $request->type,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'lat' => $request->latitude,
                'lon' => $request->longitude,
            ]);

            return $this->sendResponse($address, 'Address updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Delete address
     */
    public function deleteAddress(Request $request, $addressId): JsonResponse
    {
        try {
            $user = $request->user();

            $address = UserAddress::where('user_id', $user->id)
                ->where('id', $addressId)
                ->first();

            if (!$address) {
                return $this->sendError('Address not found', [], 404);
            }

            $address->delete();

            return $this->sendResponse([], 'Address deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Track order real-time
     */
    public function trackOrder(Request $request, $orderId): JsonResponse
    {
        try {
            $user = $request->user();

            $order = Order::where('user_id', $user->id)
                ->where('id', $orderId)
                ->with(['restaurant', 'deliveryMan'])
                ->first();

            if (!$order) {
                return $this->sendError('Order not found', [], 404);
            }

            $trackingData = [
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'estimated_delivery_time' => $order->estimated_delivery_time,
                'restaurant' => [
                    'name' => $order->restaurant->restaurant_name,
                    'phone' => $order->restaurant->phone,
                    'address' => $order->restaurant->address,
                ],
                'delivery_man' => $order->deliveryMan ? [
                    'name' => $order->deliveryMan->name,
                    'phone' => $order->deliveryMan->phone,
                    'image' => $order->deliveryMan->image,
                    'current_latitude' => $order->deliveryMan->current_latitude,
                    'current_longitude' => $order->deliveryMan->current_longitude,
                ] : null,
                'timeline' => [
                    'order_placed' => $order->created_at,
                    'order_confirmed' => $order->confirmed_at,
                    'preparing' => $order->preparing_at,
                    'ready_for_pickup' => $order->ready_for_pickup_at,
                    'picked_up' => $order->picked_up_at,
                    'delivered' => $order->delivered_at,
                ]
            ];

            return $this->sendResponse($trackingData, 'Order tracking data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Submit food review for specific food item
     * 
     * @param Request $request
     * @param int $foodId
     * @return JsonResponse
     */
    public function review_submit(Request $request, $foodId): JsonResponse
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000',
                'order_id' => 'required|exists:orders,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors()->toArray());
            }

            $user = $request->user();

            // Verify order belongs to user and is delivered
            $order = Order::where('id', $request->order_id)
                ->where('user_id', $user->id)
                ->where('order_status', 5)
                ->first();

            if (!$order) {
                return $this->sendError('Invalid order or order not delivered', [], 400);
            }

            // Check if review already exists for this food item and order
            $existingReview = Review::where('user_id', $user->id)
                ->where('product_id', $foodId)
                ->where('order_id', $request->order_id)
                ->first();

            if ($existingReview) {
                return $this->sendError('Review already submitted for this food item', [], 400);
            }

            // Create review
            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $foodId,
                'restaurant_id' => $order->restaurant_id,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'active',
            ]);

            // Load relationships for response
            $review->load(['product', 'restaurant']);

            return $this->sendResponse([
                'review' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'status' => $review->status,
                    'created_at' => $review->created_at,
                    'product' => $review->product ? [
                        'id' => $review->product->id,
                        'name' => $review->product->name,
                        'slug' => $review->product->slug,
                    ] : null,
                    'restaurant' => $review->restaurant ? [
                        'id' => $review->restaurant->id,
                        'name' => $review->restaurant->restaurant_name,
                        'slug' => $review->restaurant->slug,
                    ] : null,
                ]
            ], 'Food review submitted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to submit review', [], 500);
        }
    }

    /**
     * Get complete review list for user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function review(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Get all reviews with pagination and filtering
            $reviews = Review::where('user_id', $user->id)
                ->with(['product', 'restaurant'])
                ->when($request->rating, function ($query) use ($request) {
                    return $query->where('rating', $request->rating);
                })
                ->when($request->status, function ($query) use ($request) {
                    return $query->where('status', $request->status);
                })
                ->when($request->product_id, function ($query) use ($request) {
                    return $query->where('product_id', $request->product_id);
                })
                ->when($request->restaurant_id, function ($query) use ($request) {
                    return $query->where('restaurant_id', $request->restaurant_id);
                })
                ->latest()
                ->paginate($request->per_page ?? 15);

            // Format response data
            $formattedReviews = $reviews->getCollection()->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'status' => $review->status,
                    'created_at' => $review->created_at,
                    'updated_at' => $review->updated_at,
                    'product' => $review->product ? [
                        'id' => $review->product->id,
                        'name' => $review->product->name,
                        'slug' => $review->product->slug,
                        'image' => $review->product->image,
                        'short_description' => $review->product->short_description,
                    ] : null,
                    'restaurant' => $review->restaurant ? [
                        'id' => $review->restaurant->id,
                        'name' => $review->restaurant->restaurant_name,
                        'slug' => $review->restaurant->slug,
                        'image' => $review->restaurant->image,
                        'address' => $review->restaurant->address,
                    ] : null,
                    'order' => [
                        'id' => $review->order_id,
                    ]
                ];
            });

            $responseData = [
                'total_reviews' => $reviews->total(),
                'current_page' => $reviews->currentPage(),
                'per_page' => $reviews->perPage(),
                'last_page' => $reviews->lastPage(),
                'reviews' => $formattedReviews,
                'statistics' => [
                    'average_rating' => Review::where('user_id', $user->id)->avg('rating'),
                    'total_reviews' => Review::where('user_id', $user->id)->count(),
                    'rating_distribution' => [
                        '5_star' => Review::where('user_id', $user->id)->where('rating', 5)->count(),
                        '4_star' => Review::where('user_id', $user->id)->where('rating', 4)->count(),
                        '3_star' => Review::where('user_id', $user->id)->where('rating', 3)->count(),
                        '2_star' => Review::where('user_id', $user->id)->where('rating', 2)->count(),
                        '1_star' => Review::where('user_id', $user->id)->where('rating', 1)->count(),
                    ]
                ]
            ];

            return $this->sendResponse($responseData, 'Review list retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve review list', [], 500);
        }
    }
}
