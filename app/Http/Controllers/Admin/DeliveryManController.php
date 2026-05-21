<?php

namespace App\Http\Controllers\Admin;


use File;
use Image;
use App\Models\DeliveryMan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliverymanWithdraw;
use Illuminate\Support\Facades\Log;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\GlobalSetting\App\Models\GlobalSetting;

class DeliveryManController extends Controller
{
    public function deliveryman_index(){
        $deliverymans = DeliveryMan::all();
        return view('admin.deliveryman.index', compact('deliverymans'));
    }
    public function deliveryman_show($id){

        $deliveryman=DeliveryMan::findOrFail($id);
        $withdraw_list = DeliverymanWithdraw::where('deliveryman_id', $id)->get();
        $withdraw_without_reject_list = DeliverymanWithdraw::where('deliveryman_id', $id)->where('status', '!=','rejected')->get();

        $complete = Order::where('delivery_man_id', $id)->where('payment_status', 'success')->where('order_request', 3)->sum('delivery_charge');
        $cancel = Order::where('delivery_man_id', $id)->where('payment_status', 'success')->where('order_request', 4)->sum('delivery_charge');

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

        $pending_withdraw = DeliverymanWithdraw::where('deliveryman_id', $id)->where('status', 'pending')->sum('total_amount');

        $orders=Order::where('delivery_man_id', $id)->get();

        return view('admin.deliveryman.show', [
            'withdraw_list' => $withdraw_list,
            'total_income' => $total_income,
            'total_commission' => $total_commission,
            'net_income' => $net_income,
            'current_balance' => $current_balance,
            'total_withdraw_amount' => $total_withdraw_amount,
            'pending_withdraw' => $pending_withdraw,
            'deliveryman' => $deliveryman,
            'orders' => $orders,
        ]);

    }

    public function order_show($id){
        $deliverymans=DeliveryMan::latest()->get();
        $order = Order::findOrFail($id);
        return view('admin.deliveryman.order_show', compact('order','deliverymans'));
    }

    public function create(){
        return view('admin.deliveryman.create');
    }

    public function deliveryman_store(Request $request){

        $deliveryman = new Deliveryman();
        $deliveryman->fname = $request->fname;
        $deliveryman->lname = 'test';
        $deliveryman->status = '1';
        $deliveryman->man_type = 'male';
        $deliveryman->email = $request->email;
        $deliveryman->password = Hash::make($request->password);
        $deliveryman->phone = $request->phone;

        if ($request->hasFile('man_image')) {
            try {
                $user_image = $request->file('man_image');
                $extension = $user_image->getClientOriginalExtension();
                $image_name = $request->fname . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extension;

                $image_path = 'uploads/custom-images/' . $image_name;

                // Ensure the directory exists
                $directory = public_path('uploads/custom-images');
                if (!is_dir($directory)) {
                    mkdir($directory, 0775, true);
                }

                // Save the image
                Image::make($user_image)->save(public_path($image_path));

                // Save the image path in DB
                $deliveryman->man_image = $image_path;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
            }
        }

        $deliveryman->save();

        $notification=trans('translate.Deliveryman created successfully');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function deliveryman_edit($id)
    {
        $deliveryman = Deliveryman::findOrFail($id);
        return view('admin.deliveryman.edit', compact('deliveryman'));
    }


    public function deliveryman_update(Request $request, $id)
    {
        dd(1);
        $deliveryman = Deliveryman::findOrFail($id);

        $deliveryman->fname = $request->fname;
        $deliveryman->lname = $request->lname;
        $deliveryman->email = $request->email;
        $deliveryman->idn_type = $request->idn_type;
        $deliveryman->idn_num = $request->idn_num;
        $deliveryman->man_type = $request->man_type;
        $deliveryman->phone = $request->phone;
        if ($request->filled('password')) {
            $deliveryman->password = Hash::make($request->password);
        }


        if ($request->hasFile('man_image')) {
            try {
                $user_image = $request->file('man_image');
                $extension = $user_image->getClientOriginalExtension();
                $image_name = $request->fname . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extension;

                $image_path = 'uploads/custom-images/' . $image_name;

                // Check if the directory exists, if not create it
                $directory = public_path('uploads/custom-images');
                if (!is_dir($directory)) {
                    mkdir($directory, 0775, true);
                }

                // Save image to the public path
                Image::make($user_image)->save(public_path($image_path)); // Save the image

                // Update the deliveryman image path
                $deliveryman->man_image = $image_path;
            } catch (\Exception $e) {
                // Log the error message or handle it accordingly
                Log::error('Image upload failed: ' . $e->getMessage());
            }
        }

        $deliveryman->save(); // Save the updated deliveryman data

        $notification=trans('translate.Deliveryman updated successfully');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function deliveryman_pending(){
        $deliverymans = DeliveryMan::where('status','!==', 1)->get();
        return view('admin.deliveryman.pending', compact('deliverymans'));
    }

    public function deliveryman_delete($id){

        $restaurant = DeliveryMan::findOrFail($id);

        $order_qty = Order::where('delivery_man_id', $id)->count();

        if($order_qty > 0){
            $notification = trans('translate.You can not delete this restaurant, multiple orders available under this restaurant');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }


        $restaurant->delete();


        $notification = trans('translate.Delete Successfully');
        $notification = array('message'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.restaurants.index')->with($notification);

        DeliveryMan::findOrFail($id)->forcedelete();

        $notification=trans('translate.Deleted Successfully');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
