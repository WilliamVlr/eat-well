@extends('master')

@section('title', 'EatWell | Order Detail')

@php
    use Carbon\Carbon;
@endphp

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/orderHistory.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/orderDetail.css') }}">
@endsection

@section('content')
    <main>
        <div class="container">
            <div class="order-detail-card">
                {{-- Card Header --}}
                <section class="card-header">
                    <div class="left-container">
                        <button onclick="window.history.back()" class="btn-back">
                            <span class="icon">&lt;</span>
                            <span class="">Back</span>
                        </button>
                    </div>
                    <div class="right-container">
                        <div class="text-wrapper">
                            <span class="">Order ID. 237373</span>
                        </div>
                        <div class="text-wrapper label-status status-cancelled">
                            Cancelled
                        </div>
                    </div>
                </section>
                <section class="card-order-status">
                    <div class="order-status-progress d-flex align-items-center justify-content-between">
                        {{-- Order Placed --}}
                        <div class="status-step active">
                            <div class="circle">
                                <span class="material-symbols-outlined">shopping_cart</span>
                            </div>
                            <div class="label">Order Placed</div>
                        </div>
                        <div class="status-line active"></div>
                        {{-- Order Paid --}}
                        <div class="status-step active">
                            <div class="circle">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                            <div class="label">Order Paid</div>
                        </div>
                        <div class="status-line "></div>
                        {{-- Subscription Active --}}
                        <div class="status-step ">
                            <div class="circle">
                                <span class="material-symbols-outlined">autorenew</span>
                            </div>
                            <div class="label">Subscription Active</div>
                        </div>
                        <div class="status-line "></div>
                        {{-- Subscription Finished --}}
                        <div class="status-step ">
                            <div class="circle">
                                <span class="material-symbols-outlined">check_circle</span>
                            </div>
                            <div class="label">Subscription Finished</div>
                        </div>
                    </div>
                </section>

                {{-- card-delivery-status section --}}
                @php
                    $timeSlots = [
                        ['key' => 'morning', 'label' => 'Morning', 'icon' => 'partly_cloudy_day'],
                        ['key' => 'afternoon', 'label' => 'Afternoon', 'icon' => 'wb_sunny'],
                        ['key' => 'evening', 'label' => 'Evening', 'icon' => 'nights_stay'],
                    ];
                    $statuses = [
                        ['key' => 'preparing', 'icon' => 'restaurant'],
                        ['key' => 'delivering', 'icon' => 'local_shipping'],
                        ['key' => 'arrived', 'icon' => 'check_circle'],
                    ];
                    $activeStatus = 1; // Example: up to delivering
                @endphp

                <section class="card-delivery-status mt-4">
                    <div class="cds-status-flex">
                        {{-- LEFT: Delivery Address --}}
                        <div class="cds-status-left-container flex-grow-1 pe-xl-5 mb-3 mb-lg-0">
                            <div class="cds-address-title">Delivery Address</div>
                            <div class="cds-address-recipient">
                                <h5 class="recipient-name">William Vlr</h5>
                                <p class="recipient-phone">+62 819876678987</p>
                                <p class="recipient-address">Addressnya bang</p>
                            </div>
                        </div>
                        {{-- RIGHT: Day Filter, Date, Carousel/Slider --}}
                        <div class="cds-status-right-container flex-grow-2">
                            <div class="cds-delivery-days d-flex justify-content-center mb-3">
                                @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $i => $day)
                                    <button class="cds-day-circle{{ $i === 0 ? ' active' : '' }}">
                                        {{ $day }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="text-center mb-4">
                                <h4 class="cds-delivery-date">Monday, 10 June 2025</h4>
                            </div>
                            {{-- MOBILE: Carousel with indicators --}}
                            <div class="cds-delivery-carousel d-block d-md-none">
                                <div id="cdsCarousel" class="carousel slide">
                                    <div class="carousel-indicators cds-carousel-indicators">
                                        @foreach ($timeSlots as $idx => $slot)
                                            <button type="button" data-bs-target="#cdsCarousel"
                                                data-bs-slide-to="{{ $idx }}"
                                                class="cds-carousel-indicator-btn {{ $idx === 0 ? 'active' : '' }}"
                                                aria-current="{{ $idx === 0 ? 'true' : 'false' }}"
                                                aria-label="{{ $slot['label'] }}">
                                                <span class="material-symbols-outlined">{{ $slot['icon'] }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach ($timeSlots as $idx => $slot)
                                            <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                                                <div class="cds-delivery-slot-card mx-auto">
                                                    <div class="cds-slot-title text-center mb-2">{{ $slot['label'] }}</div>
                                                    <div class="cds-slot-status-list">
                                                        @foreach ($statuses as $sIdx => $status)
                                                            <div
                                                                class="cds-slot-status-row{{ $sIdx <= $activeStatus ? ' active' : '' }}">
                                                                <div
                                                                    class="cds-circle-icon d-flex align-items-center justify-content-center">
                                                                    <span
                                                                        class="material-symbols-outlined status-icon-sm">{{ $status['icon'] }}</span>
                                                                </div>
                                                                <div class="cds-status-label">{{ ucfirst($status['key']) }}
                                                                </div>
                                                                @if ($sIdx < 2)
                                                                    <div class="cds-status-vline"></div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{-- DESKTOP: Row of cards --}}
                            <div class="cds-delivery-slider-wrapper d-none d-md-block">
                                <div class="cds-delivery-slider d-flex justify-content-center align-items-end">
                                    @foreach ($timeSlots as $slot)
                                        <div class="cds-delivery-slot-card {{ $slot === 0 ? 'active' : '' }}">
                                            <div class="cds-slot-title text-center mb-2">{{ $slot['label'] }}</div>
                                            <div class="cds-slot-status-list">
                                                @foreach ($statuses as $sIdx => $status)
                                                    <div
                                                        class="cds-slot-status-row {{ $sIdx <= $activeStatus ? ' active' : '' }}">
                                                        <div
                                                            class="cds-circle-icon d-flex align-items-center justify-content-center">
                                                            <span
                                                                class="material-symbols-outlined status-icon-sm">{{ $status['icon'] }}</span>
                                                        </div>
                                                        <div class="cds-status-label">{{ ucfirst($status['key']) }}</div>
                                                        @if ($sIdx < 2)
                                                            <div class="cds-status-vline"></div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            {{-- Order Items --}}
            <section class="card-detail-items mb-4">
                <div class="card-order">
                    <div class="card-header">
                        <div class="left-container">
                            <div class="text-wrapper vendor-name-wrapper">
                                <h5 class="">{{ $order->vendor->name }}</h5>
                            </div>
                            <button onclick="" class="text-wrapper btn-view">
                                <p>View Catering</p>
                            </button>
                        </div>
                        <div class="right-container">
                            <div class="text-wrapper order-date">
                                <p class="date">{{ Carbon::parse($order->startDate)->format('d/m/Y') }}</p>
                                <p class="date">-</p>
                                <p class="date">{{ Carbon::parse($order->endDate)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Redirect ke catering pagenya langsung scroll ke packagenya --}}
                    <a href="#" class="card-content-wrapper text-decoration-none">
                        @foreach ($order->orderItems as $item)
                            <div class="card-content">
                                <div class="image-wrapper">
                                    {{-- <img src="{{$item->package->imgPath ? asset($item->package->imgPath) : asset('asset/catering-detail/logo-packages.png')}}" alt="Gambar Paket"> --}}
                                    <img src="{{ asset('asset/catering-detail/logo-packages.png') }}" alt="gambar paket">
                                </div>
                                <div class="right-container">
                                    <div class="package-detail">
                                        <div class="text-container detail-primary">{{ $item->package->name }}</div>
                                        <div class="text-container d-flex flex-row flex-md-column column-gap-2">
                                            <div class="text-wrapper detail-secondary">
                                                Variant: {{ $item->packageTimeSlot }}
                                            </div>
                                            <div class="text-wrapper detail-secondary">
                                                x{{ $item->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price-wrapper">
                                        <div class="text-wrapper">
                                            <p>
                                                Rp {{ number_format($item->price, 2, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </a>
                    <div class="card-bottom">
                        <div class="left-container">

                        </div>
                        <div class="right-container">
                            <div class="total-container">
                                <div class="total-row d-flex justify-content-between align-items-center">
                                    <span class="total-label">Total order</span>
                                    <span class="total-value main-total">Rp
                                        {{ number_format($order->totalPrice, 2, ',', '.') }}</span>
                                </div>
                                <div class="total-row d-flex justify-content-between align-items-center">
                                    <span class="total-label">Payment method</span>
                                    <span class="total-value">{{ $order->paymentMethod->name ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/customer/orderDetail.js') }}"></script>
@endsection
