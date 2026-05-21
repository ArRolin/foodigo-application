<?php

namespace App\Http\Controllers\Api\Deliveryman;

use Hash;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Validator;

class DeliveryManProfileController extends BaseController
{
    public function edit(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $data = [
                'delivery_man' => $user
            ];
            return $this->sendResponse($data, 'Delivery Man edit page data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fname'      => 'required|string|max:100',
                'lname'      => 'required|string|max:100',
                'email'      => 'required|email|max:255',
                'man_type'   => 'required|in:male,female,other',
                'phone'      => 'required|string|max:20',
                'man_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'fname.required'     => __('translate.First name is required'),
                'fname.string'       => __('translate.First name must be a string'),
                'fname.max'          => __('translate.First name must not be longer than 100 characters'),

                'lname.required'     => __('translate.Last name is required'),
                'lname.string'       => __('translate.Last name must be a string'),
                'lname.max'          => __('translate.Last name must not be longer than 100 characters'),

                'email.required'     => __('translate.Email is required'),
                'email.email'        => __('translate.Invalid email format'),
                'email.max'          => __('translate.Email must not be longer than 255 characters'),

                'man_type.required'  => __('translate.Man type is required'),
                'man_type.in'        => __('translate.Man type must be male, female or other'),

                'phone.required'     => __('translate.Phone is required'),
                'phone.string'       => __('translate.Phone must be a string'),
                'phone.max'          => __('translate.Phone must not be longer than 20 characters'),

                'man_image.image'    => __('translate.Man image must be an image file'),
                'man_image.mimes'    => __('translate.Man image must be jpg, jpeg, png or webp'),
                'man_image.max'      => __('translate.Man image must not be larger than 2MB'),
            ]
        );


        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryman = $request->user();

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

                    $directory = public_path('uploads/custom-images');
                    if (!is_dir($directory)) {
                        mkdir($directory, 0775, true);
                    }

                    Image::make($user_image)->save(public_path($image_path));
                    $deliveryman->man_image = $image_path;
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                }
            }

            $deliveryman->save();

            $data = [
                'delivery_man' => $deliveryman
            ];
            return $this->sendResponse($data, trans('translate.Deliveryman updated successfully'));
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|min:4|max:100|confirmed',
            ],
            [
                'password.required' => trans('translate.Password is required'),
                'password.min' => trans('translate.Password minimum 4 character'),
                'password_confirmation.required' => trans('translate.Confirm password is required'),
                'password_confirmation.confirmed' => trans('translate.Confirm password do not match'),
            ]
        );
        
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $man = $request->user();

            if (Hash::check($request->current_password, $man->password)) {
                $man->password = Hash::make($request->password);
                $man->save();

                return $this->sendResponse(trans('translate.Password updated successfully'));
            } else {
                return $this->sendResponse(trans('translate.Current password does not match'));
            }
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
