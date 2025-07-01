<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\VendorController;
use App\Models\Order;
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

/* ---------------------
     CUSTOMER ROUTES
---------------------- */
// Customer Home
Route::get('/home', function (){
    return view('customer.home');
})->name('home');

// Catering Details
// Route::get('/catering-detail', function () {
//     return view('cateringDetail');
// })->name('catering-detail');

Route::get('/catering-detail/{vendor}', [VendorController::class, 'show'])->name('catering-detail');

Route::get('/catering-detail/rating-and-review', function(){
    return view('ratingAndReview');
})->name('rate-and-review');

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
Route::get('/cateringHomePage', function() {
    return view('cateringHomePage');
});

// Manage Packages
Route::get('/manageCateringPackage', [PackageController::class, 'index'])->name('manageCateringPackage');
Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');
// Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
Route::post('/manageCateringPackage', [PackageController::class, 'store'])->name('packages.store');
Route::put('/manageCateringPackage/{package}', [PackageController::class, 'update'])->name('packages.update');
Route::post('/packages/import', [PackageController::class, 'import'])->name('packages.import');


Route::get('/manageOrder', [OrderController::class, 'index'])
     ->name('orders.index');

Route::post(
    '/orders/{orderId}/status/{slot}',
    [OrderController::class, 'updateStatus']
)->name('orders.updateStatus');

