<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function () {
    return view('test');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/', function () {
    return view('landingPage');
});