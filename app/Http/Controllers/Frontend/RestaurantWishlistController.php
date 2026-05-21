<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RestaurantWishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RestaurantWishlistController extends Controller
{
    public function toggle_wishlist($id): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => trans('translate.You must be logged in to manage your wishlist.')]);
        }

        $userId = Auth::id();

        $existingWishlist = RestaurantWishlist::where('user_id', $userId)
            ->where('restaurant_id', $id)
            ->first();

        if ($existingWishlist) {
            $existingWishlist->delete();
            return response()->json(['success' => true, 'action' => 'removed', 'message' => trans('translate.Restaurant removed from wishlist.')]);
        } else {
            $wishlist = new RestaurantWishlist();
            $wishlist->restaurant_id = $id;
            $wishlist->user_id = $userId;
            $wishlist->save();

            return response()->json(['success' => true, 'action' => 'added', 'message' => trans('translate.Restaurant added to wishlist.')]);
        }
    }

}
