<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Product\App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Add product to wishlist
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function add_to_wishlist(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer|exists:products,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();
            $productId = $request->product_id;

            // Check if product already exists in wishlist
            $existingWishlist = Wishlist::where([
                'user_id' => $user->id, 
                'product_id' => $productId
            ])->first();

            if ($existingWishlist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product already exists in wishlist',
                    'data' => null
                ], 400);
            }

            // Add to wishlist
            $wishlist = new Wishlist();
            $wishlist->product_id = $productId;
            $wishlist->user_id = $user->id;
            $wishlist->save();

            return response()->json([
                'status' => true,
                'message' => 'Product added to wishlist successfully',
                'data' => [
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $productId,
                    'user_id' => $user->id,
                    'created_at' => $wishlist->created_at
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to add product to wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove product from wishlist
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function remove_wishlist(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Validate wishlist item exists and belongs to user
            $wishlistItem = Wishlist::where([
                'id' => $id,
                'user_id' => $user->id
            ])->first();

            if (!$wishlistItem) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wishlist item not found or unauthorized',
                    'data' => null
                ], 404);
            }

            // Delete wishlist item
            $wishlistItem->delete();

            return response()->json([
                'status' => true,
                'message' => 'Product removed from wishlist successfully',
                'data' => [
                    'removed_wishlist_id' => $id,
                    'product_id' => $wishlistItem->product_id
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to remove product from wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's wishlist
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function wishlists(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Get wishlist items with product details
            $wishlistItems = Wishlist::where('user_id', $user->id)
                ->with(['product' => function($query) {
                    $query->withAvg('reviews', 'rating')
                          ->withCount('reviews');
                }])
                ->orderBy('created_at', 'desc')
                ->get();

            // Format response data
            $formattedWishlist = $wishlistItems->map(function ($item) {
                $product = $item->product;
                
                if (!$product) {
                    return null; // Skip if product doesn't exist
                }

                return [
                    'wishlist_id' => $item->id,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'short_description' => $product->short_description,
                        'specification' => $product->specification,
                        'size' => $product->size,
                        'status' => $product->status,
                        'image' => $product->image,
                        'average_rating' => $product->reviews_avg_rating ?? 0,
                        'total_reviews' => $product->reviews_count ?? 0,
                        'category' => $product->category ? [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                            'slug' => $product->category->slug
                        ] : null
                    ],
                    'added_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];
            })->filter()->values(); // Remove null values and reset array keys

            return response()->json([
                'status' => true,
                'message' => 'Wishlist retrieved successfully',
                'data' => [
                    'total_items' => $formattedWishlist->count(),
                    'wishlist_items' => $formattedWishlist
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
