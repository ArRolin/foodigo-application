<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DeliveryManWithdraw;
use Modules\Order\App\Models\Order;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;

class DashboardController extends Controller
{

    public function dashboard(Request $request){

        $orders = Order::when($request->has('order_type') && $request->order_type == 'delivery', function($query){
            $query->where('order_type', 'delivery');
        })
        ->when($request->has('order_type') && $request->order_type == 'pickup', function($query){
            $query->where('order_type', 'pickup');
        })
        ->orderBy('id', 'desc')->get();

        $active_orders = Order::where(function ($query) {
            $query->where('payment_status', 'success')->whereBetween('order_status', [2, 4]);
        })->latest()->count();

        $pending_orders = Order::where(function ($query) {
            $query->where('payment_status', 'success')->where('order_status', 1);
        })->latest()->count();

        $complete_orders = Order::where(function ($query) {
            $query->where('payment_status', 'success')->where('order_status', 5);
        })->latest()->count();

        $cancel_orders = Order::where(function ($query) {
            $query->where('payment_status', 'success')->where('order_status', 6);
        })->latest()->count();


        $total_earning = Order::where(function ($query) {
            $query->where('payment_status', 'success')->where('order_status', 5);
        })->sum('grand_total');

        $total_pending = Order::where(function ($query) {
            $query->where('payment_status', 'success')->where('order_status', 1);
        })->sum('grand_total');

        $deliveryman_withdraw = DeliveryManWithdraw::where('status', '!=','rejected')->sum('total_amount');
        $seller_withdraw = SellerWithdraw::where('status', '!=','rejected')->sum('total_amount');

        $total_withdraw = $deliveryman_withdraw + $seller_withdraw;

        $admin_income = $total_earning - $total_withdraw;

        $lable = array();
        $data = array();
        $start = new Carbon('first day of this month');
        $last = new Carbon('last day of this month');
        $first_date = $start->format('Y-m-d');
        $last_date = $last->format('Y-m-d');
        $today = date('Y-m-d');
        $length = date('d')-$start->format('d');

        for($i=1; $i <= $length+1; $i++){

            $date = '';
            if($i == 1){
                $date = $first_date;
            }else{
                $date = $start->addDays(1)->format('Y-m-d');
            };

            $sum = Order::whereDate('created_at', $date)->sum('total');
            $data[] = $sum;
            $lable[] = $i;

        }

        $data = json_encode($data);
        $lable = json_encode($lable);

        return view('admin.dashboard', [
            'lable' => $lable,
            'data' => $data,
            'active_orders' => $active_orders,
            'pending_orders' => $pending_orders,
            'complete_orders' => $complete_orders,
            'cancel_orders' => $cancel_orders,
            'orders' => $orders,
            'total_earning' => $total_earning,
            'total_pending' => $total_pending,
            'total_withdraw' => $total_withdraw,
            'admin_income' => $admin_income,
        ]);
    }
}
