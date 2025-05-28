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

Route::get('/manageCatering', function(){
    return view('manageCatering');
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

Route::get('/catering-detail/rating-and-review', function(){
    return view('ratingAndReview');
})->name('rate-and-review');