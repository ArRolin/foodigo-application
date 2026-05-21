<?php

namespace App\Http\Controllers\Deliveryman\Auth;

use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Support\Facades\View;

class DeliveryManLoginController extends Controller
{
   public function loginPage(){
    return view('deliveryman.login');
   }




    public function dashboardLogin(Request $request) {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $customMessages = [
            'email.required' => trans('translate.admin_validation.Email is required'),
            'password.required' => trans('translate.admin_validation.Password is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $deliveryMan = DeliveryMan::where('email', $request->email)->first();

        if (!$deliveryMan) {
            return back()->withErrors(['email' => trans('translate.admin_validation.Invalid Email')]);
        }

        if ($deliveryMan->status != 1) {
            return back()->withErrors(['email' => trans('translate.admin_validation.Inactive account')]);
        }

        // Perform authentication
        if (!Auth::guard('deliveryman')->attempt($credentials, $request->has('remember'))) {
            return back()->withErrors(['password' => trans('translate.admin_validation.Invalid Password')]);
        }

        session()->flash('success', trans('translate.admin_validation.Login Successfully'));

        return redirect()->route('deliveryman.dashboard');
    }

   public function logout(){
    Auth::guard('deliveryman')->logout();
    $notification= trans('translate.admin_validation.Logout Successfully');
    $notification=array('messege'=>$notification,'alert-type'=>'success');
    return redirect()->route('deliveryman.login')->with($notification);
}
}
