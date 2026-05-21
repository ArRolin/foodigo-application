<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Product\App\Models\Product;

class WishlistController extends Controller
{
    public function add_to_wishlist($id): RedirectResponse
    {
        if (!Auth::check()) {
            $notification = trans('translate.Please log in to add food to your wishlist.');
            $notification = array('message' => $notification, 'alert-type' => 'error');
            return redirect()->route('user.login')->with($notification);
        }

        $user = Auth::user();
        $is_exist = Wishlist::where(['user_id' => $user->id, 'product_id' => $id])->first();

        if (!$is_exist) {
            $wishlist = new Wishlist();
            $wishlist->product_id = $id;
            $wishlist->user_id = $user->id;
            $wishlist->save();

            $notification = trans('translate.Food added to favourite list');
            $notification = array('message' => $notification, 'alert-type' => 'success');
        } else {
            $is_exist->delete();
            $notification = trans('translate.Item remove to favourite list');
            $notification = array('message' => $notification, 'alert-type' => 'success');
        }

        return redirect()->back()->with($notification);
    }


    public function wishlists(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();

        $wishlistItems = Wishlist::where('user_id', $user->id)->get();

        $wishlists = $wishlistItems->map(function ($item) {
            $product = Product::withAvg('reviews', 'rating')
            ->withCount('reviews')->find($item->product_id);
            return [
                'wishlist_item' => $item,
                'product' => $product,
                'translated_name' => $product->name
            ];
        });


        return view('frontend.user.wishlist', compact('wishlists', 'user'));
    }

    public function remove_wishlist($id): RedirectResponse
    {

        $user = Auth::user();
        Wishlist::where(['user_id' => $user->id, 'id' => $id])->delete();

        $notification = trans('translate.Item remove to favourite list');
        $notification = array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


}
