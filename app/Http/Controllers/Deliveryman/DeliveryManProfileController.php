<?php

namespace App\Http\Controllers\Deliveryman;

use Auth;
use File;
use Hash;
use Image;
use App\Models\Setting;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use App\Models\DeliveryManWithdraw;
use Illuminate\Support\Facades\Log;
use Modules\Order\App\Models\Order;
use App\Http\Controllers\Controller;
use Modules\GlobalSetting\App\Models\GlobalSetting;

class DeliveryManProfileController extends Controller
{
    public function index(){
        $user=Auth::guard('deliveryman')->user();
        $deliveryman=DeliveryMan::findOrFail($user->id);
        $withdraw_list = DeliveryManWithdraw::where('deliveryman_id', $user->id)->get();

        $complete = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_status', 5)->sum('delivery_charge');
        $cancel = Order::where('delivery_man_id', $user->id)->where('payment_status', 'success')->where('order_status', 6)->sum('delivery_charge');

        $total_income = $complete + $cancel;
        $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
        $Commission_per_delivery = GlobalSetting::where('key', 'Commission_per_delivery')->value('value');
        $total_commission = 0.00;
        $net_income = $total_income;
        if($commission_type == 'commission'){
            $total_commission = ($Commission_per_delivery / 100) * $total_income;
            $net_income = $total_income - $total_commission;
        }

        $total_withdraw_amount = $withdraw_list->sum('total_amount');

        $current_balance = $net_income - $total_withdraw_amount;

        $pending_withdraw = DeliveryManWithdraw::where('deliveryman_id', $user->id)->where('status', 'pending')->sum('total_amount');

        $orders=Order::where('delivery_man_id', $user->id)->get();

        return view('deliveryman.delivery_man_profile', [
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
    public function edit(){
        $id=Auth::guard('deliveryman')->user()->id;
        $deliveryman=DeliveryMan::findOrFail($id);
        $setting = Setting::first();
        return view('deliveryman.edit_my_profile', compact('deliveryman','setting'));
    }
    public function update(Request $request){
        $id=Auth::guard('deliveryman')->user()->id;
        $rules = [
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email|unique:delivery_men,email,'.$id,
            'man_type'=>'required',
            'idn_type'=>'required',
            'idn_num'=>'required',
            'phone'=>'required',
        ];
        $customMessages = [
            'man_image.required' => trans('translate.Delivery man image is required'),
            'fname.required' => trans('translate.First name is required'),
            'lname.required' => trans('translate.Last name is required'),
            'email.required' => trans('translate.Email is required'),
            'email.email' => trans('translate.Email must email type'),
            'email.unique' => trans('translate.Email already exist'),
            'man_type.required' => trans('translate.Delivery man type is required'),
            'idn_type.required' => trans('translate.Identity type is required'),
            'idn_num.required' => trans('translate.Identity number is required'),
            'idn_image.required' => trans('translate.Identity image is required'),
            'phone.required' => trans('translate.Phone is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        $man = DeliveryMan::findOrFail($id);
        $man_old_image=$man->man_image;
        $idn_old_image=$man->idn_image;
        if($request->man_image){
            $man_extention=$request->man_image->getClientOriginalExtension();
            $man_image_name = 'man-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$man_extention;
            $man_image_name ='uploads/custom-images/'.$man_image_name;
            Image::make($request->man_image)->save(public_path().'/'.$man_image_name);
            $man->man_image = $man_image_name;
            if($man_old_image){
                if(File::exists(public_path().'/'.$man_old_image))unlink(public_path().'/'.$man_old_image);
            }
        }
        $man->fname=$request->fname;
        $man->lname=$request->lname;
        $man->email=$request->email;
        $man->man_type=$request->man_type;
        $man->idn_type=$request->idn_type;
        $man->idn_num=$request->idn_num;
        if($request->idn_image){
            $idn_extention=$request->idn_image->getClientOriginalExtension();
            $idn_image_name = 'identity-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$idn_extention;
            $idn_image_name ='uploads/custom-images/'.$idn_image_name;
            Image::make($request->idn_image)->save(public_path().'/'.$idn_image_name);
            $man->idn_image = $idn_image_name;
            if($idn_old_image){
                if(File::exists(public_path().'/'.$idn_old_image))unlink(public_path().'/'.$idn_old_image);
            }
        }
        $man->phone=$request->phone;
        $man->save();
        $notification= trans('translate.admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function password(){
        return view('deliveryman.password');
    }

    public function updatePassword(Request $request){
        $id=Auth::guard('deliveryman')->user()->id;
        $rules = [
            'current_password' => 'required',
            'password' => 'required|min:4|max:100|confirmed',
        ];
        $customMessages = [
            'password.required' => trans('translate.Password is required'),
            'password.min' => trans('translate.Password minimum 4 character'),
            'password_confirmation.required' => trans('translate.Confirm password is required'),
            'password_confirmation.confirmed' => trans('translate.Confirm password do not match'),
        ];
        $this->validate($request, $rules,$customMessages);

        $man = DeliveryMan::findOrFail($id);

         if(Hash::check($request->current_password, $man->password)){
            $man->password = Hash::make($request->password);
            $man->save();

            $notify_message = trans('translate.Password changed successfully');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
            return redirect()->back()->with($notify_message);

        }else{
            $notify_message = trans('translate.Current password does not match');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

    }

    public function updateLocation(Request $request){
        $rules = [
            'latitude'=>'required',
            'longitude'=>'required',
        ];
        $customMessages = [
            'latitude.required' => trans('translate.admin_validation.Latitude is required'),
            'longitude.required' => trans('translate.admin_validation.Longitude is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $this->validate($request, $rules);
        $user=Auth::guard('deliveryman')->user();
        $user->latitude=$request->latitude;
        $user->longitude=$request->longitude;
        $user->save();

        $notification= trans('translate.admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);


    }

    public function deliveryman_edit($id)
    {
        $deliveryman = Deliveryman::findOrFail($id);
        return view('deliveryman.edit', compact('deliveryman'));
    }

    public function deliveryman_update(Request $request, $id)
    {
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
}
