<?php

namespace App\Http\Controllers\Deliveryman;

use Auth;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\DeliveryManWithdraw;
use App\Http\Controllers\Controller;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Order\App\Models\Order;

class DeliveryManDashboardController extends Controller
{
    public function index(){
        $user = Auth::guard('deliveryman')->user();

        $request_orders = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 0)->latest()->count();

        $pending_orders = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 1)->latest()->count();

        $complete_orders = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 3)->latest()->count();

        $cancel_orders = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 4)->latest()->count();

        $withdraw_list = DeliveryManWithdraw::where('deliveryman_id', $user->id)->get();
        $withdraw_without_reject_list = DeliveryManWithdraw::where('deliveryman_id', $user->id)->where('status', '!=','rejected')->get();

        $complete = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 3)->sum('delivery_charge');
        $cancel = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 4)->sum('delivery_charge');

        $total_income = $complete + $cancel;
        $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
        $Commission_per_delivery = GlobalSetting::where('key', 'Commission_per_delivery')->value('value');
        $total_commission = 0.00;
        $net_income = $total_income;
        if($commission_type == 'commission'){
            $total_commission = ($Commission_per_delivery / 100) * $total_income;
            $net_income = $total_income - $total_commission;
        }

        $total_withdraw_amount = $withdraw_without_reject_list->sum('total_amount');

        $current_balance = $net_income - $total_withdraw_amount;

        $pending_withdraw = DeliveryManWithdraw::where('deliveryman_id', $user->id)->where('status', 'pending')->sum('total_amount');

        return view('deliveryman.dashboard', [
            'withdraw_list' => $withdraw_list,
            'total_income' => $total_income,
            'total_commission' => $total_commission,
            'net_income' => $net_income,
            'current_balance' => $current_balance,
            'total_withdraw_amount' => $total_withdraw_amount,
            'pending_withdraw' => $pending_withdraw,
            'request_orders' => $request_orders,
            'pending_orders' => $pending_orders,
            'complete_orders' => $complete_orders,
            'cancel_orders' => $cancel_orders,
        ]);
    }
}
