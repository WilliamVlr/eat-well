<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function () {
    return view('test');
});

Route::get('/cateringHomePage', function() {
    return view('cateringHomePage');
});

Route::get('/manageCateringPackage', function(){
    return view('manageCateringPackage');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/catering-detail', function () {
    return view('cateringDetail');
})->name('catering-detail');

Route::get('/', function () {
    return view('landingPage');
});
Route::get('/manageOrder', function(){
    return view('manageOrder');
});

Route::get('/about-us', function(){
    return view('aboutUs');
});

Route::get('/manage-address', function(){
    return view('ManageAddress');
});


Route::get('/catering-detail/rating-and-review', function(){
    return view('ratingAndReview');
})->name('rate-and-review');
