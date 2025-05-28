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
});

Route::get('/', function () {
    return view('landingPage');
});
Route::get('/manageOrder', function(){
    return view('manageOrder');
});
