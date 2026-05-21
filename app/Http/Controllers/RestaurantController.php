<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Modules\City\Entities\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Cuisine\Entities\Cuisine;
use Modules\Restaurant\Entities\Restaurant;

class RestaurantController extends Controller
{
    public function apply_for_restaurant(){

        $cities = City::with('translate')->get();
        $cuisines = Cuisine::with('translate')->get();

        return view('frontend.apply_for_restaurant.apply', compact('cities', 'cuisines'));

    }

    public function restaurant_store(Request $request){

        $request->validate([
            'restaurant_name' => 'required|max:255',
            'city_id' => 'required',
            'cuisines' => 'required',
            'whatsapp' => 'required|max:255',
            'address' => 'required|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'max_delivery_distance' => 'required|numeric',
            'owner_name' => 'required|max:255',
            'owner_email' => 'required|max:255',
            'owner_phone' => 'required|max:255',
            'name' => 'required|max:255',
            'opening_hour' => 'required|max:255',
            'closing_hour' => 'required|max:255',
            'min_processing_time' => 'required|max:255|numeric',
            'max_processing_time' => 'required|max:255|numeric',
            'time_slot_separate' => 'required|max:255|numeric',
            'password' => 'required'
        ],[
            'restaurant_name.required' => trans('translate.Restaurant name is required'),
            'slug.required' => trans('translate.Slug is required'),
            'slug.unique' => trans('translate.Slug already exist'),
            'city_id.required' => trans('translate.City is required'),
            'cuisines.required' => trans('translate.Cuisine is required'),
            'logo.required' => trans('translate.Logo is required'),
            'whatsapp.required' => trans('translate.Whatsapp is required'),
            'address.required' => trans('translate.Address is required'),
            'latitude.required' => trans('translate.Latitude is required'),
            'longitude.required' => trans('translate.Longitude is required'),
            'max_delivery_distance.required' => trans('translate.Maximum delivery distance is required'),
            'owner_name.required' => trans('translate.Owner name is required'),
            'owner_email.required' => trans('translate.Owner email is required'),
            'owner_phone.required' => trans('translate.Owner phone is required'),
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'password.required' => trans('translate.Password is required'),
            'opening_hour.required' => trans('translate.Openning hour is required'),
            'closing_hour.required' => trans('translate.Closing hour is required'),
            'min_processing_time.required' => trans('translate.Minimum processing time is required'),
            'max_processing_time.required' => trans('translate.Maximum processing time is required'),
            'time_slot_separate.required' => trans('translate.Time slot separate is required'),
        ]);


        $restaurant = new Restaurant();

        // set basic info
        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->slug = $request->slug;
        $restaurant->city_id = $request->city_id;
        $restaurant->cuisines = json_encode($request->cuisines);

        if($request->logo){
            $image_name = 'restaurant-logo-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.webp';
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->logo)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $restaurant->logo = $image_name;
        }

        if($request->cover_image){
            $image_name = 'restaurant-cover-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.webp';
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->cover_image)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $restaurant->cover_image = $image_name;
        }

        // end basic info

        // set addres info
        $restaurant->whatsapp = $request->whatsapp;
        $restaurant->address = $request->address;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->max_delivery_distance = $request->max_delivery_distance;
        // end addres info

        // set owner info
        $restaurant->owner_name = $request->owner_name;
        $restaurant->owner_email = $request->owner_email;
        $restaurant->owner_phone = $request->owner_phone;
        // end owner info

        // set account info
        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->password = Hash::make($request->password);
        // end account info

        // set other info
        $restaurant->opening_hour = $request->opening_hour;
        $restaurant->closing_hour = $request->closing_hour;
        $restaurant->min_processing_time = $request->min_processing_time;
        $restaurant->max_processing_time = $request->max_processing_time;
        $restaurant->time_slot_separate = $request->time_slot_separate;
        $restaurant->tags = $request->tags;
        $restaurant->is_pickup_order = $request->is_pickup_order ? 'enable' : 'disable';
        $restaurant->is_delivery_order = $request->is_delivery_order ? 'enable' : 'disable';
        $restaurant->admin_approval = 'disable';
        $restaurant->save();

        $notify_message= trans('translate.Your application for the restaurant has been submitted successfully. Admin will reviewed the application');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->route('home')->with($notify_message);

    }
}
