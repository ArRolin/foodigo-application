<?php

namespace App\Http\Controllers\Api\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Api\BaseController;

class RestaurantOrderController extends BaseController
{
    public function allOrder(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $orders = Order::where('restaurant_id', $user->id)
                ->when($request->has('order_type') && $request->order_type == 'delivery', function ($query) {
                    $query->where('order_type', 'delivery');
                })
                ->when($request->has('order_type') && $request->order_type == 'pickup', function ($query) {
                    $query->where('order_type', 'pickup');
                })->with(['restaurant', 'items', 'address', 'user', 'deliveryman'])
                ->latest()->get();

            $data = [
                'order_list' => $orders
            ];

            return $this->sendResponse($data, 'Order list retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function orderDetail($id): JsonResponse
    {
        try {
            $order = Order::with(['restaurant', 'items.products', 'address', 'user', 'deliveryman'])->findOrFail($id);

            $data = [
                'order' => $order
            ];

            return $this->sendResponse($data, 'Order Details retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function orderStatusChange(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::find($id);
            $order->order_status = $request->order_status;
            $order->save();

            $data = [
                'order' => $order
            ];

            return $this->sendResponse($data, 'Order status changed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
