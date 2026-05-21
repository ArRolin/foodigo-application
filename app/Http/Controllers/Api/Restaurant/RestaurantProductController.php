<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Modules\Product\App\Models\Product;
use Illuminate\Http\JsonResponse;
use Modules\Addon\App\Models\Addon;
use Modules\Category\Entities\Category;
use Modules\Restaurant\Entities\Restaurant;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Modules\Language\App\Models\Language;
use Modules\Product\App\Models\ProductTranslation;
use Illuminate\Support\Facades\File;

class RestaurantProductController extends BaseController
{
    public function productList(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $products = Product::where('restaurant_id', $user->id)
                ->with([
                    'translate_product',
                    'product_translate_lang',
                    'category',
                    'restaurant',
                    'offer',
                    'orderItems',
                    'reviews'
                ])
                ->latest()
                ->get();

            $data = [
                'product_list' => $products
            ];

            return $this->sendResponse($data, 'Product list retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $categories = Category::with('translate')->where('status', 'enable')->get();
            $addons = Addon::where('restaurant_id', $user->id)->with('translate')->where('status', 'enable')->get();

            $data = [
                'user' => $user,
                'categories' => $categories,
                'addons' => $addons,
            ];

            return $this->sendResponse($data, 'Product create page data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function edit(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            $product = Product::find($id);
            $categories = Category::with('translate')->where('status', 'enable')->get();
            $addons = Addon::where('restaurant_id', $user->id)->with(['translate', 'front_translate', 'restaurant'])->where('status', 'enable')->get();
            $product_translate = ProductTranslation::where(['product_id' => $id, 'lang_code' => $request->lang_code])->first();

            $intArray = json_decode($product->addon_items);

            if ($intArray != null) {
                $selected_ids = array_map('intval', $intArray);
            } else {
                $selected_ids = array();
            }

            $data = [
                'user' => $user,
                'categories' => $categories,
                'addons' => $addons,
                'product' => $product,
                'selected_ids' => $selected_ids,
                'product_translate' => $product_translate,
            ];

            return $this->sendResponse($data, 'Product edit page data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'         => 'required|string',
                'slug'         => 'required|string',
                'category_id'  => 'required|integer',
                'image'        => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
                'product_price' => 'required|numeric|min:0',
            ],
            [
                'name.required'         => __('translate.Name is required'),
                'name.string'           => __('translate.Name should be string'),
                'slug.required'         => __('translate.Slug is required'),
                'slug.string'           => __('translate.Slug should be string'),
                'category_id.required'  => __('translate.Category is required'),
                'image.required'        => __('translate.Image is required'),
                'image.mimes'           => __('translate.Image must be jpg, jpeg, png or webp'),
                'image.max'             => __('translate.Image must not be larger than 2MB'),
                'product_price.required' => __('translate.Price is required'),
                'product_price.numeric' => __('translate.Price must be numeric'),
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $product = new Product();
            $user = $request->user();

            if ($request->image) {
                $extention = $request->image->getClientOriginalExtension();
                $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                $image_name = 'uploads/custom-images/' . $image_name;
                Image::make($request->image)->save(public_path() . '/' . $image_name);
                $product->image = $image_name;
            }

            $product->slug = $request->slug;
            $product->restaurant_id = $user->id;
            $product->category_id = $request->category_id;
            $product->price = $request->product_price;
            $product->offer_price = $request->offer_price == null ? 0 : $request->offer_price;
            $product->addon_items = $request->addon_items;
            $product->status = $request->status == 'on' ? 'enable' : 'disable';
            $product->save();

            $languages = Language::all();
            foreach ($languages as $language) {
                $translate = new ProductTranslation();
                $translate->product_id = $product->id;
                $translate->lang_code = $language->lang_code;
                $translate->name = $request->name;
                $translate->short_description = $request->short_description;
                $translate->size = json_encode(array_combine(json_decode($request->size, true), json_decode($request->price, true)));
                if ($request->specification === null) {
                    $translate->specification = json_encode(['specification' => 'Specification']);
                } else {
                    $translate->specification = $request->specification;
                }
                $translate->save();
            }

            $data = [
                'product' => $product
            ];

            return $this->sendResponse($data, 'New Product has been created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'         => 'required|string',
                'slug'         => 'required|string',
                'category_id'  => 'required|integer',
                'image'        => 'file|mimes:jpg,jpeg,png,webp|max:2048',
                'product_price' => 'required|numeric|min:0',
            ],
            [
                'name.required'         => __('translate.Name is required'),
                'name.string'           => __('translate.Name should be string'),
                'slug.required'         => __('translate.Slug is required'),
                'slug.string'           => __('translate.Slug should be string'),
                'category_id.required'  => __('translate.Category is required'),
                'image.required'        => __('translate.Image is required'),
                'image.mimes'           => __('translate.Image must be jpg, jpeg, png or webp'),
                'image.max'             => __('translate.Image must not be larger than 2MB'),
                'product_price.required' => __('translate.Price is required'),
                'product_price.numeric' => __('translate.Price must be numeric'),
            ]
        );

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        // return response()->json($request);

        // try {
            $product = Product::find($id);
            $user = $request->user();
            $old_image = $product->image;


            if ($request->lang_code == admin_lang()) {
                if ($request->image) {
                    $extention = $request->image->getClientOriginalExtension();
                    $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                    $image_name = 'uploads/custom-images/' . $image_name;
                    Image::make($request->image)
                        ->save(public_path() . '/' . $image_name);
                    if ($old_image) {
                        if (File::exists(public_path() . '/' . $old_image)) unlink(public_path() . '/' . $old_image);
                    }
                    $product->image = $image_name;
                }

                $product->slug = $request->slug;
                $product->restaurant_id = $user->id;
                $product->category_id = $request->category_id;
                $product->price = $request->product_price;
                $product->offer_price = $request->offer_price == null ? 0 : $request->offer_price;
                $product->addon_items = $request->addon_items;
                $product->status = $request->status == 'on' ? 'enable' : 'disable';
                $product->save();


                $translate = ProductTranslation::findOrFail($request->translate_id);
                $translate->name = $request->name;
                $translate->short_description = $request->short_description;
                $translate->size = json_encode(array_combine(json_decode($request->size, true), json_decode($request->price, true)));
                if ($request->specification === null) {
                    $translate->specification = json_encode(['specification' => 'Specification']);
                } else {
                    $translate->specification = $request->specification;
                }
                $translate->save();
            } else {
                $translate = ProductTranslation::findOrFail($request->translate_id);
                $translate->name = $request->name;
                $translate->short_description = $request->short_description;
                $translate->size = json_encode(array_combine(json_decode($request->size, true), json_decode($request->price, true)));
                if ($request->specification === null) {
                    $translate->specification = json_encode(['specification' => 'Specification']);
                } else {
                    $translate->specification = $request->specification;
                }
                $translate->save();
            }

            $data = [
                'product' => $product
            ];

            return $this->sendResponse($data, 'Product Updated successfully');
        // } catch (\Exception $e) {
        //     return $this->sendError('Something went wrong', [], 500);
        // }
    }

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $old_image = $product->image;
            $product->delete();

            ProductTranslation::where('product_id', $id)->delete();

            if ($old_image) {
                if (File::exists(public_path() . '/' . $old_image)) unlink(public_path() . '/' . $old_image);
            }


            return $this->sendResponse('Product Deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
