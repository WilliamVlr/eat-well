<?php

use App\Http\Controllers\VendorController;
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

// Search
// Route::get('/search', function(){
//     return view('customer.search');
// });
Route::get('/search', [VendorController::class, 'search'])->name('search');

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
Route::get('/manageCateringPackage', function(){
    return view('manageCateringPackage');
});

// Manage Order
Route::get('/manageOrder', function(){
    return view('manageOrder');
});


/* ---------------------
     ADMIN ROUTES
---------------------- */