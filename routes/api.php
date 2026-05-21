<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Frontend API Controllers
use App\Http\Controllers\Api\Frontend\HomeController;
use App\Http\Controllers\Api\Frontend\CartController;
use App\Http\Controllers\Api\Frontend\UserDashboardController;
use App\Http\Controllers\Api\Frontend\Auth\AuthController;
use App\Http\Controllers\Api\Frontend\WishlistController;
use App\Http\Controllers\Api\Frontend\CheckoutController;
use App\Http\Controllers\Api\PaymentController;

// Restaurant API Controllers
use App\Http\Controllers\Api\Restaurant\RestaurantDashboardController;
use App\Http\Controllers\Api\Restaurant\RestaurantProfileController;
use App\Http\Controllers\Api\Restaurant\Auth\RestaurantLoginController;

// DeliveryMan API Controllers
use App\Http\Controllers\Api\Deliveryman\DeliveryManDashboardController;
use App\Http\Controllers\Api\Deliveryman\Auth\DeliveryManLoginController;
use App\Http\Controllers\Api\Deliveryman\DeliveryManOrderController;
use App\Http\Controllers\Api\Deliveryman\DeliveryManProfileController;
use App\Http\Controllers\Api\Deliveryman\DeliverymanWithdrawController;
use App\Http\Controllers\Api\Restaurant\RestaurantAddonController;
use App\Http\Controllers\Api\Restaurant\RestaurantCategoryController;
use App\Http\Controllers\Api\Restaurant\RestaurantOrderController;
use App\Http\Controllers\Api\Restaurant\RestaurantProductController;
use App\Http\Controllers\Api\Restaurant\RestaurantWithdrawController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes (no authentication required)
Route::group(['prefix' => 'v1'], function () {

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login'])->name('user.login');
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::post('/reset-otp-match', [AuthController::class, 'reset_otp_match'])->name('reset-otp-match');
        Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
        Route::post('/resend-verification', [AuthController::class, 'resendVerificationEmail']);
    });

    // Public home/general routes
    Route::group(['prefix' => 'home'], function () {
        Route::get('/', [HomeController::class, 'getHomepageData']);
        Route::get('/categories', [HomeController::class, 'getCategories']);
        Route::get('/about', [HomeController::class, 'getAbout']);
        Route::get('/privacy-policy', [HomeController::class, 'getPrivacyPolicy']);
        Route::get('/terms-conditions', [HomeController::class, 'getTermsAndConditions']);
        Route::get('/offers', [HomeController::class, 'getOfferDeals']);
        Route::get('/contact', [HomeController::class, 'getContactInfo']);
        Route::get('/blogs', [HomeController::class, 'getBlogs']);
        Route::get('/blogs/{slug}', [HomeController::class, 'getBlogDetails']);
        Route::post('/blogs/{id}/comment', [HomeController::class, 'submitBlogComment']);
        Route::get('/cuisines', [HomeController::class, 'getAllCuisines']);
        Route::get('/search', [HomeController::class, 'search']);
        Route::get('/splash-screen', [HomeController::class, 'websiteSetup']);
    });

    // Restaurants
    Route::group(['prefix' => 'restaurants'], function () {
        Route::get('/', [HomeController::class, 'getAllRestaurants']);
        Route::get('/{slug}', [HomeController::class, 'getSingleRestaurant']);
    });

    // Products
    Route::group(['prefix' => 'products'], function () {
        Route::get('/{id}', [HomeController::class, 'getSingleProduct']);
    });

    // Language and Currency (with session support)
    Route::group(['middleware' => ['web']], function () {
        Route::post('/set-language/{lang_code}', [HomeController::class, 'setLanguage']);
        Route::post('/set-currency', [HomeController::class, 'currencySwitcher']);
        Route::post('/save-address', [HomeController::class, 'saveAddress']);
    });
});

// Protected routes (authentication required)
Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    // User authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    });

    // User Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [UserDashboardController::class, 'getDashboard']);

        // Orders
        Route::get('/orders', [UserDashboardController::class, 'getOrders']);
        Route::get('/orders/{id}', [UserDashboardController::class, 'getOrderDetails']);
        Route::post('/orders/{id}/cancel', [UserDashboardController::class, 'cancelOrder']);
        Route::get('/orders/{id}/track', [UserDashboardController::class, 'trackOrder']);

        // Reviews
        Route::get('/reviews', [UserDashboardController::class, 'getReviews']);
        Route::post('/reviews', [UserDashboardController::class, 'submitReview']);

        // Addresses
        Route::get('/addresses', [UserDashboardController::class, 'getAddresses']);
        Route::post('/addresses', [UserDashboardController::class, 'addAddress']);
        Route::put('/addresses/{id}', [UserDashboardController::class, 'updateAddress']);
        Route::delete('/addresses/{id}', [UserDashboardController::class, 'deleteAddress']);
    });

    // User Wishlist Routes
    Route::group(['prefix' => 'wishlist'], function () {
        Route::get('/',  [WishlistController::class, 'wishlists']);
        Route::delete('remove/{id}',  [WishlistController::class, 'remove_wishlist']);
        Route::post('add',  [WishlistController::class, 'add_to_wishlist']);
    });

    // Cart Management
    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', [CartController::class, 'getCartItems']);
        Route::post('/add', [CartController::class, 'addProduct'])->name('cart.add.product');
        Route::delete('/remove/{product_id}', [CartController::class, 'removeProduct'])->name('cart.remove.product');
        Route::post('/increment/{product_id}', [CartController::class, 'incrementCartItem']);
        Route::post('/decrement/{product_id}', [CartController::class, 'decrementCartItem']);
        Route::put('/update/{product_id}', [CartController::class, 'updateCartItem'])->name('update.cart');
        Route::delete('/clear', [CartController::class, 'clearCart']);

        // Coupon management
        Route::post('/coupon/apply', [CartController::class, 'applyCoupon']);
        Route::delete('/coupon/remove', [CartController::class, 'removeCoupon']);
    });

    // Checkout Management
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/info', [CheckoutController::class, 'getCheckoutInfo']);
        Route::get('/payment-methods', [CheckoutController::class, 'getPaymentMethods']);
        Route::post('/validate', [CheckoutController::class, 'validateCheckout']);
    });

    // Payment Processing
    Route::group(['prefix' => 'payment'], function () {
        Route::get('/stripe', [PaymentController::class, 'api_stirpe_payment']);
        Route::post('/bank', [PaymentController::class, 'api_bank_payment']);
        Route::post('/razorpay', [PaymentController::class, 'razorpay_webview']);
    });
});

// ===============================
// RESTAURANT API ROUTES
// ===============================

// Public Restaurant Routes
Route::group(['prefix' => 'v1/restaurant'], function () {
    // Restaurant Authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [RestaurantLoginController::class, 'login'])->name('restaurant.login');
    });
});

// Protected Restaurant Routes
Route::group(['prefix' => 'v1/restaurant', 'middleware' => 'auth:sanctum'], function () {
    // Restaurant Authentication (Protected)
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/refresh-token', [RestaurantLoginController::class, 'refreshToken']);
        Route::post('/logout', [RestaurantLoginController::class, 'logout'])->name('restaurant.logout');
    });

    // Restaurant Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [RestaurantDashboardController::class, 'dashboard']);
        Route::get('/statistics/orders', [RestaurantDashboardController::class, 'orderStatistics']);
        Route::get('/financial-summary', [RestaurantDashboardController::class, 'financialSummary']);
    });

    // Manage Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/edit', [RestaurantProfileController::class, 'edit']);
        Route::post('/update', [RestaurantProfileController::class, 'update']);
        Route::put('/change-password', [RestaurantProfileController::class, 'updatePassword']);
    });

    // Order Management
    Route::group(['prefix' => 'order'], function () {
        Route::get('/order-list', [RestaurantOrderController::class, 'allOrder']);
        Route::get('/detail/{id}', [RestaurantOrderController::class, 'orderDetail']);
        Route::post('/status/change/{id}', [RestaurantOrderController::class, 'orderStatusChange']);
    });

    // Product Management
    Route::group(['prefix' => 'product'], function () {
        Route::get('/product-list', [RestaurantProductController::class, 'productList']);
        Route::get('/create', [RestaurantProductController::class, 'create']);
        Route::get('/edit/{id}', [RestaurantProductController::class, 'edit']);
        Route::post('/store', [RestaurantProductController::class, 'store']);
        Route::post('/update/{id}', [RestaurantProductController::class, 'update']);
        Route::get('/delete/{id}', [RestaurantProductController::class, 'delete']);
    });

    // Category Management
    Route::group(['prefix' => 'category'], function () {
        Route::get('/category-list', [RestaurantCategoryController::class, 'categoryList']);
    });

    // Addon Management
    Route::group(['prefix' => 'addon'], function () {
        Route::get('/addon-list', [RestaurantAddonController::class, 'addonList']);
        Route::get('/edit/{id}', [RestaurantAddonController::class, 'edit']);
        Route::post('/store', [RestaurantAddonController::class, 'store']);
        Route::post('/update/{id}', [RestaurantAddonController::class, 'update']);
        Route::get('/delete/{id}', [RestaurantAddonController::class, 'delete']);
    });

    // Earning Management
    Route::group(['prefix' => 'withdraw'], function () {
        Route::get('/my-withdraw', [RestaurantWithdrawController::class, 'withdrawHistory']);
        Route::get('/create', [RestaurantWithdrawController::class, 'create']);
        Route::post('/store', [RestaurantWithdrawController::class, 'store']);
    });
});

// ===============================
// DELIVERY MAN API ROUTES
// ===============================

// Public DeliveryMan Routes
Route::group(['prefix' => 'v1/deliveryman'], function () {

    // Resource APIs (Public - for registration)
    Route::get('/cities', [App\Http\Controllers\Api\DeliveryManResourceController::class, 'getCities']);
    Route::get('/document-types', [App\Http\Controllers\Api\DeliveryManResourceController::class, 'getDocumentTypes']);
    Route::get('/vehicle-types', [App\Http\Controllers\Api\DeliveryManResourceController::class, 'getVehicleTypes']);
    Route::get('/splash-screen', [App\Http\Controllers\Api\DeliveryManResourceController::class, 'getSplashScreen']);
    Route::get('/register-data', [App\Http\Controllers\Api\DeliveryManResourceController::class, 'registerData']);


    // DeliveryMan Authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [DeliveryManLoginController::class, 'login'])->name('deliveryman.login');

        // Registration Flow (3 Steps)
        Route::post('/register/step-one', [DeliveryManLoginController::class, 'registerStepOne']);
        Route::post('/register/step-two', [DeliveryManLoginController::class, 'registerStepTwo']);
        Route::post('/register/step-three', [DeliveryManLoginController::class, 'registerStepThree']);

        // OTP Verification Flow
        Route::post('/verify-otp', [DeliveryManLoginController::class, 'verifyOtp']);
        Route::post('/resend-otp', [DeliveryManLoginController::class, 'resendOtp']);

        // Set Password (after OTP verification)
        Route::post('/set-password', [DeliveryManLoginController::class, 'setPassword']);

        // Forgot Password Flow
        Route::post('/forgot-password', [DeliveryManLoginController::class, 'forgotPassword']);
        Route::post('/verify-reset-otp', [DeliveryManLoginController::class, 'verifyResetOtp']);
        Route::post('/reset-password', [DeliveryManLoginController::class, 'resetPassword']);
    });
});

// Protected DeliveryMan Routes
Route::group(['prefix' => 'v1/deliveryman', 'middleware' => 'auth:sanctum'], function () {
    // DeliveryMan Authentication (Protected)
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/profile', [DeliveryManLoginController::class, 'profile']);
        Route::post('/change-password', [DeliveryManLoginController::class, 'changePassword']);
        Route::post('/refresh', [DeliveryManLoginController::class, 'refresh']);
        Route::post('/logout', [DeliveryManLoginController::class, 'logout'])->name('deliveryman.logout');
    });

    // DeliveryMan Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DeliveryManDashboardController::class, 'dashboard']);
    });

    // Manage Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/edit', [DeliveryManProfileController::class, 'edit']);
        Route::post('/update', [DeliveryManProfileController::class, 'update']);
        Route::put('/change-password', [DeliveryManProfileController::class, 'updatePassword']);
    });

    // Order Management
    Route::group(['prefix' => 'order'], function () {
        Route::get('/order-request', [DeliveryManOrderController::class, 'orderRequest']);
        Route::get('/running-orders', [DeliveryManOrderController::class, 'runningOrders']);
        Route::get('/completed-orders', [DeliveryManOrderController::class, 'completedOrders']);
        Route::get('/cancel-orders', [DeliveryManOrderController::class, 'cancelOrders']);
        Route::get('/detail/{id}', [DeliveryManOrderController::class, 'orderDetail']);
        Route::post('/request/status/update/{id}', [DeliveryManOrderController::class, 'updateOrderRequestStatus']);
    });

    // Earning Management
    Route::group(['prefix' => 'withdraw'], function () {
        Route::get('/my-withdraw', [DeliverymanWithdrawController::class, 'withdrawHistory']);
        Route::get('/create', [DeliverymanWithdrawController::class, 'create']);
        Route::post('/store', [DeliverymanWithdrawController::class, 'store']);
    });
});
