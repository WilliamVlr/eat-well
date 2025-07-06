@extends('master')

@section('title', 'Home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
@endsection

@section('content')
    <main class="container pt-3 pb-3 lexend">

        {{-- Untuk button ini jangan dihapus, untuk sementara button logout disini, menunggu UI logout beneran dibuat --}}
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"></button>
        </form>
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
                <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        </section>

        {{-- WellPay --}}
        <div class="wellpay-container mb-4">
            <div class="d-flex align-items-center mb-2 lexend">
                <span><img src="{{ asset('asset/navigation/eatwellLogo.png') }}" alt="logo"
                        style="width: 3.5vh; background-color: var(--bg-primary); border-radius: 5px;"></span>
                <span>
                    <h4 class="mb-0 ms-2">WellPay</h4>
                </span>
            </div>

            <div class="d-flex align-items-center">
                <span>
                    <h1 class="inter m-0 me-3 ms-2">Rp <span
                            id="wellpayBalanceAmount">{{ number_format($wellpay, 2, ',', '.') }}</span></h1>
                </span>
                <div class="d-flex align-items-center justify-content-center" id="toggleVisibilityBtn"
                    style="width: 30px; height: 30px; border: 3px solid var(--bg-primary); border-radius: 50%; background: var(--bg-primary);">
                    <span class="material-symbols-outlined" id="visibilityIcon"
                        style="font-variation-settings: 'FILL' 1; font-size: 20px; color: #fff; cursor: pointer;">visibility_off</span>
                </div>
            </div>

            <div class="d-flex align-items-center mt-2" id="topUpButton">
                {{-- Custom Modal 1 --}}
                <div id="customModal1" class="custom-modal-overlay">
                    <div class="custom-modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="customModal1Title">Add Balance to Your WellPay</h1>
                            <button type="button" class="btn-close" id="closeCustomModal1" aria-label="Close">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Current Balance:
                                <span class="fw-bold">
                                    Rp {{ number_format($wellpay, 2, ',', '.') }}
                                </span>
                            </h5>
                            <input type="hidden" id="currentBalanceValue" value="{{ $wellpay }}">
                            <div class="mb-3">
                                <label for="topupAmount" class="form-label mt-2">Enter the top up amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="topupAmount" name="topupAmount"
                                        autocomplete="off">
                                </div>
                                <div id="topupError" class="text-danger mt-1" style="font-size: 0.875em; display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="nextCustomModalBtn">Continue</button>
                        </div>
                    </div>
                </div>

                {{-- Custom Modal 2 --}}
                <div id="customModal2" class="custom-modal-overlay">
                    <div class="custom-modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="customModal2Title">Confirm Top-up</h1>
                            <button type="button" class="btn-close" id="closeCustomModal2" aria-label="Close">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <h6 class="m-0 inter">You are about to top up: <span id="confirmTopupAmount"
                                        class="fw-bold"></span></h6>
                                <h6 class="m-0 inter">Your new balance will be: <span id="confirmNewBalance"
                                        class="fw-bold"></span></h6>
                                <input type="hidden" id="finalTopupAmount" value="">
                                <hr>
                                <div class="mb-3">
                                    <label for="accountPassword" class="form-label">Enter your account's password</label>
                                    <input type="password" class="form-control" id="accountPassword" name="accountPassword"
                                        placeholder="Your password"
                                        style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;" autocomplete="current-password">
                                    <div id="passwordError" class="text-danger mt-1"
                                        style="font-size: 0.875em; display: none;"></div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" id="backToCustomModal1">Back</button>
                            <button class="btn btn-primary" id="confirmTopupBtn">Confirm</button>
                        </div>
                    </div>
                </div>


                <button class="btn d-flex justify-content-center align-items-center m-0" id="openCustomModal1"
                    style="width: 107px; background-color: var(--bg-contrast); padding: 5px; border-radius: 100px; color: #fff; cursor: pointer;">
                    <span class="me-2">Top up</span>
                    <div class="d-flex align-items-center justify-content-center"
                        style="width: 20px; height: 20px; border: 2px solid #fff; border-radius: 50%; background: var(--bg-contrast);">
                        <span class="material-symbols-outlined" style="font-size: 18px; color: #fff;">add</span>
                    </div>
                </button>
            </div>
        </div>

        <div id="successToast" class="success-toast">
            <span class="material-symbols-outlined check-icon">check_circle</span>
            <p id="successToastMessage" class="toast-message">Top-up berhasil!</p>
        </div>


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
                    <div class="row content ps-sm-3">19/02/2025</div>
                </div>
                <div class="col-6 col-sm-9 subscription-detail">
                    <div class="row sub-title">Active Until</div>
                    <div class="row content ps-sm-3">26/02/2025</div>
                </div>
                <div class="col-sm-3 subscription-detail">
                    <div class="row sub-title">Recipient Name</div>
                    <div class="row content ps-sm-3">Adit tolongin Dit</div>
                </div>
                <div class="col subscription-detail">
                    <div class="row sub-title">Delivery Address</div>
                    <div class="row content ps-sm-3">Jalan Mangga Barat No. 17 Blok D5, Bekasi</div>
                </div>

            </div>
            <div class="row catering-name font-400">
                Catering XYZ Lorem
            </div>
            <div class="row order-details">
                <div class="col-lg p-2 time-slot active">
                    <div class="row mb-1 justify-content-between align-content-center" data-bs-toggle="collapse"
                        data-bs-target="#breakfast-packages" role="button" aria-expanded="true"
                        aria-controls="breakfast-packages">
                        <div class="time-slot-type font-400 w-auto p-0 ps-1">Breakfast</div>
                        <div class="delivery-status hug-content align-self-center me-1">
                            Preparing
                        </div>
                    </div>
                    <div class="collapse" id="breakfast-packages">
                        <div class="row p-0 package justify-content-between align-content-center">
                            <div class="w-75 mb-1 p-0 ps-1 package-name">Paket Lorem Ipsum Dolor Amethyst Dolorosa
                                Megamendung
                            </div>
                            <div class="w-auto align-self-center me-1 quantity">
                                x 1
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg p-2 time-slot">
                    <div class="row mb-1 justify-content-between align-content-center" data-bs-toggle="collapse"
                        data-bs-target="#lunch-packages" role="button" aria-expanded="true"
                        aria-controls="breakfast-packages">
                        <div class="time-slot-type font-400 w-auto p-0 ps-1">Lunch</div>
                        {{-- <div class="delivery-status hug-content align-self-center me-1">
                            Preparing
                        </div> --}}
                    </div>
                    <div class="collapse" id="lunch-packages">
                        <div class="row mb-1 p-0 package justify-content-between align-content-center">
                            <div class="w-75 p-0 ps-1 package-name">Paket Lorem Ipsum Dolor Amethyst Dolorosa Megamendung
                            </div>
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
                </div>
                <div class="col-lg p-2 time-slot">
                    <div class="row mb-1 justify-content-between align-content-center" data-bs-toggle="collapse"
                        data-bs-target="#dinner-packages" role="button" aria-expanded="true"
                        aria-controls="breakfast-packages">
                        <div class="time-slot-type font-400 w-auto p-0 ps-1">Dinner</div>
                        {{-- <div class="delivery-status hug-content align-self-center me-1">
                            Preparing
                        </div> --}}
                    </div>
                    <div class="collapse" id="dinner-packages">
                        <div class="row p-0 package justify-content-between align-content-center">
                            <div class="w-75 mb-1 p-0 ps-1 package-name">Paket Lorem Ipsum Dolor Amethyst Dolorosa
                                Megamendung
                            </div>
                            <div class="w-auto align-self-center me-1 quantity">
                                x 1
                            </div>
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
                    <div class="col-lg card-medium mb-lg-1 me-lg-1 ms-lg-1">
                        <a href="#" class="row">
                            <div class="col-3 col-md-2 col-lg-3 col-xl-3 p-0">
                                <div class="image-container">
                                    <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                                </div>
                            </div>
                            <div
                                class="col-9 col-md-10 col-lg-9 col-xl-9 pe-0 ps-2 ps-xl-4 card-info pt-1 pt-xl-2 pb-md-2">
                                <div class="row detail mb-1 mb-lg-2 mb-xl-3 justify-content-between">
                                    <div class="left-contents">
                                        <div class="kota">
                                            Kota Kembangan Rupa
                                        </div>
                                    </div>
                                    <div class="right-content pe-2">
                                        <div class="logo-container">
                                            <span class="material-symbols-outlined favorite-icon">
                                                favorite
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row nama-catering mb-xl-1">Catering Naga Sakti Duar</div>
                                <div class="row time-slot-list mb-sm-1 mb-xl-2">Breakfast, Lunch, Dinner</div>
                                <div class="row rate-sold-container justify-content-start align-items-center">
                                    <div class="rating-container">
                                        <div class="logo-container">
                                            <span class="material-symbols-outlined star-icon">
                                                star
                                            </span>
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
                    <div class="col-lg card-medium mb-lg-1 me-lg-1 ms-lg-1">
                        <a href="#" class="row">
                            <div class="col-3 col-md-2 col-lg-3 col-xl-3 p-0">
                                <div class="image-container">
                                    <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="">
                                </div>
                            </div>
                            <div
                                class="col-9 col-md-10 col-lg-9 col-xl-9 pe-0 ps-2 ps-xl-4 card-info pt-1 pt-xl-2 pb-md-2">
                                <div class="row detail mb-1 mb-lg-2 mb-xl-3 justify-content-between">
                                    <div class="left-contents">
                                        <div class="kota">
                                            Kota Kembangan Rupa
                                        </div>
                                    </div>
                                    <div class="right-content pe-2">
                                        <div class="logo-container">
                                            <span class="material-symbols-outlined favorite-icon">
                                                favorite
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row nama-catering mb-xl-1">Catering Naga Sakti Duar</div>
                                <div class="row time-slot-list mb-sm-1 mb-xl-2">Breakfast, Lunch, Dinner</div>
                                <div class="row rate-sold-container justify-content-start align-items-center">
                                    <div class="rating-container">
                                        <div class="logo-container">
                                            <span class="material-symbols-outlined star-icon">
                                                star
                                            </span>
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
                    @for ($i = 0; $i < 3; $i++)
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
                                        <div class="right-content">
                                            <div class="logo-container">
                                                <span class="material-symbols-outlined favorite-icon">
                                                    favorite
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="catering-name">Catering Naga Sakti Duar</div>
                                    <div class="time-slot-list mb-1">Breakfast, Lunch, Dinner</div>
                                    <div class="rate-sold-container">
                                        <div class="rating-container">
                                            <div class="logo-container">
                                                <span class="material-symbols-outlined star-icon">
                                                    star
                                                </span>
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
                        </li>
                    @endfor
                </ul>
                {{-- <button class="arrow-btn button-slider-shadow" id="next">&gt;</button> --}}
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/favoriteCatering.js') }}"></script>
    {{-- <script src="{{ asset('js/customer/view-wellpay.js') }}"></script> --}}
    <script src="{{ asset('js/customer/wellpay.js') }}"></script>
@endsection
