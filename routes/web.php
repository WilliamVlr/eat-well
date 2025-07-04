<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\VendorController;
use App\Models\Order;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\DeliveryStatusController;
use App\Http\Controllers\OrderVendorController;
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
Route::get('/home', function (){
    return view('customer.home');
})->name('home');

Route::get('/manage-profile', function () {
    return view('manageProfile');
})->name('manage-profile');

// Search
Route::get('/search', [VendorController::class, 'search'])->name('search');

// Catering Details
// Route::get('/catering-detail', function () {
//     return view('cateringDetail');
// })->name('catering-detail');

Route::get('/catering-detail/{vendor}', [VendorController::class, 'show'])->name('catering-detail');
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
// Route::get('/cateringHomePage', function() {
//     return view('cateringHomePage');
// });

// routes/web.php
Route::get('/cateringHomePage', [OrderVendorController::class, 'totalOrder']);


// Manage Packages
Route::get('/manageCateringPackage', [PackageController::class, 'index'])->name('manageCateringPackage');
Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');
Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
Route::post('/packages',           [PackageController::class, 'store'])->name('packages.store');

// Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
Route::post('/manageCateringPackage', [PackageController::class, 'store'])->name('packages.store');
Route::put('/manageCateringPackage/{package}', [PackageController::class, 'update'])->name('packages.update');
Route::post('/packages/import', [PackageController::class, 'import'])->name('packages.import');
Route::get('/manageOrder', [OrderVendorController::class, 'index'])
     ->name('orders.index');

Route::post(
    '/delivery-status/{orderId}/{slot}',
    [OrderVendorController::class, 'updateStatus']
)->name('delivery-status.update');

/* ---------------------
     ADMIN ROUTES
---------------------- */
