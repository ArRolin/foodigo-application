<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\DocumentType;
use App\Models\VehicleType;
use Modules\City\Entities\City;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Currency\App\Models\Currency;
use Modules\Language\App\Models\Language;

class DeliveryManResourceController extends BaseController
{
    /**
     * Get all active cities
     * 
     * @return JsonResponse
     */
    public function registerData(): JsonResponse
    {
        try {
            $cities = City::with('front_translate')
                ->get()
                ->map(fn($city) => [
                    'id' => $city->id,
                    'name' => $city->name,
                ])
                ->values();

            $documentTypes = DocumentType::where('status', 'enable')
                ->with('front_translate')
                ->get()
                ->map(fn($type) => [
                    'id' => $type->id,
                    'name' => $type->name,
                    'slug' => $type->slug,
                ])
                ->values();

            $vehicleTypes = VehicleType::where('status', 'enable')
                ->with('front_translate')
                ->get()
                ->map(fn($type) => [
                    'id' => $type->id,
                    'name' => $type->name,
                    'slug' => $type->slug,
                ])
                ->values();

            return $this->sendResponse([
                'cities' => $cities,
                'document_types' => $documentTypes,
                'vehicle_types' => $vehicleTypes,
            ], 'Data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function getCities(): JsonResponse
    {
        try {
            $cities = City::with('front_translate')
                ->get()
                ->map(function ($city) {
                    return [
                        'id' => $city->id,
                        'name' => $city->name,
                    ];
                })
                ->values();

            return $this->sendResponse($cities, 'Cities retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get all active document types
     * 
     * @return JsonResponse
     */
    public function getDocumentTypes(): JsonResponse
    {
        try {
            $documentTypes = DocumentType::where('status', 'enable')
                ->with('front_translate')
                ->get()
                ->map(function ($type) {
                    return [
                        'id' => $type->id,
                        'name' => $type->name,
                        'slug' => $type->slug,
                    ];
                })
                ->values();

            return $this->sendResponse($documentTypes, 'Document types retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get all active vehicle types
     * 
     * @return JsonResponse
     */
    public function getVehicleTypes(): JsonResponse
    {
        try {
            $vehicleTypes = VehicleType::where('status', 'enable')
                ->with('front_translate')
                ->get()
                ->map(function ($type) {
                    return [
                        'id' => $type->id,
                        'name' => $type->name,
                        'slug' => $type->slug,
                    ];
                })
                ->values();

            return $this->sendResponse($vehicleTypes, 'Vehicle types retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get Delivery Man Splash Screen
     * 
     * @return JsonResponse
     */
    public function getSplashScreen(Request $request): JsonResponse
    {
        try {

            $screens = GlobalSetting::where('key', 'deliveryman_splash_screen')->first();

            $language_list = Language::where('status', 1)->get();
            $currency_list = Currency::where('status', 'active')->get();
            $lang_code = 'en';

            if ($request->lang_code) {
                $lang_code = $request->lang_code;
            } else {
                $default_lang = Language::where('id', 1)->first();
                if ($default_lang) {
                    $lang_code = $default_lang->lang_code;
                } else {
                    $lang_code = 'en';
                }
            }

            try {

                $localizations = include(lang_path($lang_code . '/translate.php'));
            } catch (\Exception $ex) {
                return response()->json([
                    'message' => trans('Localication unprocessable')
                ], 403);
            }

            if (!$screens || !$screens->value) {
                return $this->sendResponse([
                    'heading' => 'Welcome to Delivery Service',
                    'subheading' => 'Start earning by delivering food to customers',
                    'image' => asset('uploads/website-images/default.png'),
                    'language_list' => $language_list,
                    'currency_list' => $currency_list,
                    'lang_code' => $lang_code,
                    'localizations' => $localizations,
                ], 'Splash screen retrieved successfully');
            }

            $data = json_decode($screens->value, true);

            // Add full URL to image
            if (!empty($data['image'])) {
                $data['image'] = asset($data['image']);
            } else {
                $data['image'] = asset('uploads/website-images/default.png');
            }

            // Add language, currency, and localization data
            $data['language_list'] = $language_list;
            $data['currency_list'] = $currency_list;
            $data['lang_code'] = $lang_code;
            $data['localizations'] = $localizations;

            return $this->sendResponse($data, 'Splash screen and Website Setup retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }
}
