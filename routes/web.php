<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Deliveryman\Auth\DeliveryManLoginController;
use App\Http\Controllers\Deliveryman\DeliveryManDashboardController;
use App\Http\Controllers\Deliveryman\DeliveryManOrderController;
use App\Http\Controllers\Deliveryman\DeliveryManProfileController;
use App\Http\Controllers\Deliveryman\PaymentWithdrawController;
use App\Http\Controllers\Deliveryman\WithdrawMethodController;
use App\Http\Controllers\Admin\DeliveryManController;
use App\Http\Controllers\Deliveryman\DeliverymanWithdrawController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\UserAddressController;

use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\Auth\UserLoginController;
use App\Http\Controllers\Frontend\Auth\UserPasswordController;
use App\Http\Controllers\Frontend\Auth\UserRegisterController;
use App\Http\Controllers\Frontend\RestaurantWishlistController;
use App\Http\Controllers\Restaurant\RestaurantProfileController;
use App\Http\Controllers\Restaurant\RestaurantDashboardController;
use App\Http\Controllers\Restaurant\Auth\RestaurantLoginController;
use Illuminate\Support\Facades\Artisan;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use App\Http\Controllers\Api\PaymentController as ApiPaymentController;

Route::group(['as' => 'payment-api.', 'prefix' => 'payment-api', 'middleware' => ['web']], function () {

    Route::get('/pay-with-stripe', [APIPaymentController::class, 'pay_with_stripe'])->name('pay-with-stripe');

    Route::get('/webview-stripe-success', [APIPaymentController::class, 'webview_stripe_success'])->name('webview-stripe-success');
    Route::get('/webview-stripe-faild', [APIPaymentController::class, 'webview_stripe_faild'])->name('webview-stripe-faild');

    Route::get('/webview-success-payment', [APIPaymentController::class, 'webview_success_payment'])->name('webview-success-payment');
    Route::get('/webview-faild-payment', [APIPaymentController::class, 'webview_faild_payment'])->name('webview-faild-payment');


    Route::get('/paypal-webview', [ApiPaymentController::class, 'paypal_webview'])->name('paypal-webview');
    Route::get('/paypal-webview-success', [ApiPaymentController::class, 'paypal_webview_success'])->name('paypal-webview-success');

    Route::get('/razorpay-webview', [APIPaymentController::class, 'razorpay_webview_web'])->name('razorpay-webview');
    Route::get('/razorpay-webview-payment', [APIPaymentController::class, 'razorpay_webview_payment'])->name('razorpay-webview-payment');

    Route::get('/flutterwave-webview', [APIPaymentController::class, 'flutterwave_webview'])->name('flutterwave-webview');
    Route::post('/flutterwave-webview-payment', [APIPaymentController::class, 'flutterwave_webview_payment'])->name('flutterwave-webview-payment');

    Route::get('/mollie-webview', [APIPaymentController::class, 'mollie_webview'])->name('mollie-webview');
    Route::get('/mollie-webview-payment', [APIPaymentController::class, 'mollie_webview_payment'])->name('mollie-webview-payment');

    Route::get('/paystack-webview', [APIPaymentController::class, 'paystack_webview'])->name('paystack-webview');
    Route::get('/paystack-webview-payment', [APIPaymentController::class, 'paystack_webview_payment'])->name('paystack-webview-payment');

    Route::get('/instamojo-webview', [APIPaymentController::class, 'instamojo_webview'])->name('instamojo-webview');
    Route::get('/instamojo-webview-payment', [APIPaymentController::class, 'instamojo_webview_payment'])->name('instamojo-webview-payment');
});


Route::group(['middleware' => [ 'HtmlSpecialchars', 'MaintenanceMode']], function () {

    // PWA Routes
    Route::get('/manifest.json', function () {
        $manifest = view('pwa.manifest')->render();
        return response($manifest, 200, ['Content-Type' => 'application/json']);
    })->name('manifest.json');

    Route::get('/service-worker.js', function () {
        $serviceWorker = view('pwa.service-worker')->render();
        return response($serviceWorker, 200, ['Content-Type' => 'application/javascript']);
    })->name('service-worker.js');

    Route::get('/', [HomeController::class, 'view_website'])->name('home');
    Route::get('/categories', [HomeController::class, 'view_categories'])->name('website.categories');
    Route::get('/about-us', [HomeController::class,'about'])->name('about');
    Route::get('/privacy-policy', [HomeController::class,'privacy_policy'])->name('privacy.policy');
    Route::get('/terms-and-conditions', [HomeController::class,'terms_and_conditions'])->name('terms.and.conditions');
    Route::get('/offer', [HomeController::class,'offer_deal'])->name('offer');
    Route::get('/contact-us', [HomeController::class,'help'])->name('contact');
    Route::get('/blog', [HomeController::class,'blog'])->name('blog');
    Route::get('/all-restaurant', [HomeController::class,'view_all_restaurant'])->name('all.restaurant');
    Route::get('/view-restaurant/{slug}', [HomeController::class,'view_single_restaurant'])->name('single.restaurant');
    Route::get('/blog/{slug}', [HomeController::class,'blog_details'])->name('blog.details');
    Route::post('/blog/comment/{id}', [HomeController::class,'blog_comment'])->name('blog.comment');
    Route::get('/cuisines', [HomeController::class,'view_all_cuisine'])->name('all.cuisine');
    Route::get('/search', [HomeController::class,'search'])->name('search');
    Route::get('/get-single-product/{product_id}', [HomeController::class,'get_single_product'])->name('get-single-product');

    Route::get('/apply-restaurant', [RestaurantController::class,'apply_for_restaurant'])->name('apply-for-restaurant');
    Route::post('/apply-restaurant-store', [RestaurantController::class,'restaurant_store'])->name('store-restaurant');


    Route::get('/lang/{lang_code}', [HomeController::class,'set_language'])->name('set.language');

    Route::get('/currency-switcher', [HomeController::class,'currency_switcher'])->name('currency-switcher');

    Route::post('/save-address', [HomeController::class,'save_address'])->name('save-address');


    // User Login Routes.....
    Route::group(['middleware'=>'guest'],function () {
        Route::get('/user/login', [UserLoginController::class,'index'])->name('login');
        Route::post('/user/login', [UserLoginController::class,'login'])->name('user.login');

        Route::get('register', [UserRegisterController::class, 'register_view'])->name('register');
        Route::post('register', [UserRegisterController::class, 'store'])->name('user.register');


        Route::get('login/google', [UserLoginController::class, 'redirect_to_google'])->name('login-google');
        Route::get('/callback/google', [UserLoginController::class, 'google_callback'])->name('callback-google');

        Route::get('login/facebook', [UserLoginController::class, 'redirect_to_facebook'])->name('login-facebook');
        Route::get('/callback/facebook', [UserLoginController::class, 'facebook_callback'])->name('callback-facebook');



    });

    Route::get('/user-verification', [UserRegisterController::class, 'custom_user_verification'])->name('user-verification');

    Route::post('/forget-password', [UserPasswordController::class, 'custom_forgot_password'])->name('forgot-password');
    Route::get('/reset-password', [UserPasswordController::class, 'reset_password_page'])->name('reset-password-page');
    Route::post('/reset-password-store/{token}', [UserPasswordController::class, 'custom_reset_password_store'])->name('reset-password-store');

    // User Page Routes.....
    Route::group(['middleware' => 'auth', 'prefix' => 'user'], function () {
        Route::post('/logout', [UserLoginController::class, 'log_out'])->name('user.logout');

        Route::get('/dashboard', [UserDashboardController::class, 'user_dashboard'])->name('user.dashboard');

        Route::get('/edit-profile', [UserProfileController::class, 'edit_profile'])->name('user.edit-profile');
        Route::put('/update-profile', [UserProfileController::class, 'update_profile'])->name('user.update-profile');
        Route::get('/address', [UserAddressController::class, 'view_address'])->name('user.address');

        Route::post('/address-update', [UserAddressController::class, 'store_address'])->name('user.address-store');

        Route::get('/address-edit/{id}', [UserAddressController::class, 'edit_address'])->name('user.address-edit');
        Route::put('/address-update/{id}', [UserAddressController::class, 'update_address'])->name('user.address-update');

        Route::delete('address-delete/{id}', [UserAddressController::class, 'delete_address'])->name('user.address-delete');
        Route::delete('address-checkout-delete/{id}', [UserAddressController::class, 'delete_address_checkout'])->name('user.checkout-address-delete');

        Route::get('/orders', [UserOrderController::class, 'order'])->name('user.order');
        Route::get('/order-details/{id}', [UserOrderController::class, 'order_details'])->name('user.order-details');

        Route::post('/food-review/{food_id}', [UserOrderController::class, 'review_submit'])->name('user.review-submit');

        Route::get('/review', [UserDashboardController::class, 'review'])->name('user.review');

        Route::get('/change-password', [UserProfileController::class, 'change_password'])->name('user.change-password');
        Route::put('/password/update', [UserProfileController::class, 'update_password'])->name('user.update-password');

        Route::get('/wishlist',  [WishlistController::class, 'wishlists'])->name('user.wishlist');
        Route::get('/remove-wishlist/{id}',  [WishlistController::class, 'remove_wishlist'])->name('user.remove-wishlist');

    });

    Route::get('user/add-to-wishlist/{id}',  [WishlistController::class, 'add_to_wishlist'])->name('user.add-to-wishlist');

    Route::get('user/restaurant/toggle-wishlist/{id}',  [RestaurantWishlistController::class, 'toggle_wishlist'])->name('user.restaurant.toggle-wishlist');

    Route::get('/view-all-carts', [CartController::class,'view_all_carts'])->name('view.all.carts');
    Route::post('/cart/add', [CartController::class,'add_product'])->name('cart.add.product');
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::get('/cart/remove/{product_id}', [CartController::class,'remove_product'])->name('cart.remove');
    Route::get('/cart/manual/remove/{product_id}', [CartController::class,'remove_manual_product'])->name('cart.manual.remove');
    Route::get('/cart/increment/{product_id}', [CartController::class,'cart_increment'])->name('cart.increment');
    Route::get('/cart/decrement/{product_id}', [CartController::class,'cart_decrement'])->name('cart.decrement');
    Route::post('/cart/update/{product_id}', [CartController::class,'cart_update'])->name('update.cart');

    Route::post('/apply-coupon', [CartController::class, 'apply_coupon'])->name('apply.coupon');
    Route::delete('/remove-coupon', [CartController::class, 'remove_coupon'])->name('remove.coupon');


    Route::get('/checkout', [CheckoutController::class,'checkout_page'])->name('view.checkout');
    Route::post('/continue/order', [UserOrderController::class,'continue_order'])->name('continue.order');
    Route::get('/payment', [CheckoutController::class,'payment_page'])->name('view.payment');


    //...........................Stripe....................//

    Route::post('/pay-with-stripe', [PaymentController::class,'pay_with_stripe'])->name('pay-with-stripe');
    Route::post('/bank/{amount}', [PaymentController::class, 'bank_payment'])->name('bank');
    Route::get('/paypal/{amount}', [PaymentController::class, 'paypal_payment'])->name('paypal');
    Route::get('/paypal-success-payment', [PaymentController::class, 'paypal_success_payment'])->name('paypal-success-payment');
    Route::get('/paypal-faild-payment', [PaymentController::class, 'paypal_faild_payment'])->name('paypal-faild-payment');

    Route::post('/razorpay/{amount}', [PaymentController::class, 'razorpay_payment'])->name('razorpay');

    Route::post('/flutterwave/{amount}', [PaymentController::class, 'flutterwave_payment'])->name('flutterwave');
    Route::match(['get', 'post'], '/flutterwave-success', [PaymentController::class, 'flutterwave_payment_success'])->name('flutterwave-success');

    Route::post('/paystack/{amount}', [PaymentController::class, 'paystack_payment'])->name('paystack');
    Route::match(['get', 'post'], '/paystack-success', [PaymentController::class, 'paystack_paymen_successt'])->name('paystack-success');

    Route::post('/mollie', [PaymentController::class, 'mollie_payment'])->name('mollie');
    Route::get('/mollie-callback', [PaymentController::class, 'mollie_callback'])->name('mollie-callback');


    Route::get('/pay-via-instamojo', [PaymentController::class, 'pay_via_instamojo'])->name('pay-via-instamojo');
    Route::get('/response-instamojo', [PaymentController::class, 'instamojo_response'])->name('response-instamojo');

    Route::group(['as'=> 'restaurant.', 'prefix' => 'restaurant'],function (){

        Route::get('login', [RestaurantLoginController::class, 'restaurant_login_page'])->name('login');
        Route::post('store-login', [RestaurantLoginController::class, 'restaurant_login'])->name('store-login');
        Route::post('logout', [RestaurantLoginController::class, 'restaurant_logout'])->name('logout');

        Route::group(['middleware' => ['restaurant']], function () {

        Route::get('/', [RestaurantDashboardController::class, 'dashboard']);
        Route::get('dashboard', [RestaurantDashboardController::class, 'dashboard'])->name('dashboard');

        Route::controller(RestaurantProfileController::class)->group(function(){
            Route::get('edit-profile', 'edit_profile')->name('edit-profile');
            Route::get('change-password', 'change_password')->name('change-password');
            Route::put('profile-update', 'profile_update')->name('profile-update');
            Route::put('update-password', 'update_password')->name('update-password');
        });

        });

    });




});





Route::group(['as'=> 'admin.', 'prefix' => 'admin'],function (){

    Route::get('login', [LoginController::class, 'custom_login_page'])->name('login');
    Route::post('store-login', [LoginController::class, 'store_login'])->name('store-login');
    Route::post('store-register', [LoginController::class, 'store_register'])->name('store-register');
    Route::post('logout', [LoginController::class, 'admin_logout'])->name('logout');


    Route::group(['middleware' => ['admin']], function () {

        Route::get('/', [DashboardController::class, 'dashboard']);
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::controller(ProfileController::class)->group(function(){
            Route::get('edit-profile', 'edit_profile')->name('edit-profile');
            Route::put('profile-update', 'profile_update')->name('profile-update');
            Route::put('update-password', 'update_password')->name('update-password');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('user-list', 'user_list')->name('user-list');
            Route::get('pending-user', 'pending_user')->name('pending-user');
            Route::get('user-show/{id}', 'user_show')->name('user-show');
            Route::delete('user-delete/{id}', 'user_destroy')->name('user-delete');
            Route::put('user-status/{id}', 'user_status')->name('user-status');
            Route::put('user-update/{id}', 'update')->name('user-update');
        });

        Route::controller(BannerController::class)->group(function () {
            Route::get('banner', 'index')->name('banner');
            Route::get('banner-create', 'create')->name('banner.create');
            Route::post('banner-store', 'store')->name('banner.store');
            Route::Post('banner-update/{id}', 'update')->name('banner.update');
            Route::get('banner-edit/{id}', 'edit')->name('banner.edit');
            Route::delete('banner-delete/{id}', 'delete')->name('banner-delete');

            Route::get('promotional-banner-edit', 'promotional_banner_edit')->name('promotional.banner.edit');
            Route::Post('promotional-banner-update', 'promotional_banner_update')->name('promotional.banner.update');

        });

        Route::get('offer', [OfferController::class, 'index'])->name('offer');
        Route::put('update-offer', [OfferController::class, 'update'])->name('update-offer');
        Route::get('offer-product', [OfferController::class, 'offer_product'])->name('offer-product');
        Route::post('store-offer-product', [OfferController::class, 'store'])->name('store-offer-product');
        Route::post('offer-product-status/{id}', [OfferController::class, 'changeStatus'])->name('offer-product-status');
        Route::delete('delete-offer-product/{id}', [OfferController::class,'destroy'])->name('delete-offer-product');

    });
    Route::get('deliveryman-index', [DeliveryManController::class, 'deliveryman_index'])->name('deliveryman-index');
    Route::get('deliveryman-show/{id}', [DeliveryManController::class, 'deliveryman_show'])->name('deliveryman-show');
    Route::get('order-show/{id}',[DeliveryManController::class,'order_show'])->name('order-show');
    Route::get('deliveryman-pending',[DeliveryManController::class,'deliveryman_pending'])->name('deliveryman-pending');
    Route::delete('deliveryman-delete/{id}',[DeliveryManController::class,'deliveryman_delete'])->name('deliveryman-delete');

    // Document Type Routes
    Route::resource('document-type', App\Http\Controllers\Admin\DocumentTypeController::class);

    // Vehicle Type Routes
    Route::resource('vehicle-type', App\Http\Controllers\Admin\VehicleTypeController::class);

    Route::get('deliveryman-create', [DeliveryManController::class, 'create'])->name('deliveryman-create');
    Route::post('deliveryman-store', [DeliveryManController::class, 'deliveryman_store'])->name('deliveryman-store');
    Route::get('deliveryman-show', [DeliveryManController::class, 'deliveryman_show'])->name('ddeliveryman-show');
    Route::get('deliveryman-edit/{id}', [DeliveryManController::class, 'deliveryman_edit'])->name('deliveryman-edit');
    Route::put('deliveryman-update/{id}', [DeliveryManController::class, 'deliveryman_update'])->name('deliveryman-update');
    Route::delete('deliveryman-delete/{id}', [DeliveryManController::class, 'deliveryman_delete'])->name('deliveryman-delete');
});


//delivery man routes
Route::get('deliveryman/login', [DeliveryManLoginController::class,'LoginPage'])->name('deliveryman.login');
Route::post('deliveryman/login', [DeliveryManLoginController::class,'dashboardLogin'])->name('deliveryman.login');
Route::get('deliveryman/logout',[DeliveryManLoginController::class,'logout'])->name('deliveryman.logout');


Route::group(['as'=> 'deliveryman.', 'prefix' => 'deliveryman', 'middleware'=>'deliveryman'],function (){
    Route::get('dashboard',[DeliveryManDashboardController::class,'index'])->name('dashboard');
    Route::get('my-profile',[DeliveryManProfileController::class,'index'])->name('my-profile');
    Route::get('edit-profile',[DeliveryManProfileController::class,'edit'])->name('edit-profile');
    Route::put('update-profile',[DeliveryManProfileController::class,'update'])->name('update-profile');
    Route::get('edit-password',[DeliveryManProfileController::class,'password'])->name('edit-password');
    Route::put('update-password',[DeliveryManProfileController::class,'updatePassword'])->name('update-password');
    Route::post('update-lat-long', [DeliveryManProfileController::class,'updateLocation'])->name('update.lat-long');
    Route::get('orders',[DeliveryManOrderController::class,'index'])->name('orders');

    Route::get('order-request',[DeliveryManOrderController::class,'orderRequest'])->name('order-request');
    Route::post('order-request-status/{id}',[DeliveryManOrderController::class,'orderRequestStatus'])->name('order-request-status');

    Route::get('completed-order',[DeliveryManOrderController::class,'completedOrder'])->name('completed-order');
    Route::get('cancel-order',[DeliveryManOrderController::class,'canceledOrder'])->name('cancel-order');
    Route::get('order-show/{id}',[DeliveryManOrderController::class,'show'])->name('order-show');
    Route::put('update-order-status/{id}',[DeliveryManOrderController::class,'updateOrderStatus'])->name('update-order-status');

    Route::resource('my-withdraw', DeliverymanWithdrawController::class);

    Route::resource('withdraw-list', PaymentWithdrawController::class);
    Route::post('withdraw-approval/{id}', [PaymentWithdrawController::class, 'withdraw_approval'])->name('withdraw-approval');
    Route::post('withdraw-rejected/{id}', [PaymentWithdrawController::class, 'withdraw_rejected'])->name('withdraw-rejected');

    Route::resource('withdraw-methods', WithdrawMethodController::class);

    Route::get('logout',[DeliveryManLoginController::class,'logout'])->name('logout');

    Route::get('deliveryman-edit/{id}', [DeliveryManProfileController::class, 'deliveryman_edit'])->name('deliveryman-edit');
    Route::put('deliveryman-update/{id}', [DeliveryManProfileController::class, 'deliveryman_update'])->name('deliveryman-update');

});


Route::get('/migrate-for-update', function () {

    Artisan::call('migrate');

    // Run the specific seeder
    Artisan::call('db:seed', [
        '--class' => 'Modules\\GlobalSetting\\Database\\Seeders\\PwaIconSettingSeeder',
        '--force' => true, // optional: forces the seed without confirmation
    ]);

    $general_setting = GlobalSetting::where('key','app_version')->first();
    $general_setting->value = '2.0.0';
    $general_setting->save();


    $notification = "Version updated successfully";
    $notification = array('messege' => $notification, 'alert-type' => 'success');
    return redirect()->route('home')->with($notification);
});


Route::get('/migrate', function(){

    Artisan::call('migrate');

    Artisan::call('optimize:clear');

    GlobalSetting::updateOrCreate(['key' => 'splash_screens'], ['value' => '']);

    $notification = trans('translate.Version updated successful');
    $notification = array('message' => $notification, 'alert-type' => 'success');
    return redirect()->route('home')->with($notification);
});
