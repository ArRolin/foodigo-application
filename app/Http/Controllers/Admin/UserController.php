<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Review;
use App\Models\Wishlist;

use Modules\Listing\Entities\Listing;

use Auth, Str, Image, File, Hash, Mail;
use Modules\Order\App\Models\Order;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function user_list(){

        $users = User::where('status', 'enable')->latest()->get();

        $title = trans('translate.User List');

        return view('admin.user.user_list', ['users' => $users, 'title' => $title]);
    }

    public function pending_user(){

        $users = User::where('status', 'disable')->latest()->get();

        $title = trans('translate.Pending User');

        return view('admin.user.user_list', ['users' => $users, 'title' => $title]);
    }

    public function user_show($id){

        $user = User::findOrFail($id);

        $orders = Order::where('user_id', $id)->latest()->paginate(10);
        $active_orders = Order::where('user_id', $id)->whereBetween('order_status', [2, 4])->latest()->count();
        $pending_orders = Order::where('user_id', $id)->where('order_status', 1)->latest()->count();
        $complete_orders = Order::where('user_id', $id)->where('order_status', 5)->latest()->count();
        $cancel_orders = Order::where('user_id', $id)->where('order_status', 6)->latest()->count();

        return view('admin.user.user_show', [
            'user' => $user,
            'orders' => $orders,
            'active_orders' => $active_orders,
            'pending_orders' => $pending_orders,
            'complete_orders' => $complete_orders,
            'cancel_orders' => $cancel_orders,
        ]);
    }

    public function update(Request $request ,$id){

        $user = User::findOrFail($id);

        $rules = [
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required|max:220',
        ];
        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'phone.required' => trans('translate.Phone is required'),
            'address.required' => trans('translate.Address is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->whatsapp_phone = $request->whatsapp_phone;
        $user->address = $request->address;
        $user->designation = $request->designation;
        $user->about_me = $request->about_me;
        $user->status = $request->status ? 'enable' : 'disable';
        $user->save();

        $notification= trans('translate.User updated successful');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function user_destroy($id){


        $total_order = Order::where('user_id', $id)->count();

        if($total_order > 0){
            $notification = trans('translate.You can not delete this user, multiple listing available under this user');
            $notification = array('message'=>$notification,'alert-type'=>'error');
            return redirect()->route('admin.user-list')->with($notification);
        }

        $user = User::find($id);
        $user_image = $user->image;

        if($user_image){
            if(File::exists(public_path().'/'.$user_image))unlink(public_path().'/'.$user_image);
        }

        Review::where('user_id',$id)->delete();
        Wishlist::where('user_id',$id)->delete();

        $user->delete();

        $notification = trans('translate.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.user-list')->with($notification);

    }

    public function user_status($id){
        $user = User::findOrFail($id);
        if($user->status == 'enable'){
            $user->status = 'disable';
            $user->save();
            $message = trans('translate.Status Changed Successfully');
        }else{
            $user->status = 'enable';
            $user->save();
            $message = trans('translate.Status Changed Successfully');
        }
        return response()->json($message);
    }
}
