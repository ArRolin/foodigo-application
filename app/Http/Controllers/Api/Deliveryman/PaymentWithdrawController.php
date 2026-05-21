<?php

namespace App\Http\Controllers\Deliveryman;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Controller;
use App\Models\DeliveryManWithdraw;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\Order\App\Models\Order;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class PaymentWithdrawController extends BaseController
{

    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }
            // $user = Auth::guard('deliveryman')->user();
            $withdraw_list = DeliveryManWithdraw::where('deliveryman_id', $user->id)->get();
            $withdraw_without_reject_list = DeliveryManWithdraw::where('deliveryman_id', $user->id)->where('status', '!=', 'rejected')->get();

            $complete = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 3)->sum('delivery_charge');
            $cancel = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_request', 4)->sum('delivery_charge');

            $total_income = $complete + $cancel;
            $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
            $Commission_per_delivery = GlobalSetting::where('key', 'commission_per_delivery')->value('value');
            $total_commission = 0.00;
            $net_income = $total_income;
            if ($commission_type == 'commission') {
                $total_commission = ($Commission_per_delivery / 100) * $total_income;
                $net_income = $total_income - $total_commission;
            }

            $total_withdraw_amount = $withdraw_without_reject_list->sum('total_amount');

            $current_balance = $net_income - $total_withdraw_amount;

            $pending_withdraw = DeliveryManWithdraw::where('deliveryman_id', $user->id)->where('status', 'pending')->sum('total_amount');

            // return view('deliveryman.withdraw.method.index', [
            //     'withdraw_list' => $withdraw_list,
            //     'total_income' => $total_income,
            //     'total_commission' => $total_commission,
            //     'net_income' => $net_income,
            //     'current_balance' => $current_balance,
            //     'total_withdraw_amount' => $total_withdraw_amount,
            //     'pending_withdraw' => $pending_withdraw,
            // ]);

            $data = [
                    'withdraw_list' => $withdraw_list,
                    'total_income' => $total_income,
                    'total_commission' => $total_commission,
                    'net_income' => $net_income,
                    'current_balance' => $current_balance,
                    'total_withdraw_amount' => $total_withdraw_amount,
                    'pending_withdraw' => $pending_withdraw,
            ];

            return $this->sendResponse($data, 'Delivery Man Earnings data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $withdraw = DeliveryManWithdraw::findOrFail($id);
        return view('deliveryman.withdraw.show', [
            'withdraw' => $withdraw
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function withdraw_approval($id): RedirectResponse
    {
        $withdraw = DeliveryManWithdraw::findOrFail($id);
        $withdraw->status = 'approved';
        $withdraw->save();

        $notify_message = trans('translate.Withdraw approved successful');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }

    public function withdraw_rejected($id): RedirectResponse
    {
        $withdraw = DeliveryManWithdraw::findOrFail($id);
        $withdraw->status = 'rejected';
        $withdraw->save();

        $notify_message = trans('translate.Withdraw rejected successful');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $withdraw = DeliveryManWithdraw::findOrFail($id);
        $withdraw->delete();

        $notify_message = trans('translate.Withdraw deleted successful');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('admin.withdraw-list.index')->with($notify_message);
    }
}
