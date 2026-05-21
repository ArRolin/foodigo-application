<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\Offer;
use App\Models\Banner;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Modules\Blog\App\Models\Blog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseController;
use Modules\Cuisine\Entities\Cuisine;
use Modules\Page\App\Models\Homepage;
use Modules\Page\App\Models\ContactUs;
use Illuminate\Support\Facades\Session;
use Modules\Category\Entities\Category;
use Modules\Product\App\Models\Product;
use Modules\Blog\App\Models\BlogComment;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Currency\App\Models\Currency;
use Modules\Language\App\Models\Language;
use Modules\Page\App\Models\PrivacyPolicy;
use Modules\Restaurant\Entities\Restaurant;
use Modules\Page\App\Models\TermAndCondition;
use Modules\Page\App\Models\HomepageTranslation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Modules\GlobalSetting\App\Models\GlobalSetting;

class HomeController extends BaseController
{
    /**
     * Set language for the application
     */
    public function setLanguage($lang_code): JsonResponse
    {
        $language = Language::where('lang_code', $lang_code)->first();

        if (!$language) {
            return $this->sendError('Language not found', [], 404);
        }

        Session::put('front_lang', $lang_code);
        Session::put('front_lang_name', $language->name);
        app()->setLocale($lang_code);

        return $this->sendResponse(
            ['language_code' => $lang_code, 'language_name' => $language->name],
            trans('translate.Language switched successfully')
        );
    }

    /**
     * Switch currency
     */
    public function currencySwitcher(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'currency_code' => 'required|string|exists:currencies,currency_code'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        $request_currency = Currency::where('currency_code', $request->currency_code)->first();

        Session::put('currency_name', $request_currency->currency_name);
        Session::put('currency_code', $request_currency->currency_code);
        Session::put('currency_icon', $request_currency->currency_icon);
        Session::put('currency_rate', $request_currency->currency_rate);
        Session::put('currency_position', $request_currency->currency_position);

        return $this->sendResponse([
            'currency_name' => $request_currency->currency_name,
            'currency_code' => $request_currency->currency_code,
            'currency_icon' => $request_currency->currency_icon,
            'currency_rate' => $request_currency->currency_rate,
            'currency_position' => $request_currency->currency_position,
        ], trans('translate.Currency switched successfully'));
    }

    /**
     * Save user address
     */
    public function saveAddress(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        Session::put('address', $request->address);
        Session::put('latitude', $request->latitude);
        Session::put('longitude', $request->longitude);

        return $this->sendResponse([
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ], trans('translate.Address Saved Successfully'));
    }

    /**
     * Get homepage data
     */
    public function getHomepageData(): JsonResponse
    {
        try {
            $homepage = Homepage::first();
            $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();
            $categories = Category::where('status', 'enable')->get();

            $featured_products = Product::where('status', 'enable')
                ->with('restaurant')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('is_featured', 'enable')
                ->latest()
                ->take(8)
                ->get();

            $popular_products = Product::where('status', 'enable')
                ->with('restaurant')
                ->withCount(['orderItems', 'reviews'])
                ->withAvg('reviews', 'rating')
                ->orderBy('order_items_count', 'desc')
                ->latest()
                ->take(6)
                ->get();

            $cuisines = Cuisine::where('status', 'enable')->get();

            $restaurants = Restaurant::where('is_banned', 'disable')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('admin_approval', 'enable')
                ->latest()
                ->take(8)
                ->get();

            $blogs = Blog::where('status', 1)->latest()->take(3)->get();

            foreach ($cuisines as $cuisine) {
                $restaurant_count = Restaurant::where('is_banned', 'disable')
                    ->where('admin_approval', 'enable')
                    ->whereJsonContains('cuisines', "$cuisine->id")
                    ->count();
                $cuisine->total_restaurant = $restaurant_count;
            }

            $data = [
                'homepage' => $homepage,
                'home_translate' => $home_translate,
                'categories' => $categories,
                'featured_products' => $featured_products,
                'cuisines' => $cuisines,
                'restaurants' => $restaurants,
                'new_arrival_products' => $popular_products,
                'blogs' => $blogs,
            ];

            return $this->sendResponse($data, 'Homepage data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get categories
     */
    public function getCategories(Request $request): JsonResponse
    {
        try {
            $categories = Category::where('status', 'enable')->get();
            $foods = Product::where('status', 'enable')
                ->whereHas('offer')
                ->where('is_featured', 'enable')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->latest()
                ->take(6)
                ->get();

            $offer_status = 0;
            $today = date("Y-m-d H:i:s");
            $offer_data = Offer::first();
            if ($offer_data && $offer_data->status == 1) {
                if ($today <= $offer_data->end_time) {
                    $offer_status = 1;
                }
            }

            $data = [
                'categories' => $categories,
                'featured_foods' => $foods,
                'offer_status' => $offer_status,
                'offer_data' => $offer_data,
            ];

            return $this->sendResponse($data, 'Categories retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get about us data
     */
    public function getAbout(): JsonResponse
    {
        try {
            $about = AboutUs::first();
            $popular_products = Product::where('status', 'enable')
                ->withCount(['orderItems'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->orderBy('order_items_count', 'desc')
                ->latest()
                ->take(6)
                ->get();
            $blogs = Blog::where('status', 1)->latest()->take(3)->get();

            $data = [
                'about' => $about,
                'popular_products' => $popular_products,
                'blogs' => $blogs,
            ];

            return $this->sendResponse($data, 'About us data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get privacy policy
     */
    public function getPrivacyPolicy(): JsonResponse
    {
        try {
            $privacy_policy = PrivacyPolicy::where('lang_code', front_lang())->first();

            if (!$privacy_policy) {
                return $this->sendError('Privacy policy not found', [], 404);
            }

            return $this->sendResponse($privacy_policy, 'Privacy policy retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get terms and conditions
     */
    public function getTermsAndConditions(): JsonResponse
    {
        try {
            $terms_and_conditions = TermAndCondition::where('lang_code', front_lang())->first();

            if (!$terms_and_conditions) {
                return $this->sendError('Terms and conditions not found', [], 404);
            }

            return $this->sendResponse($terms_and_conditions, 'Terms and conditions retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get offer deals
     */
    public function getOfferDeals(): JsonResponse
    {
        try {
            $discount_products = Product::where('status', 'enable')
                ->whereHas('offer')
                ->latest()
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->get();

            $popular_products = Product::where('status', 'enable')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->withCount(['orderItems'])
                ->orderBy('order_items_count', 'desc')
                ->latest()
                ->take(6)
                ->get();

            $banners = Banner::where('status', 1)->get();

            $offer_status = 0;
            $today = date("Y-m-d H:i:s");
            $offer_data = Offer::first();
            if ($offer_data && $offer_data->status == 1) {
                if ($today <= $offer_data->end_time) {
                    $offer_status = 1;
                }
            }

            $data = [
                'discount_products' => $discount_products,
                'popular_products' => $popular_products,
                'banners' => $banners,
                'offer_data' => $offer_data,
                'offer_status' => $offer_status,
            ];

            return $this->sendResponse($data, 'Offer deals retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get contact us information
     */
    public function getContactInfo(): JsonResponse
    {
        try {
            $contact_us = ContactUs::first();

            return $this->sendResponse($contact_us, 'Contact information retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get blogs
     */
    public function getBlogs(Request $request): JsonResponse
    {
        try {
            $blogs = Blog::where('status', 1);

            if ($request->search) {
                $blogs = $blogs->whereHas('front_translate', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->category) {
                $blogs = $blogs->where('blog_category_id', $request->category);
            }

            $blogs = $blogs->latest()->paginate(9);

            return $this->sendPaginatedResponse($blogs, 'Blogs retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get blog details
     */
    public function getBlogDetails($slug): JsonResponse
    {
        try {
            $blog = Blog::where('slug', $slug)->with('comments')->first();

            if (!$blog) {
                return $this->sendError('Blog not found', [], 404);
            }

            $latest_blogs = Blog::where('slug', '!=', $slug)->get();
            $categories = BlogCategory::where('status', 1)->withcount('blogs')->get();

            $data = [
                'blog' => $blog,
                'categories' => $categories,
                'latest_blogs' => $latest_blogs,
            ];

            return $this->sendResponse($data, 'Blog details retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Submit blog comment
     */
    public function submitBlogComment(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $comment = new BlogComment();
            $comment->blog_id = $id;
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->comment = $request->comment;
            $comment->status = 1;
            $comment->save();

            return $this->sendResponse($comment, trans('translate.You submitted a comment'));
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get all restaurants
     */
    public function getAllRestaurants(Request $request): JsonResponse
    {
        try {
            $restaurants = Restaurant::where('is_banned', 'disable')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('admin_approval', 'enable');

            if ($request->cuisine_id) {
                $restaurants = $restaurants->whereJsonContains('cuisines', $request->cuisine_id);
            }

            $restaurants = $restaurants->latest()->paginate(8);

            $foods = Product::where('status', 'enable')
                ->whereHas('offer')
                ->where('is_featured', 'enable')
                ->latest()
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->take(9)
                ->get();

            $offer_status = 0;
            $today = date("Y-m-d H:i:s");
            $offer_data = Offer::first();
            if ($offer_data && $offer_data->status == 1) {
                if ($today <= $offer_data->end_time) {
                    $offer_status = 1;
                }
            }

            $data = [
                'restaurants' => $restaurants->items(),
                'pagination' => [
                    'current_page' => $restaurants->currentPage(),
                    'last_page' => $restaurants->lastPage(),
                    'per_page' => $restaurants->perPage(),
                    'total' => $restaurants->total(),
                ],
                'featured_foods' => $foods,
                'offer_data' => $offer_data,
                'offer_status' => $offer_status,
            ];

            return $this->sendResponse($data, 'Restaurants retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get single restaurant
     */
    public function getSingleRestaurant(Request $request, $slug): JsonResponse
    {
        try {
            $restaurant = Restaurant::where('slug', $slug)
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->first();

            if (!$restaurant) {
                return $this->sendError('Restaurant not found', [], 404);
            }

            $categories = Category::with(['products' => function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('status', 'enable')
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews');
            }])
                ->withCount(['products as filtered_products_count' => function ($query) use ($restaurant) {
                    $query->where('restaurant_id', $restaurant->id)->where('status', 'enable');
                }])
                ->get();

            $search_foods = Product::where('status', 'enable')
                ->where('restaurant_id', $restaurant->id)
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->when($request->has('search') && !empty($request->input('search')), function ($query) use ($request) {
                    $searchTerm = $request->input('search');
                    $keys = explode(' ', $searchTerm);

                    $query->whereHas('product_translate_lang', function ($query) use ($keys) {
                        foreach ($keys as $key) {
                            $query->where('name', 'LIKE', '%' . $key . '%');
                        }
                    });
                })
                ->get();



            $data = [
                'restaurant' => $restaurant,
                'categories' => $categories,
                'search_foods' => $search_foods,
            ];

            return $this->sendResponse($data, 'Restaurant details retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get all cuisines
     */
    public function getAllCuisines(): JsonResponse
    {
        try {
            $cuisines = Cuisine::where('status', 'enable')->get();
            $discount_products = Product::where('status', 'enable')
                ->whereHas('offer')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->latest()
                ->get();

            foreach ($cuisines as $cuisine) {
                $restaurants = Restaurant::where('is_banned', 'disable')
                    ->where('admin_approval', 'enable')
                    ->whereJsonContains('cuisines', "$cuisine->id")
                    ->count();
                $cuisine->total_restaurant = $restaurants;
            }

            $offer_status = 0;
            $today = date("Y-m-d H:i:s");
            $offer_data = Offer::first();
            if ($offer_data && $offer_data->status == 1) {
                if ($today <= $offer_data->end_time) {
                    $offer_status = 1;
                }
            }

            $data = [
                'cuisines' => $cuisines,
                'discount_products' => $discount_products,
                'offer_status' => $offer_status,
                'offer_data' => $offer_data,
            ];

            return $this->sendResponse($data, 'Cuisines retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Search products and restaurants
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $cuisines = Cuisine::where('status', 'enable')->get();
            $foods = Product::where('products.status', 'enable')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->when($request->has('search_value') && !empty($request->input('search_value')), function ($query) use ($request) {
                    $searchTerm = $request->input('search_value');
                    $keys = explode(' ', $searchTerm);

                    $query->whereHas('product_translate_lang', function ($query) use ($keys) {
                        foreach ($keys as $key) {
                            $query->where('name', 'LIKE', '%' . $key . '%');
                        }
                    });
                })
                ->when($request->categories != null, function ($query) use ($request) {
                    $query->whereIn('category_id', $request->categories);
                })
                ->when($request->sort == 'most_recent', function ($query) {
                    $query->latest();
                })
                ->when($request->price_max > 0, function ($query) use ($request) {
                    $min = is_numeric($request->price_min) ? $request->price_min : 0;
                    $max = is_numeric($request->price_max) ? $request->price_max : 100000;

                    $query->leftJoin('offer_products', function ($join) {
                        $join->on('products.id', '=', 'offer_products.product_id')
                            ->where('offer_products.status', 1);
                    });
                    $query->leftJoin('offers', function ($join) {
                        $join->on(DB::raw(1), '=', DB::raw(1))
                            ->where('offers.status', 1)
                            ->where('offers.end_time', '>=', now());
                    });

                    $query->whereRaw("
                        (
                            CASE
                                WHEN products.offer_price > 0 THEN products.offer_price
                                ELSE products.price
                            END
                            - IF(offers.offer IS NOT NULL, ((offers.offer / 100) *
                                CASE
                                    WHEN products.offer_price > 0 THEN products.offer_price
                                    ELSE products.price
                                END
                            ), 0)
                        ) BETWEEN ? AND ?
                    ", [$min, $max]);
                })
                ->when(!empty($request->cuisine), function ($query) use ($request) {
                    $cuisines = is_array($request->cuisine) ? $request->cuisine : explode(',', $request->cuisine);
                    $query->whereHas('restaurant', function ($q) use ($cuisines) {
                        $q->where(function ($subQuery) use ($cuisines) {
                            foreach ($cuisines as $cuisine) {
                                $subQuery->orWhereRaw('JSON_CONTAINS(cuisines, ?)', [json_encode([$cuisine])]);
                            }
                        });
                    });
                })
                ->paginate(6)
                ->withQueryString()
                ->onEachSide(2);

            $categories = Category::where('status', 'enable')->get();

            $restaurants = Restaurant::where('is_banned', 'disable')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->when($request->sort == 'most_recent', function ($query) {
                    $query->latest();
                })
                ->when($request->has('cuisine') && !empty($request->input('cuisine')), function ($query) use ($request) {
                    $cuisines = is_array($request->input('cuisine')) ? $request->input('cuisine') : explode(',', $request->input('cuisine'));

                    $query->where(function ($subQuery) use ($cuisines) {
                        foreach ($cuisines as $cuisine) {
                            $subQuery->orWhereRaw('JSON_CONTAINS(cuisines, ?)', [json_encode([$cuisine])]);
                        }
                    });
                })
                ->when($request->has('search_value') && !empty($request->input('search_value')), function ($query) use ($request) {
                    $searchTerm2 = $request->input('search_value');
                    $keys2 = explode(' ', $searchTerm2);

                    $query->where(function ($query) use ($keys2) {
                        foreach ($keys2 as $key) {
                            $query->orWhere('restaurant_name', 'LIKE', '%' . $key . '%');
                        }
                    });
                })
                ->where('admin_approval', 'enable')
                ->latest()
                ->get();

            $offer_status = 0;
            $today = date("Y-m-d H:i:s");
            $offer_data = Offer::first();
            if ($offer_data && $offer_data->status == 1) {
                if ($today <= $offer_data->end_time) {
                    $offer_status = 1;
                }
            }

            $data = [
                'foods' => $foods->items(),
                'pagination' => [
                    'current_page' => $foods->currentPage(),
                    'last_page' => $foods->lastPage(),
                    'per_page' => $foods->perPage(),
                    'total' => $foods->total(),
                ],
                'categories' => $categories,
                'cuisines' => $cuisines,
                'restaurants' => $restaurants,
                'offer_data' => $offer_data,
                'offer_status' => $offer_status,
            ];

            return $this->sendResponse($data, 'Search results retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get single product
     */
    public function getSingleProduct($product_id): JsonResponse
    {
        try {
            $product = Product::where('status', 'enable')
                ->withCount(['orderItems', 'reviews'])
                ->withAvg('reviews', 'rating')
                ->orderBy('order_items_count', 'desc')
                ->where('id', $product_id)
                ->first();

            if (!$product) {
                return $this->sendError('Product not found', [], 404);
            }

            return $this->sendResponse($product, 'Product retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get single product
     */
    public function websiteSetup(Request $request): JsonResponse
    {
        try {

            $userSplashScreen = GlobalSetting::where('key', 'splash_screens')->first();
            $userAllData = json_decode($userSplashScreen->value, true);
            $deliveryManSplashScreen = GlobalSetting::where('key', 'deliveryman_splash_screen')->first();
            $deliveryManAllData = json_decode($deliveryManSplashScreen->value, true);


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


            $data = [
                'splash_screens' => $userAllData,
                'deliveryman_splash_screen' => $deliveryManAllData,
                'language_list' => $language_list,
                'currency_list' => $currency_list,
                'lang_code' => $lang_code,
                'localizations' => $localizations,
            ];

            return $this->sendResponse($data, 'Splash Screens and Website Setup retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
