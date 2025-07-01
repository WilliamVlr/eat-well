<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CateringHomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;

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
});

Route::get('/about-us', function(){
    return view('aboutUs');
});

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
/* ---------------------
     CUSTOMER ROUTES
---------------------- */
// Customer Account Setup
Route::get('/customer-first-page', function(){
    return view('customer.customerFirstPage');
});

// Customer Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/manage-profile', function () {
    return view('manageProfile');
})->name('manage-profile');

// Caterings
Route::get('/caterings', [VendorController::class, 'search'])->name('search');
Route::get('/catering/{vendor}', [VendorController::class, 'show'])->name('catering-detail');

// Favorite
Route::post('favorite/{vendorId}', [FavoriteController::class, 'favorite'])->name('favorite');
Route::post('unfavorite/{vendorId}', [FavoriteController::class, 'unfavorite'])->name('unfavorite');

// Catering Details
// Route::get('/catering-detail', function () {
//     return view('cateringDetail');
// })->name('catering-detail');


Route::post('/update-order-summary', [VendorController::class, 'updateOrderSummary']);

Route::get('/catering-detail/rating-and-review', function(){
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

// Manage Address
Route::get('/manage-address', function(){
    return view('ManageAddress');
});

Route::get('/add-address', function(){
    return view('addAddress');
});

/* ---------------------
     VENDOR ROUTES
---------------------- */
// Catering dashboard
Route::get('/cateringHomePage', [CateringHomeController::class, 'index'])->name('cateringHomePage');
Route::get('/cateringHomePage/sales', [CateringHomeController::class,'laporan'])->name('sales.show');
Route::get('/cateringHomePage/sales/export', [CateringHomeController::class,'export_excel'])->name('sales.export');

// Manage Packages
Route::get('/manageCateringPackage', [PackageController::class, 'index'])->name('manageCateringPackage');
Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');
// Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
Route::post('/manageCateringPackage', [PackageController::class, 'store'])->name('packages.store');
Route::put('/manageCateringPackage/{package}', [PackageController::class, 'update'])->name('packages.update');

// Manage Order
Route::get('/manageOrder', function(){
    return view('manageOrder');
});

/* ---------------------
     ADMIN ROUTES
---------------------- */
