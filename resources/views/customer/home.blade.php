@extends('master')

@section('title', 'Home')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
    <main class="container pt-3 pb-3 lexend">
        {{-- Carousel --}}
        <section id = "carouselIklan" class="carousel slide mb-4 mb-md-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('asset/customer/home/iklan 1.jpg') }}" class="object-fit-cover" alt="Iklan 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('asset/customer/home/iklan 2.jpg') }}" alt="Iklan 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('asset/customer/home/iklan 3.jpg') }}" alt="Iklan 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIklan" data-bs-slide="prev">
                <div class="carousel-btn-container btn-prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </div>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselIklan" data-bs-slide="next">
                <div class="carousel-btn-container btn-next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </div>
            </button>
            {{-- Carousel indicators --}}
            <div class="carousel-indicators mt-2">
                <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        </section>
        {{-- Active Subscription Card --}}
        <section class="w-100 h-auto mb-md-5 mb-4 subscription-card p-4">
            <div class="row mb-2 justify-content-between align-content-end">
                <div class="title font-400 w-auto">My Subscription</div>
                <div class="hug-content detail d-flex align-self-end">
                    <a href="#" class="detail-link">View all</a>
                </div>
            </div>
            <div class="row mb-2 gy-1">
                <div class="col-6 col-sm-3 subscription-detail">
                    <div class="row sub-title">Active From</div>
                    <div class="row content ps-3">19/02/2025</div>
                </div>
                <div class="col-6 col-sm-9 subscription-detail">
                    <div class="row sub-title">Active Until</div>
                    <div class="row content ps-3">26/02/2025</div>
                </div>
                <div class="col-sm-3 subscription-detail">
                    <div class="row sub-title">Recipient Name</div>
                    <div class="row content ps-3">Adit tolongin Dit</div>
                </div>
                <div class="col subscription-detail">
                    <div class="row sub-title">Delivery Address</div>
                    <div class="row content ps-3">Jalan Mangga Barat No. 17 Blok D5, Bekasi</div>
                </div>
                
            </div>
            <div class="row catering-name font-400">
                Catering XYZ Lorem
            </div>
            <div class="row order-details">
                <div class="col-lg p-2 time-slot active">
                    <div class="row mb-1 justify-content-between align-content-center">
                        <div class="time-slot-type font-300 w-auto p-0 ps-1">Breakfast</div>
                        <div class="delivery-status hug-content align-self-center me-1">
                            Preparing
                        </div>
                    </div>
                    <div class="row p-0 package justify-content-between align-content-center">
                        <div class="w-75 mb-1 p-0 ps-1 package-name">Paket Lorem Ipsum Dolor Amethyst Dolorosa Megamendung</div>
                        <div class="w-auto align-self-center me-1 quantity">
                            x 1
                        </div>
                    </div>
                </div>
                <div class="col-lg p-2 time-slot">
                    <div class="row mb-1 justify-content-between align-content-center">
                        <div class="time-slot-type font-300 w-auto p-0 ps-1">Lunch</div>
                        {{-- <div class="delivery-status hug-content align-self-center me-1">
                            Preparing
                        </div> --}}
                    </div>
                    <div class="row mb-1 p-0 package justify-content-between align-content-center">
                        <div class="w-75 p-0 ps-1 package-name">Paket Lorem Ipsum Dolor Amethyst Dolorosa Megamendung</div>
                        <div class="w-auto align-self-center me-1 quantity">
                            x 1
                        </div>
                    </div>
                    <div class="row p-0 package justify-content-between align-content-center">
                        <div class="w-75 p-0 ps-1 package-name">Paket LaTex Lajex</div>
                        <div class="w-auto align-self-center me-1 quantity">
                            x 1
                        </div>
                    </div>
                </div>
                <div class="col-lg p-2 time-slot">
                    <div class="row mb-1 justify-content-between align-content-center">
                        <div class="time-slot-type font-300 w-auto p-0 ps-1">Dinner</div>
                        {{-- <div class="delivery-status hug-content align-self-center me-1">
                            Preparing
                        </div> --}}
                    </div>
                    <div class="row p-0 package justify-content-between align-content-center">
                        <div class="w-75 mb-1 p-0 ps-1 package-name">Paket Lorem Ipsum Dolor Amethyst Dolorosa Megamendung</div>
                        <div class="w-auto align-self-center me-1 quantity">
                            x 1
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Popular Caterings --}}
        <section class="popular-catering-container w-100 h-auto mb-md-5 mb-4">
            <div class="row title-1">Popular Catering Near You</div>
            @for ($i = 0; $i < 5; $i++)
            <div class="row list-container mb-3">
                <div class="col-lg card-medium">
                    <a href="#" class="row">
                        <div class="col-3 col-md-2 col-lg-3 col-xl-3 p-0">
                            <div class="image-container">
                                <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-9 col-md-10 col-lg-9 col-xl-9 pe-0 ps-2 ps-xl-4 card-info pt-1 pt-xl-2 pb-md-2">
                            <div class="row detail mb-1 mb-lg-2 mb-xl-3 justify-content-between">
                                <div class="left-contents">
                                    <div class="kota">
                                        Kota Kembangan Rupa
                                    </div>
                                </div>
                                <div class="right-content pe-2">
                                    <div class="logo-container">
                                        <i class="fa-regular fa-heart" style="color: #000000;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row nama-catering mb-xl-1">Catering Naga Sakti Duar</div>
                            <div class="row time-slot-list mb-sm-1 mb-xl-2">Breakfast, Lunch, Dinner</div>
                            <div class="row rate-sold-container justify-content-start align-items-center">
                                <div class="rating-container">
                                    <div class="logo-container">
                                        {{-- logo bintang --}}
                                    </div>
                                    4.9
                                </div>
                                <div class="circle"></div>
                                <div class="sold-container">
                                    10k+ Sold
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg card-medium">
                    <a href="#" class="row">
                        <div class="col-3 col-md-2 col-lg-3 col-xl-3 p-0">
                            <div class="image-container">
                                <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-9 col-md-10 col-lg-9 col-xl-9 pe-0 ps-2 ps-xl-4 card-info pt-1 pt-xl-2 pb-md-2">
                            <div class="row detail mb-1 mb-lg-2 mb-xl-3 justify-content-between">
                                <div class="left-contents">
                                    <div class="kota">
                                        Kota Kembangan Rupa
                                    </div>
                                </div>
                                <div class="right-content pe-2">
                                    <div class="logo-container">
                                        <i class="fa-regular fa-heart" style="color: #000000;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row nama-catering mb-xl-1">Catering Naga Sakti Duar</div>
                            <div class="row time-slot-list mb-sm-1 mb-xl-2">Breakfast, Lunch, Dinner</div>
                            <div class="row rate-sold-container justify-content-start align-items-center">
                                <div class="rating-container">
                                    <div class="logo-container">
                                        {{-- logo bintang --}}
                                    </div>
                                    4.9
                                </div>
                                <div class="circle"></div>
                                <div class="sold-container">
                                    10k+ Sold
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endfor
        </section>
        {{-- Favorited Catering or Recently Viewed? --}}
        <section class="fav-catering-container w-100 h-auto mb-md-5 mb-4">
            {{-- Kasih if gaada --}}
            <div class="section-title-wrap d-flex flex-row justify-content-between align-items-center">
                <h3 class="title-1">Your Favorites</h3>
                <a href="#" class="detail-link">View all</a>
            </div>
            <div class="carousel-slider-wrap carousel-style-1 mt-10 align-self-center">
                {{-- <button class="arrow-btn button-slider-shadow" id="prev">&lt;</button> --}}
                <ul class="carousel-product-list">
                    <li>
                        <a href="#" class="card-vertical" draggable="false">
                            <div class="image-container">
                                <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                            </div>
                            <div class="card-info pt-2">
                                <div class="row detail mb-1 mb-lg-2 justify-content-between">
                                <div class="left-contents">
                                    <div class="kota">
                                        Kota Kembangan Rupa
                                    </div>
                                </div>
                                <div class="right-content pe-2">
                                    <div class="logo-container">
                                        <i class="fa-regular fa-heart" style="color: #000000;"></i>
                                    </div>
                                </div>
                            </div>
                                <div class="catering-name">Catering Naga Sakti Duar</div>
                                <div class="time-slot-list mb-1">Breakfast, Lunch, Dinner</div>
                                <div class="rate-sold-container">
                                    <span class="rating">4.9</span>
                                    <div class="circle"></div>
                                    <span class="sold">10k+ Sold</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="card-vertical" draggable="false">
                            <div class="image-container">
                                <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                            </div>
                            <div class="card-info pt-2">
                                <div class="row detail mb-1 mb-lg-2 justify-content-between">
                                <div class="left-contents">
                                    <div class="kota">
                                        Kota Kembangan Rupa
                                    </div>
                                </div>
                                <div class="right-content pe-2">
                                    <div class="logo-container">
                                        <i class="fa-regular fa-heart" style="color: #000000;"></i>
                                    </div>
                                </div>
                            </div>
                                <div class="catering-name">Catering Naga Sakti Duar</div>
                                <div class="time-slot-list mb-1">Breakfast, Lunch, Dinner</div>
                                <div class="rate-sold-container">
                                    <span class="rating">4.9</span>
                                    <div class="circle"></div>
                                    <span class="sold">10k+ Sold</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="card-vertical" draggable="false">
                            <div class="image-container">
                                <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                            </div>
                            <div class="card-info pt-2">
                                <div class="row detail mb-1 mb-lg-2 justify-content-between">
                                <div class="left-contents">
                                    <div class="kota">
                                        Kota Kembangan Rupa
                                    </div>
                                </div>
                                <div class="right-content pe-2">
                                    <div class="logo-container">
                                        <i class="fa-regular fa-heart" style="color: #000000;"></i>
                                    </div>
                                </div>
                            </div>
                                <div class="catering-name">Catering Naga Sakti Duar</div>
                                <div class="time-slot-list mb-1">Breakfast, Lunch, Dinner</div>
                                <div class="rate-sold-container">
                                    <span class="rating">4.9</span>
                                    <div class="circle"></div>
                                    <span class="sold">10k+ Sold</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                {{-- <button class="arrow-btn button-slider-shadow" id="next">&gt;</button> --}}
            </div>
        </section>
    </main>
@endsection
