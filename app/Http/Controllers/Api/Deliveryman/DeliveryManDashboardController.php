<?php

namespace App\Http\Controllers\Api\DeliveryMan;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryManWithdraw;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Order\App\Models\Order;

class DeliveryManDashboardController extends BaseController
{
    /**
     * Get delivery man dashboard data
     */
    public function dashboard(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            // Order statistics
            $request_orders = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_request', 0)
                ->count();

            $pending_orders = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_request', 1)
                ->count();

            $complete_orders = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_request', 3)
                ->count();

            $cancel_orders = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_request', 4)
                ->count();

            // Financial calculations
            $complete_earnings = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_request', 3)
                ->sum('delivery_charge');

            $cancel_earnings = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->where('order_request', 4)
                ->sum('delivery_charge');

            $total_income = $complete_earnings + $cancel_earnings;

            // Commission calculation
            $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
            $commission_per_delivery = GlobalSetting::where('key', 'Commission_per_delivery')->value('value');
            $total_commission = 0.00;
            $net_income = $total_income;

            if ($commission_type == 'commission') {
                $total_commission = ($commission_per_delivery / 100) * $total_income;
                $net_income = $total_income - $total_commission;
            }

            // Withdrawal data
            $withdraw_list = DeliveryManWithdraw::where('deliveryman_id', $user->id)->get();
            $total_withdrawn = DeliveryManWithdraw::where('deliveryman_id', $user->id)
                ->where('status', '!=', 'rejected')
                ->sum('total_amount');

            $pending_withdraw = DeliveryManWithdraw::where('deliveryman_id', $user->id)
                ->where('status', 'pending')
                ->sum('total_amount');

            $current_balance = $net_income - $total_withdrawn;

            // Recent orders
            $recent_orders = Order::where('delivery_man_id', $user->id)
                ->where('payment_status', 'success')
                ->with(['restaurant', 'address', 'user', 'deliveryman'])
                ->latest()
                ->paginate(10);

            $data = [
                'delivery_man' => [
                    'id' => $user->id,
                    'name' => $user->fname . ' ' . $user->lname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'image' => $user->man_image,
                ],
                'statistics' => [
                    'orders' => [
                        'request' => $request_orders,
                        'running' => $pending_orders,
                        'completed' => $complete_orders,
                        'cancelled' => $cancel_orders,
                        'total' => $request_orders + $pending_orders + $complete_orders + $cancel_orders,
                    ],
                    'financial' => [
                        'total_income' => number_format($total_income, 2),
                        'total_commission' => number_format($total_commission, 2),
                        'net_income' => number_format($net_income, 2),
                        'current_balance' => number_format($current_balance, 2),
                        'total_withdrawn' => number_format($total_withdrawn, 2),
                        'pending_withdrawal' => number_format($pending_withdraw, 2),
                    ],
                    'commission' => [
                        'type' => $commission_type,
                        'rate' => $commission_per_delivery,
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

            return $this->sendResponse($data, 'Dashboard data retrieved successfully');
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
            $user = Auth::guard('deliveryman')->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            $statistics = [
                'request_orders' => Order::where('delivery_man_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_request', 0)
                    ->count(),
                'pending_orders' => Order::where('delivery_man_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_request', 1)
                    ->count(),
                'complete_orders' => Order::where('delivery_man_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_request', 3)
                    ->count(),
                'cancel_orders' => Order::where('delivery_man_id', $user->id)
                    ->where('payment_status', 'success')
                    ->where('order_request', 4)
                    ->count(),
            ];

            $statistics['total_orders'] = array_sum($statistics);

            return $this->sendResponse($statistics, 'Order statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Helper method to get delivery status text
     */
    private function getDeliveryStatusText($status): string
    {
        $statusMap = [
            0 => 'New Request',
            1 => 'Accepted/Pending',
            2 => 'Rejected',
            3 => 'Completed',
            4 => 'Cancelled',
        ];

        return $statusMap[$status] ?? 'Unknown';
    }
}
