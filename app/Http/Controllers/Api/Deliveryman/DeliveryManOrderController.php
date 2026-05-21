<?php

namespace App\Http\Controllers\Api\Deliveryman;

use Auth;
use Illuminate\Http\Request;
use App\Models\DeliveryMan;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DeliveryManOrderController extends BaseController
{
    public function orderRequest(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $orders = Order::with(['restaurant', 'address', 'user', 'items', 'deliveryman',])->where('delivery_man_id', $user->id)->orderBy('id', 'desc')->get();
            $title = trans('translate.admin_validation.All Orders');
            $data = [
                'title' => $title,
                'orders' => $orders
            ];

            return $this->sendResponse($data, 'Order Request data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function runningOrders(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $orders = Order::with(['restaurant', 'address', 'user', 'items', 'deliveryman',])->where('delivery_man_id', $user->id)->where('order_request', '=', 1)->orderBy('id', 'desc')->get();
            $title = trans('translate.Running Orders');

            $data = [
                'title' => $title,
                'orders' => $orders
            ];

            return $this->sendResponse($data, 'Running Orders data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function completedOrders(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $title = trans('translate.Completed Orders');
            $orders = Order::with(['restaurant', 'address', 'user', 'items', 'deliveryman',])->where('delivery_man_id', $user->id)->where('order_request', '=', 3)->orderBy('id', 'desc')->get();
            $data = [
                'title' => $title,
                'orders' => $orders
            ];

            return $this->sendResponse($data, 'Completed Orders data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function cancelOrders(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $title = trans('translate.Canceled Orders');
            $orders = Order::with(['restaurant', 'address', 'user', 'items', 'deliveryman',])->where('delivery_man_id', $user->id)->where('order_request', '=', 4)->orderBy('id', 'desc')->get();
            $data = [
                'title' => $title,
                'orders' => $orders
            ];

            return $this->sendResponse($data, 'Canceled Orders data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function orderDetail($id)
    {
        try {
            //$deliverymans = DeliveryMan::latest()->get();
            $order = Order::with('deliveryman','items.products')->findOrFail($id);

            $data = [
               // 'deliverymans' => $deliverymans,
                'order' => $order
            ];

            return $this->sendResponse($data, 'Order detail page data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function updateOrderRequestStatus(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'order_request_status' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            $order = Order::where('id', $id)->where('delivery_man_id', $user->id)->first();
            if ($request->order_request_status == 1) {
                $order->order_request = 1;
                $order->order_status = 3;
                $order->order_req_accept_date = date('Y-m-d');
                $order->save();
            } elseif ($request->order_request_status == 2) {
                $order->order_request = 2;
                $order->save();
            } elseif ($request->order_request_status == 3) {
                $order->order_request = 3;
                $order->order_status = 5;
                $order->save();
            } elseif ($request->order_request_status == 4) {
                $order->order_request = 4;
                $order->order_status = 6;
                $order->save();
            }

            $data = [
                'order' => $order
            ];

            return $this->sendResponse($data, 'Order Request status changed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
