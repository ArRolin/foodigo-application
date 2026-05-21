<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Requests\RestaurantEditProfileRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Controller;
use Auth, Str, Image, File, Hash, Mail;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Http\RedirectResponse;
use Modules\City\Entities\City;
use Modules\Cuisine\Entities\Cuisine;


class RestaurantProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('restaurant');
    }


    public function edit_profile(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $restaurant = Auth::guard('restaurant')->user();
        $cities = City::with('translate')->get();
        $cuisines = Cuisine::with('translate')->get();

        return view('restaurant.profile.edit_profile', ['restaurant' => $restaurant, 'cities' => $cities, 'cuisines' => $cuisines]);
    }

    public function change_password(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $restaurant = Auth::guard('restaurant')->user();
        return view('restaurant.profile.change_password', ['restaurant' => $restaurant]);
    }


    public function profile_update(RestaurantEditProfileRequest $request): RedirectResponse
    {

        $restaurant = Auth::guard('restaurant')->user();

        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->city_id = $request->city_id;
        $restaurant->cuisines = json_encode($request->cuisines);

        if($request->logo){
            $old_image = $restaurant->logo;
            $image_name = 'restaurant-logo-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.webp';
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->logo)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $restaurant->logo = $image_name;
            $restaurant->save();

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->cover_image){
            $old_image = $restaurant->cover_image;
            $image_name = 'restaurant-cover-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.webp';
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->cover_image)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $restaurant->cover_image = $image_name;
            $restaurant->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        // set address info
        $restaurant->whatsapp = $request->whatsapp;
        $restaurant->address = $request->address;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->max_delivery_distance = $request->max_delivery_distance;
        // end address info

        // set owner info
        $restaurant->owner_name = $request->owner_name;
        $restaurant->owner_email = $request->owner_email;
        $restaurant->owner_phone = $request->owner_phone;
        // end owner info

        // set account info
        $restaurant->name = $request->name;
        // end account info

        // set other info
        $restaurant->opening_hour = $request->opening_hour;
        $restaurant->closing_hour = $request->closing_hour;
        $restaurant->min_processing_time = $request->min_processing_time;
        $restaurant->max_processing_time = $request->max_processing_time;
        $restaurant->time_slot_separate = $request->time_slot_separate;
        $restaurant->tags = $request->tags;
        $restaurant->is_featured = $request->is_featured ? 'enable' : 'disable';
        $restaurant->is_pickup_order = $request->is_pickup_order ? 'enable' : 'disable';
        $restaurant->is_delivery_order = $request->is_delivery_order ? 'enable' : 'disable';
        $restaurant->save();
        // end other info

        $notify_message= trans('translate.Updated Successfully');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);
    }

    public function update_password(PasswordChangeRequest $request): RedirectResponse
    {
        $restaurant = Auth::guard('restaurant')->user();

        if(Hash::check($request->current_password, $restaurant->password)){
            $restaurant->password = Hash::make($request->password);
            $restaurant->save();

            $notify_message = trans('translate.Password changed successfully');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
            return redirect()->back()->with($notify_message);

        }else{
            $notify_message = trans('translate.Current password does not match');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }


    }





}
