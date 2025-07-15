<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Socialite\ProviderCallbackController;
use App\Http\Controllers\Socialite\ProviderRedirectController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Middleware\RoleMiddleware;

/* --------------------
     GUEST ROUTES
-------------------- */
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('landingPage');
    })->name('landingPage')->middleware('guest');

    Route::get('/about-us', function () {
        return view('aboutUs');
    });

    Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
    Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

    Route::get('/register/{role}', [RegisteredUserController::class, 'create'])->name('register')->middleware('guest');
    Route::post('/register/{role}', [RegisteredUserController::class, 'store'])->middleware('guest');

    Route::get('/auth/{provider}/redirect/{role?}', ProviderRedirectController::class)->name('auth.redirect')->middleware('guest');
    Route::get('/auth/{provider}/callback/', ProviderCallbackController::class)->name('auth.callback')->middleware('guest');

    Route::fallback(function () {
        return redirect()->route('landingPage');
    });
});


/* --------------------
 NORMAL USERS ROUTES
---------------------*/

Route::middleware(['auth'])->group(function () {
    Route::post('/manage-profile', [SessionController::class, 'destroy'])->name('logout');
});
/* ---------------------
    CUSTOMER ROUTES
---------------------- */
// Customer Account Setup

Route::middleware(['role:customer'])->group(function () {
    Route::get('/customer-first-page', function () {
        return view('customer.customerFirstPage');
    });

    // Customer Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/topup', [UserController::class, 'topUpWellPay'])->name('wellpay.topup');

    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

    // Favorite
    Route::post('favorite/{vendorId}', [FavoriteController::class, 'favorite'])->name('favorite');
    Route::post('unfavorite/{vendorId}', [FavoriteController::class, 'unfavorite'])->name('unfavorite');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.show')->middleware('auth');

    Route::get('/manage-profile', function () {
        return view('manageProfile');
    })->name('manage-profile');

    // Search Caterings
    Route::get('/caterings', [VendorController::class, 'search'])->name('search');

    // Catering Details
    Route::get('/catering-detail/{vendor}', [VendorController::class, 'show'])->name('catering-detail');
    Route::post('/update-order-summary', [CartController::class, 'updateOrderSummary'])->name('update.order.summary');
    Route::get('/load-cart', [CartController::class, 'loadCart'])->name('load.cart');

    Route::get('/catering-detail/rating-and-review', function () {
        return view('ratingAndReview');
    })->name('rate-and-review');

    // Order History
    Route::get('/orders', [OrderController::class, 'index'])->name('order-history');

    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order-detail');
    // Route::get('/order-detail', [OrderController::class, 'show'])->name('order-detail');

    // Order Payment
    Route::get('/payment', function () {
        return view('payment');
    });
    // Route::get('/payment', function () {
    //     return view('payment');
    // });

    // Route::get('/vendor/{vendor}/payment', [OrderController::class, 'showPaymentPage'])->name('payment.show');
    // Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/vendor/{vendor}/payment', [OrderController::class, 'showPaymentPage'])->name('payment.show');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/user/wellpay-balance', [OrderController::class, 'getUserWellpayBalance'])->name('user.wellpay.balance');

    // Manage Address
    Route::get('/manage-address', function () {
        return view('ManageAddress');
    });

    Route::get('/add-address', function () {
        return view('addAddress');
    });

    Route::fallback(function () {
        return redirect()->route('home');
    });

});

/* ---------------------
     VENDOR ROUTES
---------------------- */
Route::middleware(['role:vendor'])->group(function () {
    // Catering dashboard
    Route::get('/cateringHomePage', function () {
        return view('cateringHomePage');
    });
    Route::post('/cateringHomePage', [SessionController::class, 'destroy'])->name('logout.vendor');

    // Manage Packages
    Route::get('/manageCateringPackage', [PackageController::class, 'index'])->name('manageCateringPackage');
    Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');
    // Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::post('/manageCateringPackage', [PackageController::class, 'store'])->name('packages.store');
    Route::put('/manageCateringPackage/{package}', [PackageController::class, 'update'])->name('packages.update');

    // Manage Order
    Route::get('/manageOrder', function () {
        return view('manageOrder');
    });

    Route::fallback(function () {
        return redirect()->route('cateringHomePage');
    });
});
/* ---------------------
     ADMIN ROUTES
---------------------- */
Route::middleware(['role:admin'])->group(function () {
    Route::get('/view-all-vendors', [AdminController::class, 'viewAllVendors'])->name('view-all-vendors');
    Route::post('/view-all-vendors', [AdminController::class, 'search'])->name('view-all-vendors');

    Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

    Route::get('/view-all-orders', function () {
        return view('view-all-orders');
    });

    Route::get('/view-all-users', function () {
        return view('view-all-users');
    });

    Route::get('/view-all-logs', [AdminController::class, 'view_all_logs'])
        ->name('view-all-logs');

    Route::get('/view-all-packages-category', function () {
        return view('view-all-packages-category');
    });

    Route::get('/view-all-packages-cuisine', function () {
        return view('view-all-packages-cuisine');
    });

    Route::get('/view-all-payment', [AdminController::class, 'view_all_payment'])
        ->name('view-all-payment');

    Route::delete('/view-all-payment/delete/{id}', [AdminController::class, 'delete_payment'])
        ->name('delete-payment');

    Route::post('/view-all-payment', [AdminController::class, 'add_new_payment'])
        ->name('add-new-payment');

    Route::post('/view-all-vendors', [SessionController::class, 'destroy'])->name('logout.admin');

    Route::get('/view-order-history', [AdminController::class, 'view_order_history'])
    ->name('view-order-history')
    ->middleware(['auth', RoleMiddleware::class]);

    Route::fallback(function () {
        return redirect()->route('admin-dashboard');
    });

});
