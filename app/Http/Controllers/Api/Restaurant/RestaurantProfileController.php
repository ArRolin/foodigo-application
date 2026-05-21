<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Modules\City\Entities\City;
use Modules\Cuisine\Entities\Cuisine;

class RestaurantProfileController extends BaseController
{

    public function edit(Request $request): JsonResponse
    {
        try {
            $restaurant = $request->user();
            $cities = City::with('translate')->get();
            $cuisines = Cuisine::with('translate')->get();

            $data = [
                'restaurant' => [
                    'restaurant' => $restaurant,
                    'cities' => $cities,
                    'cuisines' => $cuisines,
                ]
            ];

            return $this->sendResponse($data, 'Profile edit page data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'restaurant_name'      => 'required|max:255',
                'city_id'              => 'required',
                'cuisines'             => 'required',
                'whatsapp'             => 'required|max:255',
                'address'              => 'required|max:255',
                'latitude'             => 'required',
                'longitude'            => 'required',
                'max_delivery_distance' => 'required|numeric',
                'owner_name'           => 'required|max:255',
                'owner_email'          => 'required|max:255',
                'owner_phone'          => 'required|max:255',
                'name'                 => 'required|max:255',
                'opening_hour'         => 'required|max:255',
                'closing_hour'         => 'required|max:255',
                'min_processing_time'  => 'required|numeric|max:255',
                'max_processing_time'  => 'required|numeric|max:255',
                'time_slot_separate'   => 'required|numeric|max:255',
            ],
            [
                'restaurant_name.required'   => __('translate.Restaurant name is required'),
                'city_id.required'           => __('translate.City is required'),
                'cuisines.required'          => __('translate.Cuisine is required'),
                'whatsapp.required'          => __('translate.Whatsapp is required'),
                'address.required'           => __('translate.Address is required'),
                'latitude.required'          => __('translate.Latitude is required'),
                'longitude.required'         => __('translate.Longitude is required'),
                'max_delivery_distance.required' => __('translate.Maximum delivery distance is required'),
                'owner_name.required'        => __('translate.Owner name is required'),
                'owner_email.required'       => __('translate.Owner email is required'),
                'owner_phone.required'       => __('translate.Owner phone is required'),
                'name.required'              => __('translate.Name is required'),
                'opening_hour.required'      => __('translate.Openning hour is required'),
                'closing_hour.required'      => __('translate.Closing hour is required'),
                'min_processing_time.required' => __('translate.Minimum processing time is required'),
                'max_processing_time.required' => __('translate.Maximum processing time is required'),
                'time_slot_separate.required' => __('translate.Time slot separate is required'),
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $restaurant = $request->user();

            $restaurant->restaurant_name = $request->restaurant_name;
            $restaurant->city_id = $request->city_id;
            $restaurant->cuisines = $request->cuisines;

            if ($request->logo) {
                $old_image = $restaurant->logo;
                $image_name = 'restaurant-logo-' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.webp';
                $image_name = 'uploads/custom-images/' . $image_name;
                Image::make($request->logo)
                    ->encode('webp', 80)
                    ->save(public_path() . '/' . $image_name);
                $restaurant->logo = $image_name;
                $restaurant->save();

                if ($old_image) {
                    if (File::exists(public_path() . '/' . $old_image)) unlink(public_path() . '/' . $old_image);
                }
            }

            if ($request->cover_image) {
                $old_image = $restaurant->cover_image;
                $image_name = 'restaurant-cover-' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.webp';
                $image_name = 'uploads/custom-images/' . $image_name;
                Image::make($request->cover_image)
                    ->encode('webp', 80)
                    ->save(public_path() . '/' . $image_name);
                $restaurant->cover_image = $image_name;
                $restaurant->save();
                if ($old_image) {
                    if (File::exists(public_path() . '/' . $old_image)) unlink(public_path() . '/' . $old_image);
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

            $data = [
                'restaurant' => $restaurant,
            ];

            return $this->sendResponse($data, 'Profile data updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }


    public function updatePassword(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password'         => 'required|min:4|max:100|confirmed',
            ],
            [
                'current_password.required' => __('translate.Current password is required'),
                'password.required'         => __('translate.Password is required'),
                'password.confirmed'        => __('translate.Password confirmation is required'),
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {

            $restaurant = $request->user();

            if (Hash::check($request->current_password, $restaurant->password)) {
                $restaurant->password = Hash::make($request->password);
                $restaurant->save();

                return $this->sendResponse('Password updated successfully');
            } else {
                return $this->sendResponse('Current password does not match');
            }

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
