<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Modules\Addon\App\Models\Addon;
use Illuminate\Http\JsonResponse;
use Modules\Language\App\Models\Language;
use Modules\Addon\App\Models\AddonTranslation;
use Illuminate\Support\Facades\Validator;
use Modules\Product\App\Models\Product;

class RestaurantAddonController extends BaseController
{
    public function addonList(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $addons = Addon::where('restaurant_id', $user->id)->latest()->get();

            $data = [
                'addons' => $addons
            ];

            return $this->sendResponse($data, 'Addon list retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }


    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'price' => 'required|numeric|min:0',
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            $addon = new Addon();
            $addon->price = $request->price;
            $addon->restaurant_id = $user->id;
            $addon->status = $request->status ? 'enable' : 'disable';
            $addon->save();

            $languages = Language::all();
            foreach ($languages as $language) {
                $addon_translation = new AddonTranslation();
                $addon_translation->addon_id = $addon->id;
                $addon_translation->lang_code = $language->lang_code;
                $addon_translation->name = $request->name;
                $addon_translation->save();
            }

            $data = [
                'addon' => $addon
            ];

            return $this->sendResponse($data, 'New addon created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function edit(Request $request, $id): JsonResponse
    {
        try {
            $addon = Addon::findOrFail($id);
            $addon_translate = AddonTranslation::where(['addon_id' => $id, 'lang_code' => $request->lang_code])->first();

            $data = [
                'addon' => $addon,
                'addon_translate' => $addon_translate
            ];

            return $this->sendResponse($data, 'Addon edit page data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'price' => 'required|numeric|min:0',
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();
            $addon = Addon::findOrFail($id);

            if ($request->lang_code == admin_lang()) {

                $addon->price = $request->price;
                $addon->restaurant_id = $user->id;
                $addon->status = $request->status ? 'enable' : 'disable';
                $addon->save();

                $addon_translation = AddonTranslation::findOrFail($request->translate_id);
                $addon_translation->name = $request->name;
                $addon_translation->save();
            } else {
                $addon_translation = AddonTranslation::findOrFail($request->translate_id);
                $addon_translation->name = $request->name;
                $addon_translation->save();
            }

            $data = [
                'addon' => $addon
            ];

            return $this->sendResponse($data, 'Addon updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function delete($id)
    {
        try {
            $addon = Addon::findOrFail($id);
            $productExists = Product::whereJsonContains('addon_items', (string)$id)->exists();

            if ($productExists) {
                return $this->sendResponse('Addon already exist in another product');
            }

            AddonTranslation::where('addon_id', $id)->delete();
            $addon->delete();

            return $this->sendResponse('Addon deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
