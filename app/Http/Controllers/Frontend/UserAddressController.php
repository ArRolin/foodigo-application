<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function view_address(): Renderable
    {
        $user = Auth::user();
        $addresses = UserAddress::where('user_id', $user->id)->get();

        return view('frontend.address.user_address', compact('user', 'addresses'));
    }

    public function store_address(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required|max:220',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'phone.required' => trans('translate.Phone is required'),
            'address.required' => trans('translate.Address is required')
        ];

        $this->validate($request, $rules, $customMessages);

        $user = Auth::user();

        $user_address = new UserAddress();
        $user_address->user_id = $user->id;
        $user_address->name = $request->name;
        $user_address->email = $request->email;
        $user_address->phone = $request->phone;
        $user_address->address = $request->address;
        $user_address->lat = $request->latitude;
        $user_address->lon = $request->longitude;
        $user_address->delivery_type = $request->delivery_type;
        $user_address->save();

        $notification = trans('translate.Your address added successfully');
        $notification = array('message' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);

    }

    public function edit_address($id): Renderable
    {
        $user = Auth::user();
        $address = UserAddress::findOrFail($id);

        return view('frontend.address.edit_address', compact('user', 'address'));
    }

    public function update_address(Request $request, $id): RedirectResponse
    {
        // Retrieve the user address instance by ID
        $user_address = UserAddress::findOrFail($id);

        // Define validation rules
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required|max:220',
        ];

        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'phone.required' => trans('translate.Phone is required'),
            'address.required' => trans('translate.Address is required')
        ];

        $this->validate($request, $rules, $customMessages);

        $user = Auth::user();

        $user_address->user_id = $user->id;
        $user_address->name = $request->name;
        $user_address->email = $request->email;
        $user_address->phone = $request->phone;
        $user_address->address = $request->address;
        $user_address->lat = $request->latitude ? $request->latitude : $user_address->lat;
        $user_address->lon = $request->longitude ? $request->longitude : $user_address->lon;
        $user_address->delivery_type = $request->delivery_type;
        $user_address->save();

        $notification = trans('translate.Your address updated successfully');
        $notification = array('message' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_address($id): RedirectResponse
    {
        $address = UserAddress::findOrFail($id);

        $address->delete();

        $notify_message = trans('translate.Deleted successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('user.address')->with($notify_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_address_checkout($id): RedirectResponse
    {
        $address = UserAddress::findOrFail($id);

        $address->delete();

        $notify_message = trans('translate.Deleted successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('view.checkout')->with($notify_message);
    }
}
