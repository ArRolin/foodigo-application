<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Order\App\Models\Order;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;

class RestaurantDashboardController extends BaseController
{
    /**
     * Get restaurant dashboard data
     */
    public function dashboard(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            // Order statistics
            $active_orders = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->whereBetween('order_status', [2, 4])
                ->latest()
                ->count();

            $pending_orders = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_status', 1)
                ->latest()
                ->count();

            $complete_orders = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_status', 5)
                ->latest()
                ->count();

            $cancel_orders = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_status', 6)
                ->latest()
                ->count();

            // Financial data
            $withdraw_list = SellerWithdraw::where('seller_id', $user->id)->get();
            $total_without_reject_withdraw = SellerWithdraw::where('seller_id', $user->id)
                ->where('status', '!=', 'rejected')
                ->get();

            $total_income = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_status', 5)
                ->sum('grand_total');

            // Commission calculation
            $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
            $commission_per_sale = GlobalSetting::where('key', 'commission_per_sale')->value('value');
            $total_commission = 0.00;
            $net_income = $total_income;

            if ($commission_type == 'commission') {
                $total_commission = ($commission_per_sale / 100) * $total_income;
                $net_income = $total_income - $total_commission;
            }

            $total_withdraw_amount = $total_without_reject_withdraw->sum('total_amount');
            $current_balance = $net_income - $total_withdraw_amount;
            $pending_withdraw = SellerWithdraw::where('seller_id', $user->id)
                ->where('status', 'pending')
                ->sum('total_amount');

            // Recent orders for dashboard
            $recent_orders = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->with(['restaurant', 'address', 'user', 'items', 'deliveryman'])
                ->latest()
                ->paginate(10);

            $data = [
                'restaurant' => [
                    'id' => $user->id,
                    'name' => $user->restaurant_name,
                    'email' => $user->email,
                    'logo' => $user->logo,
                ],
                'statistics' => [
                    'orders' => [
                        'active' => $active_orders,
                        'pending' => $pending_orders,
                        'completed' => $complete_orders,
                        'cancelled' => $cancel_orders,
                        'total' => $active_orders + $pending_orders + $complete_orders + $cancel_orders,
                    ],
                    'financial' => [
                        'total_income' => number_format($total_income, 2),
                        'total_commission' => number_format($total_commission, 2),
                        'net_income' => number_format($net_income, 2),
                        'current_balance' => number_format($current_balance, 2),
                        'total_withdrawn' => number_format($total_withdraw_amount, 2),
                        'pending_withdrawal' => number_format($pending_withdraw, 2),
                    ],
                    'commission' => [
                        'type' => $commission_type,
                        'rate' => $commission_per_sale,
                    ],
                ],
                'recent_orders' => $recent_orders,
                'withdraw_history' => $withdraw_list->map(function ($withdraw) {
                    return [
                        'id' => $withdraw->id,
                        'amount' => number_format($withdraw->total_amount, 2),
                        'status' => $withdraw->status,
                        'method' => $withdraw->method,
                        'created_at' => $withdraw->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
            ];

            return $this->sendResponse($data, 'Restaurant dashboard data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get order statistics only
     */
    public function orderStatistics(): JsonResponse
    {
        try {
            $user = Auth::guard('restaurant')->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            $statistics = [
                'active_orders' => Order::where('restaurant_id', $user->id)
                    ->where('payment_status', 'success')
                    ->whereBetween('order_status', [2, 4])
                    ->count(),
                'pending_orders' => Order::where('restaurant_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_status', 1)
                    ->count(),
                'complete_orders' => Order::where('restaurant_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_status', 5)
                    ->count(),
                'cancel_orders' => Order::where('restaurant_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_status', 6)
                    ->count(),
            ];

            $statistics['total_orders'] = array_sum($statistics);

            return $this->sendResponse($statistics, 'Order statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get financial summary
     */
    public function financialSummary(): JsonResponse
    {
        try {
            $user = Auth::guard('restaurant')->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            $total_income = Order::where('restaurant_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_status', 5)
                ->sum('grand_total');

            $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
            $commission_per_sale = GlobalSetting::where('key', 'commission_per_sale')->value('value');
            $total_commission = 0.00;
            $net_income = $total_income;

            if ($commission_type == 'commission') {
                $total_commission = ($commission_per_sale / 100) * $total_income;
                $net_income = $total_income - $total_commission;
            }

            $total_withdrawn = SellerWithdraw::where('seller_id', $user->id)
                ->where('status', '!=', 'rejected')
                ->sum('total_amount');

            $pending_withdraw = SellerWithdraw::where('seller_id', $user->id)
                ->where('status', 'pending')
                ->sum('total_amount');

            $data = [
                'total_income' => number_format($total_income, 2),
                'commission' => [
                    'type' => $commission_type,
                    'rate' => $commission_per_sale,
                    'amount' => number_format($total_commission, 2),
                ],
                'net_income' => number_format($net_income, 2),
                'total_withdrawn' => number_format($total_withdrawn, 2),
                'pending_withdrawal' => number_format($pending_withdraw, 2),
                'current_balance' => number_format($net_income - $total_withdrawn, 2),
            ];

            return $this->sendResponse($data, 'Financial summary retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Helper method to get order status text
     */
    private function getOrderStatusText($status): string
    {
        $statusMap = [
            1 => 'Pending',
            2 => 'In Progress',
            3 => 'Ready for Delivery',
            4 => 'Out for Delivery',
            5 => 'Delivered',
            6 => 'Cancelled',
        ];

        return $statusMap[$status] ?? 'Unknown';
    }
}
