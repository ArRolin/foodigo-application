<?php


namespace App\Http\Controllers\Frontend;

use App\Models\Review;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class UserDashboardController extends Controller
{
    public function user_dashboard(): Renderable
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        return view('frontend.user.dashboard', compact('user', 'orders'));
    }

    public function review(): Renderable
    {
        $user = Auth::user();

        $reviews = Review::with('user')->where('user_id', $user->id)->latest()->get();

        return view('frontend.user.review', compact('user', 'reviews'));
    }

    public function wishlist(): Renderable
    {
        $user = Auth::user();
        return view('frontend.user.wishlist', compact('user'));
    }
}
