<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Offer;
use App\Models\Banner;
use App\Rules\Captcha;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Modules\Blog\App\Models\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\Cuisine\Entities\Cuisine;
use Modules\Page\App\Models\Homepage;
use Illuminate\Contracts\View\Factory;
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
use Illuminate\Contracts\Support\Renderable;
use Modules\Page\App\Models\TermAndCondition;
use Modules\SeoSetting\App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Modules\Page\App\Models\HomepageTranslation;

class HomeController extends Controller
{

    public function set_language($lang_code): \Illuminate\Http\RedirectResponse
    {
        $language = Language::where('lang_code', $lang_code)->first();
        Session::put('front_lang', $lang_code);
        Session::put('front_lang_name', $language->name);
        app()->setLocale($lang_code);

        $notification = trans('translate.Language switched successfully');
        $notification = array('message' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function currency_switcher(Request $request)
    {

        $request_currency = Currency::where('currency_code', $request->currency_code)->first();

        Session::put('currency_name', $request_currency->currency_name);
        Session::put('currency_code', $request_currency->currency_code);
        Session::put('currency_icon', $request_currency->currency_icon);
        Session::put('currency_rate', $request_currency->currency_rate);
        Session::put('currency_position', $request_currency->currency_position);

        $notification = trans('translate.Currency switched successfully');
        $notification = array('message' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function save_address(Request $request)
    {

        Session::put('address', $request->address);
        Session::put('latitude', $request->latitude);
        Session::put('longitude', $request->longitude);

        $notification = trans('translate.Address Saved Successfully');
        $notification = array('message' => $notification, 'alert-type' => 'success');
        return redirect()->route('home')->with($notification);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function view_website()
    {
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();
        $categories = Category::where('status', 'enable')->get();

        $featured_products = Product::where('status', 'enable')->with('restaurant')->withAvg('reviews', 'rating')->withCount('reviews')->where('is_featured', 'enable')->latest()->take(8)->get();

        // return $featured_products;

        $popular_products = Product::where('status', 'enable')
            ->withCount(['orderItems', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('order_items_count', 'desc')
            ->latest()->take(6)->get();

        $cuisines = Cuisine::where('status', 'enable')->get();

        $restaurants = Restaurant::where('is_banned', 'disable')->withAvg('reviews', 'rating')->withCount('reviews')->where('admin_approval', 'enable')->latest()->take(8)->get();

        $blogs = Blog::where('status', 1)->latest()->take(3)->get();

        foreach ($cuisines as $cuisine) {
            $restaurant_count = Restaurant::where('is_banned', 'disable')->where('admin_approval', 'enable')->whereJsonContains('cuisines', "$cuisine->id")->count();
            $cuisine->total_restaurant = $restaurant_count;
        }

        $seo_setting = SeoSetting::where('id', 1)->first();


        return view('frontend.home.home', compact('homepage', 'home_translate', 'categories', 'featured_products', 'cuisines', 'restaurants', 'popular_products', 'blogs', 'seo_setting'));
    }

    /**
     * Show the application categories.
     *
     * @param Request $request
     * @return Renderable
     */
    public function view_categories(Request $request): Renderable
    {
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();
        $categories = Category::where('status', 'enable')->get();
        $foods = Product::where('status', 'enable')
            ->whereHas('offer')
            ->where('is_featured', 'enable')
            ->withAvg('reviews', 'rating')->withCount('reviews')
            ->latest()->take(6)->get();

        $offer_status = 0;

        $today = date("Y-m-d H:i:s");
        $offer_data = Offer::first();
        if ($offer_data && $offer_data->status == 1) {
            if ($today <= $offer_data->end_time) {
                $offer_status = 1;
            }
        }

        $seo_setting = SeoSetting::where('id', 7)->first();

        return view('frontend.categories.index', compact('homepage', 'home_translate', 'categories', 'foods', 'offer_status', 'offer_data', 'seo_setting'));
    }

    /**
     * Show the application about.
     *
     * @return Renderable
     */
    public function about(): Renderable
    {
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();
        $about = AboutUs::first();
        $popular_products = Product::where('status', 'enable')
            ->withCount(['orderItems'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderBy('order_items_count', 'desc')
            ->latest()->take(6)->get();
        $blogs = Blog::where('status', 1)->latest()->take(3)->get();

        $seo_setting = SeoSetting::where('id', 3)->first();

        return view('frontend.about.index', compact('homepage', 'home_translate', 'about', 'popular_products', 'blogs', 'seo_setting'));
    }

    /**
     * Show the application about.
     *
     * @return Renderable
     */
    public function privacy_policy(): Renderable
    {
        $privacy_policy = PrivacyPolicy::where('lang_code', front_lang())->first();

        $seo_setting = SeoSetting::where('id', 10)->first();

        return view('frontend.privacy.index', compact('privacy_policy', 'seo_setting'));
    }

    /**
     * Show the application about.
     *
     * @return Renderable
     */
    public function terms_and_conditions(): Renderable
    {
        $terms_and_conditions = TermAndCondition::where('lang_code', front_lang())->first();

        $seo_setting = SeoSetting::where('id', 6)->first();

        return view('frontend.terms_and_conditions.index', compact('terms_and_conditions', 'seo_setting'));
    }

    /**
     * Show the application contact us.
     *
     * @return Renderable
     */
    public function offer_deal(): Renderable
    {
        $discount_products = Product::where('status', 'enable')->whereHas('offer')->latest()->withAvg('reviews', 'rating')->withCount('reviews')->get();;

        $popular_products = Product::where('status', 'enable')->withAvg('reviews', 'rating')->withCount('reviews')->withCount(['orderItems'])
            ->orderBy('order_items_count', 'desc')
            ->latest()->take(6)->get();

        $homepage = Homepage::first();

        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();

        $banners = Banner::where('status', 1)->get();

        $offer_status = 0;

        $today = date("Y-m-d H:i:s");
        $offer_data = Offer::first();
        if ($offer_data && $offer_data->status == 1) {
            if ($today <= $offer_data->end_time) {
                $offer_status = 1;
            }
        }

        $seo_setting = SeoSetting::where('id', 9)->first();

        return view('frontend.offer.index', compact('homepage', 'home_translate', 'discount_products', 'popular_products', 'banners', 'offer_data', 'offer_status', 'seo_setting'));
    }

    /**
     * Show the application contact us.
     *
     * @return Renderable
     */
    public function help(): Renderable
    {
        $contact_us = ContactUs::first();
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();

        $seo_setting = SeoSetting::where('id', 4)->first();

        return view('frontend.contact.index', compact('homepage', 'home_translate', 'contact_us', 'seo_setting'));
    }


    /**
     * Show the application blog.
     *
     * @return Renderable
     */
    public function blog(Request $request): Renderable
    {

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

        $blogs = $blogs->appends($request->all());

        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();

        $seo_setting = SeoSetting::where('id', 2)->first();

        return view('frontend.blog.index', compact('blogs', 'homepage', 'home_translate', 'seo_setting'));
    }

    /**
     * Show the application blog details.
     *
     * @param $slug
     * @return Renderable
     */
    public function blog_details($slug): Renderable
    {
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();
        $blog = Blog::where('slug', $slug)->with('comments')->first();
        $latest_blogs = Blog::where('slug', '!=', $slug)->get();
        $categories = BlogCategory::where('status', 1)->withcount('blogs')->get();
        return view('frontend.blog.blog_details', compact('blog', 'categories', 'latest_blogs', 'homepage', 'home_translate'));
    }

    public function blog_comment(Request $request, $id)
    {


        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
            'g-recaptcha-response' => new Captcha()
        ], [
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'comment.required' => trans('translate.Email is required'),
        ]);

        $comment = new BlogComment();
        $comment->blog_id = $id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->status = 1;
        $comment->save();

        $notification = trans('translate.You submitted a comment');
        $notification = array('message' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function view_all_restaurant(Request $request): Renderable
    {
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();

        $restaurants = Restaurant::where('is_banned', 'disable')->withAvg('reviews', 'rating')->withCount('reviews')->where('admin_approval', 'enable');

        if ($request->cuisine_id) {
            $restaurants = $restaurants->whereJsonContains('cuisines', $request->cuisine_id);
        }

        $restaurants = $restaurants->latest()->paginate(8);

        $foods = Product::where('status', 'enable')->whereHas('offer')->where('is_featured', 'enable')->latest()->withAvg('reviews', 'rating')->withCount('reviews')->take(9)->get();

        $offer_status = 0;

        $today = date("Y-m-d H:i:s");
        $offer_data = Offer::first();
        if ($offer_data && $offer_data->status == 1) {
            if ($today <= $offer_data->end_time) {
                $offer_status = 1;
            }
        }

        $seo_setting = SeoSetting::where('id', 11)->first();

        return view('frontend.restaurant.all', compact('restaurants', 'foods', 'homepage', 'home_translate', 'offer_data', 'offer_status', 'seo_setting'));
    }

    public function view_single_restaurant(Request $request, $slug)
    {
        $homepage = Homepage::first();

        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();

        $restaurant = Restaurant::where('slug', $slug)->withAvg('reviews', 'rating')->withCount('reviews')->first();

        $categories = Category::with(['products' => function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id)
                ->withAvg('reviews', 'rating')
                ->withCount('reviews');
        }])
            ->withCount(['products as filtered_products_count' => function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            }])
            ->get();


        $search_foods = Product::where('status', 'enable')
            ->where('restaurant_id', $restaurant->id)
            ->withAvg('reviews', 'rating')->withCount('reviews')
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


        return view('frontend.restaurant.single', compact('restaurant', 'categories', 'homepage', 'home_translate', 'search_foods'));
    }

    public function view_all_cuisine(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $cuisines = Cuisine::where('status', 'enable')->get();
        $discount_products = Product::where('status', 'enable')->whereHas('offer')->withAvg('reviews', 'rating')->withCount('reviews')->latest()->get();
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();

        foreach ($cuisines as $cuisine) {
            $restaurants = Restaurant::where('is_banned', 'disable')->where('admin_approval', 'enable')->whereJsonContains('cuisines', "$cuisine->id")->count();
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

        $seo_setting = SeoSetting::where('id', 8)->first();

        return view('frontend.cuisine.all', compact('cuisines', 'discount_products', 'homepage', 'home_translate', 'offer_status', 'offer_data', 'seo_setting'));
    }

    /**
     * Show the application contact us.
     *
     * @param Request $request
     * @return Renderable
     */
    public function search(Request $request): Renderable
    {
        $homepage = Homepage::first();
        $home_translate = HomepageTranslation::where(['homepage_id' => $homepage->id, 'lang_code' => front_lang()])->first();
        $cuisines = Cuisine::where('status', 'enable')->get();
        $foods = Product::where('products.status', 'enable')
            ->withAvg('reviews', 'rating')->withCount('reviews')
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
            })->when($request->price_max > 0, function ($query) use ($request) {
                // Approximate final price calculation
                $min = is_numeric($request->price_min) ? $request->price_min : 0;
                $max = is_numeric($request->price_max) ? $request->price_max : 100000;

                // Optional: join offer_products and offers
                $query->leftJoin('offer_products', function ($join) {
                    $join->on('products.id', '=', 'offer_products.product_id')
                        ->where('offer_products.status', 1);
                });
                $query->leftJoin('offers', function ($join) {
                    $join->on(DB::raw(1), '=', DB::raw(1)) // just one global offer
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
            })->when(!empty($request->cuisine), function ($query) use ($request) {
                $cuisines = is_array($request->cuisine) ? $request->cuisine : explode(',', $request->cuisine);
                $query->whereHas('restaurant', function ($q) use ($cuisines) {
                    $q->where(function ($subQuery) use ($cuisines) {
                        foreach ($cuisines as $cuisine) {
                            $subQuery->orWhereRaw('JSON_CONTAINS(cuisines, ?)', [json_encode([$cuisine])]);
                        }
                    });
                });
            })->paginate(6)->withQueryString()->onEachSide(2);

        $categories = Category::where('status', 'enable')->get();

        $discount_products = Product::where('status', 'enable')->latest()
            ->when($request->has('search_value') && !empty($request->input('search_value')), function ($query) use ($request) {

                $searchTerm = $request->input('search_value');
                $keys = explode(' ', $searchTerm);

                $query->whereHas('product_translate_lang', function ($query) use ($keys) {
                    foreach ($keys as $key) {
                        $query->where('name', 'LIKE', '%' . $key . '%');
                    }
                });
            })
            ->whereHas('offer')
            ->withAvg('reviews', 'rating')->withCount('reviews')
            ->get();

        $restaurants = Restaurant::where('is_banned', 'disable')
            ->withAvg('reviews', 'rating')->withCount('reviews')
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
            ->where('admin_approval', 'enable')->latest()->get();

        $offer_status = 0;

        $today = date("Y-m-d H:i:s");
        $offer_data = Offer::first();
        if ($offer_data && $offer_data->status == 1) {
            if ($today <= $offer_data->end_time) {
                $offer_status = 1;
            }
        }

        $seo_setting = SeoSetting::where('id', 12)->first();

        return view('frontend.search.index', compact('foods', 'categories', 'discount_products', 'cuisines', 'home_translate', 'homepage', 'restaurants', 'offer_data', 'offer_status', 'seo_setting'));
    }


    public function get_single_product($product_id)
    {

        $product = Product::where('status', 'enable')
            ->withCount(['orderItems', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('order_items_count', 'desc')
            ->where('id', $product_id)
            ->first();

        return view('frontend.home.product_modal', compact('product'));
        //    return response()->json($product);
    }
}
