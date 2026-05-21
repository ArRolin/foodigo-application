<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Order\App\Models\Order;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;

class RestaurantDashboardController extends Controller
{
    public function dashboard(): Factory|Application|View
    {

        $user = Auth::guard('restaurant')->user();

        $active_orders = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->whereBetween('order_status', [2, 4])->latest()->count();

        $pending_orders = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->where('order_status', 1)->latest()->count();

        $complete_orders = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->where('order_status', 5)->latest()->count();

        $cancel_orders = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->where('order_status', 6)->latest()->count();

        $withdraw_list = SellerWithdraw::where('seller_id', $user->id)->get();
        $total_without_reject_withdraw = SellerWithdraw::where('seller_id', $user->id)->where('status', '!=','rejected')->get();
        $total_income = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->where('order_status', 5)->sum('grand_total');

        $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
        $commission_per_sale = GlobalSetting::where('key', 'commission_per_sale')->value('value');
        $total_commission = 0.00;
        $net_income = $total_income;
        if($commission_type == 'commission'){
            $total_commission = ($commission_per_sale / 100) * $total_income;
            $net_income = $total_income - $total_commission;
        }

        $total_withdraw_amount = $total_without_reject_withdraw->sum('total_amount');

        $current_balance = $net_income - $total_withdraw_amount;

        $pending_withdraw = SellerWithdraw::where('seller_id', $user->id)->where('status', 'pending')->sum('total_amount');

        return view('paymentwithdraw::seller.dashboard', [
            'withdraw_list' => $withdraw_list,
            'total_income' => $total_income,
            'total_commission' => $total_commission,
            'net_income' => $net_income,
            'current_balance' => $current_balance,
            'total_withdraw_amount' => $total_withdraw_amount,
            'pending_withdraw' => $pending_withdraw,
            'active_orders' => $active_orders,
            'pending_orders' => $pending_orders,
            'complete_orders' => $complete_orders,
            'cancel_orders' => $cancel_orders,
        ]);

    }
}
