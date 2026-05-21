<?php

namespace App\Http\Controllers\Api\Restaurant\Auth;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Restaurant\Entities\Restaurant;

class RestaurantLoginController extends BaseController
{
    /**
     * Restaurant login
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $restaurant = Restaurant::where('email', $request->email)->first();

            if (!$restaurant) {
                return $this->sendError('Email not found', [], 404);
            }

            if (!Hash::check($request->password, $restaurant->password)) {
                return $this->sendError('Invalid credentials', [], 401);
            }

            if ($restaurant->admin_approval !== 'enable') {
                return $this->sendError('Your account is not approved yet', [], 401);
            }

            if ($restaurant->is_banned === 'enable') {
                return $this->sendError('Your account is banned', [], 401);
            }

            // Create API token
            $token = $restaurant->createToken('restaurant-api-token')->plainTextToken;

            $data = [
                'restaurant' => [
                    'id' => $restaurant->id,
                    'restaurant_name' => $restaurant->restaurant_name,
                    'name' => $restaurant->name,
                    'email' => $restaurant->email,
                    'owner_name' => $restaurant->owner_name,
                    'owner_phone' => $restaurant->owner_phone,
                    'logo' => $restaurant->logo,
                    'cover_image' => $restaurant->cover_image,
                    'address' => $restaurant->address,
                    'latitude' => $restaurant->latitude,
                    'longitude' => $restaurant->longitude,
                    'admin_approval' => $restaurant->admin_approval,
                    'is_banned' => $restaurant->is_banned,
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ];

            return $this->sendResponse($data, 'Login successful');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Restaurant logout
     */


    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->sendResponse([], 'Logout successful');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
