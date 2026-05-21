<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Order\App\Models\Order;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;
use Illuminate\Http\JsonResponse;
use Modules\PaymentWithdraw\App\Models\WithdrawMethod;
use Illuminate\Support\Facades\Validator;

class RestaurantWithdrawController extends BaseController
{
    public function withdrawHistory(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $withdraw_list = SellerWithdraw::where('seller_id', $user->id)->get();
            $total_without_reject_withdraw = SellerWithdraw::where('seller_id', $user->id)->where('status', '!=', 'rejected')->get();
            $total_income = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->where('order_status', 5)->sum('grand_total');

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

            $pending_withdraw = SellerWithdraw::where('seller_id', $user->id)->where('status', 'pending')->sum('total_amount');

            $data = [
                'withdraw_list' => $withdraw_list,
                'total_income' => $total_income,
                'total_commission' => $total_commission,
                'net_income' => $net_income,
                'current_balance' => $current_balance,
                'total_withdraw_amount' => $total_withdraw_amount,
                'pending_withdraw' => $pending_withdraw,
            ];

            return $this->sendResponse($data, 'Restaurant earning data retrieved successfully ');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function create(): JsonResponse
    {
        try {
            $methods = WithdrawMethod::where('status', 'enable')->latest()->get();

            $data = [
                'methods' => $methods
            ];

            return $this->sendResponse($data, 'Restaurant withdraw page data retrieved successfully ');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'method_id' => 'required',
                'amount' => 'required|numeric',
                'description' => 'required',
            ],
            [
                'method_id.required' => trans('translate.Method is required'),
                'amount.required' => trans('translate.Amount is required'),
                'amount.numeric' => trans('translate.Amount should be numeric'),
                'description.required' => trans('translate.Bank Information is required'),
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            $method = WithdrawMethod::findOrFail($request->method_id);
            $withdraw_list = SellerWithdraw::where('seller_id', $user->id)->where('status', '!=', 'rejected')->get();
            $already_withdraw_amount = $withdraw_list->sum('total_amount');
            $my_income = Order::where('restaurant_id', $user->id)->where('payment_status', 'success')->where('order_status', 5)->sum('grand_total');


            $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
            $commission_per_sale = GlobalSetting::where('key', 'commission_per_sale')->value('value');

            $total_commission = 0.00;
            $net_income = $my_income;
            if ($commission_type == 'commission') {
                $total_commission = ($commission_per_sale / 100) * $my_income;
                $net_income = $my_income - $total_commission;
            }

            $current_balance = $net_income - $already_withdraw_amount;

            if ($request->amount > $current_balance) {
                return $this->sendResponse(trans('translate.You do not have enough balance for withdraw'));
            }

            if ($request->amount > $method->max_amount) {
                return $this->sendResponse(trans('translate.You can not withdraw more than') . ' ' . $method->max_amount);
            }


            $charge_amount = ($method->withdraw_charge / 100) * $request->amount;
            $withdraw_amount = $request->amount - $charge_amount;

            $new_withdraw = new SellerWithdraw();
            $new_withdraw->seller_id = $user->id;
            $new_withdraw->withdraw_method_id = $request->method_id;
            $new_withdraw->withdraw_method_name = $method->method_name;
            $new_withdraw->total_amount = $request->amount;
            $new_withdraw->withdraw_amount = $withdraw_amount;
            $new_withdraw->charge_amount = $charge_amount;
            $new_withdraw->description = $request->description;
            $new_withdraw->save();

            $data = [
                'new_withdraw' => $new_withdraw
            ];

            return $this->sendResponse($data, trans('translate.Withdraw request has been send. please awaiting for admin approval'));
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
