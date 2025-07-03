<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Socialite\ProviderCallbackController;
use App\Http\Controllers\Socialite\ProviderRedirectController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return view('test');
// });

/* --------------------
     GUEST ROUTES
-------------------- */

Route::get('/', function () {
    return view('landingPage');
})->middleware('guest');

Route::get('/about-us', function () {
    return view('aboutUs');
});

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

Route::get('/register/{role}', [RegisteredUserController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register/{role}', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::get('/auth/{provider}/redirect/{role?}', ProviderRedirectController::class)->name('auth.redirect')->middleware('guest');
Route::get('/auth/{provider}/callback/', ProviderCallbackController::class)->name('auth.callback')->middleware('guest');

Route::post('/home', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');


/* ---------------------
     CUSTOMER ROUTES
---------------------- */
// Customer Account Setup
Route::get('/customer-first-page', function () {
    return view('customer.customerFirstPage');
})->middleware('auth');

// Customer Home
Route::get('/home', function () {
    return view('customer.home');
})->name('home')->middleware('auth');

Route::get('/manage-profile', function () {
    return view('manageProfile');
})->name('manage-profile')->middleware('auth');

// Search
Route::get('/search', [VendorController::class, 'search'])->name('search');

Route::get('/catering-detail/{vendor}', [VendorController::class, 'show'])->name('catering-detail')->middleware('auth');
Route::post('/update-order-summary', [VendorController::class, 'updateOrderSummary'])->middleware('auth');

// Catering Details
Route::get('/catering-detail/{vendor}', [VendorController::class, 'show'])->name('catering-detail');
Route::post('/update-order-summary', [CartController::class, 'updateOrderSummary'])->name('update.order.summary');
Route::get('/load-cart', [CartController::class, 'loadCart'])->name('load.cart');

// For authenticated users
// Route::middleware(['auth'])->group(function () {
//     Route::get('/catering-detail/{vendor}', [VendorController::class, 'show'])->name('catering-detail');
//     Route::post('/update-order-summary', [CartController::class, 'updateOrderSummary'])->name('update.order.summary');
//     Route::get('/load-cart', [CartController::class, 'loadCart'])->name('load.cart');
// });

Route::get('/catering-detail/rating-and-review', function () {
    return view('ratingAndReview');
})->name('rate-and-review')->middleware('auth');

// Order History
Route::get('/orders', [OrderController::class, 'index'])->name('order-history');

Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order-detail');
// Route::get('/order-detail', [OrderController::class, 'show'])->name('order-detail');

// Order Payment
Route::get('/payment', function () {
    return view('payment');
})->middleware('auth');
// Route::get('/payment', function () {
//     return view('payment');
// });

// Mengaksesnya dari vendor tertentu, misal /payment/vendor/1
Route::get('/vendor/{vendor}/payment', [OrderController::class, 'showPaymentPage'])->name('payment.show');

// Manage Address
Route::get('/manage-address', function () {
    return view('ManageAddress');
})->middleware('auth');

Route::get('/add-address', function () {
    return view('addAddress');
})->middleware('auth');

/* ---------------------
     VENDOR ROUTES
---------------------- */
// Catering dashboard
Route::get('/cateringHomePage', function () {
    return view('cateringHomePage');
})->middleware('auth');

// Manage Packages
Route::get('/manageCateringPackage', [PackageController::class, 'index'])->name('manageCateringPackage')->middleware('auth');
Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy')->middleware('auth');
// Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
Route::post('/manageCateringPackage', [PackageController::class, 'store'])->name('packages.store')->middleware('auth');
Route::put('/manageCateringPackage/{package}', [PackageController::class, 'update'])->name('packages.update')->middleware('auth');

// Manage Order
Route::get('/manageOrder', function () {
    return view('manageOrder');
})->middleware('auth');

/* ---------------------
     ADMIN ROUTES
---------------------- */
