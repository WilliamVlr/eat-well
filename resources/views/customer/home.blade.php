@extends('master')

@section('title', 'Home')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/cardVendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <main class="">
        {{-- Carousel/Image --}}
        <img src="{{ asset('asset/customer/home/iklan 1.jpg') }}" class="img-fluid" alt="..."
            style="width: 100%; max-height: 350px; object-fit: cover;">
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
                    <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselIklan" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
            </section>
            {{-- Active Subscription Card --}}
            <section class="container w-100 mt-3 h-auto mb-md-5 mb-4 subscription-card p-4">
                <div class="row mb-2 justify-content-between align-content-end">
                    <div class="title font-400 w-auto">My Subscription</div>
                    <div class="hug-content detail d-flex align-self-end">
                        <a href="{{ route('order-history') }}" class="detail-link">View all</a>
                    </div>
                </div>
                @if ($order)
                    <div class="row mb-2 gy-1">
                        <div class="col-6 col-sm-3 subscription-detail">
                            <div class="row sub-title">Active From</div>
                            <div class="row content ps-sm-3">{{ Carbon::parse($order->startDate)->format('d M Y') }}</div>
                        </div>
                        <div class="col-6 col-sm-3 col-lg-9 subscription-detail">
                            <div class="row sub-title">Active Until</div>
                            <div class="row content ps-sm-3">{{ Carbon::parse($order->endDate)->format('d M Y') }}</div>
                        </div>
                        <div class="col-sm subscription-detail">
                            <div class="row sub-title">Recipient Name</div>
                            <div class="row content ps-sm-3">{{ $order->recipient_name }}</div>
                        </div>
                        <div class="col col-sm-9 subscription-detail">
                            <div class="row sub-title">Delivery Address</div>
                            <div class="row content ps-sm-3">{{ $order->jalan . ', ' . $order->kota }}</div>
                        </div>

                    </div>
                    <div class="row catering-name font-400 pb-2">
                        {{ $order->vendor->name }}
                    </div>
                    <div class="row order-details">
                        @php
                            $slotLabelMap = [
                                'morning' => 'Breakfast',
                                'afternoon' => 'Lunch',
                                'evening' => 'Dinner',
                            ];
                            $slotOrder = ['morning', 'afternoon', 'evening'];
                            $canShow = true;
                        @endphp

                        @foreach ($slotOrder as $slotKey)
                            @if (isset($slotMap[$slotKey]))
                                @if ($canShow)
                                    <div class="col-lg p-2 time-slot active">
                                        <div class="row mb-1 justify-content-between align-content-center"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $slotKey }}-packages"
                                            role="button" aria-expanded="false"
                                            aria-controls="{{ $slotKey }}-packages">
                                            <div class="time-slot-type font-400 w-auto p-0 ps-1">
                                                {{ $slotLabelMap[$slotKey] ?? ucfirst($slotKey) }}
                                            </div>
                                            <div class="delivery-status hug-content align-self-center me-1">
                                                @php
                                                    $status = $slotMap[$slotKey]['deliveryStatus'];
                                                    $statusValue = strtolower(
                                                        $status->status->value ?? ($status->status ?? ''),
                                                    );
                                                    $statusText = $status
                                                        ? ucfirst($status->status->value ?? $status->status)
                                                        : '-';
                                                @endphp
                                                {{ $statusText }}
                                            </div>
                                        </div>
                                        <div class="collapse" id="{{ $slotKey }}-packages">
                                            @foreach ($slotMap[$slotKey]['packages'] as $item)
                                                <div class="row p-0 package justify-content-between align-content-center">
                                                    <div class="w-75 mb-1 p-0 ps-1 package-name">{{ $item['package'] }}
                                                    </div>
                                                    <div class="w-auto align-self-center me-1 quantity">x
                                                        {{ $item['quantity'] }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @php
                                        // Only allow next slot if this slot is "arrived"
                                        $canShow = $statusValue === 'arrived';
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                    </div>
                @else
                    <div>
                        <h2 class="text-center fw-500 mb-0">No active subscription right now</h2>
                        <p class="text-center mb-0">Order Now!</p>
                    </div>
                @endif
            </section>
            {{-- Popular Caterings --}}
            <section class="container mt-3 popular-catering-container w-100 h-auto mb-md-5 mb-4">
                <div class="row title-1">Popular Catering Near You</div>
                <div class="row">
                    @foreach ($vendors as $vendor)
                        <div class="col-md-6 col-xl-4 p-2">
                            <x-card-vendor :vendor="$vendor"></x-card-vendor>
                        </div>
                    @endforeach
                </div>
            </section>
            {{-- Favorited Catering or Recently Viewed? --}}
            @if (!$favVendors)
                <section class="container fav-catering-container mt-3 w-100 h-auto mb-md-5 mb-4">
                    {{-- Kasih if gaada --}}
                    <div class="section-title-wrap d-flex flex-row justify-content-between align-items-center">
                        <h3 class="title-1">Your Favorites</h3>
                        <a href="#" class="detail-link">View all</a>
                    </div>
                    <div class="carousel-slider-wrap carousel-style-1 mt-10 align-self-center">
                        {{-- <button class="arrow-btn button-slider-shadow" id="prev">&lt;</button> --}}
                        <ul class="carousel-product-list">
                            @foreach ($favVendors as $vendor)
                                <li>
                                    <x-card-vendor :vendor="$vendor"></x-card-vendor>
                                </li>
                            @endforeach
                        </ul>
                        {{-- <button class="arrow-btn button-slider-shadow" id="next">&gt;</button> --}}
                    </div>
                </section>
            @endif
        </main>
    @endsection

    @section('script')
        <script src="{{ asset('js/customer/favoriteCatering.js') }}"></script>
    @endsection
