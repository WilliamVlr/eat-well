@extends('master')

@section('title')
    {{ $vendor->name }}
@endsection

@section('css')
    <meta name="vendor-id" content="{{ $vendor->vendorId }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/cateringDetail.css') }}">
    {{-- bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1" rel="stylesheet" />
@endsection

@section('content')
    <div class="profile-container">
        <div class="container daun-container">
            <img src="{{ asset('asset/catering-detail/daun1.png') }}" alt="Catering Image" class="daun1">
            <img src="{{ asset('asset/catering-detail/daun2.png') }}" alt="Catering Image" class="daun2">
            <div class="container all-profile-wrapper">
                <div class="catering-info-left-wrapper">
                    <h1 class="lexend">{{ $vendor->name }}</h1>
                    {{-- <p class="inter sold-text">10k+ sold</p> --}}

                    <div class="phone-number-and-schedule-wrapper">
                        <div class="phone-number-container">
                            <span class="material-symbols-outlined call-icon">call</span>
                            <span class="inter phone-number">{{ $vendor->phone_number }}</span>
                        </div>
                        <div class="schedule-container">
                            {{-- <span class="inter schedule">Monday - Sunday</span> --}}
                            <span class="inter schedule">10k+ sold</span>
                        </div>
                    </div>

                    <div class="location-wrapper">
                        <span class="material-symbols-outlined location-icon">pin_drop</span>
                        <span class="inter address">{{ $vendor->jalan }}, {{  $vendor->kelurahan }}, {{  $vendor->kecamatan }}, {{  $vendor->kabupaten }}, {{  $vendor->provinsi }}, {{  $vendor->kode_pos }}</span>
                    </div>

                    <div class="rating-and-number-sold-wrapper">
                        <a href="{{ route('rate-and-review') }}" class="rate-review-button">
                            <div class="rating-container">
                                <span class="material-symbols-outlined star-icon">star</span>
                                <span class="inter rating-and-sold">{{ $vendor->rating }}</span>
                            </div>
                        </a>
                        <div class="number-sold-container">
                            {{-- <span class="inter rating-and-sold">10k+</span>
                            <span class="inter sold-text">sold</span> --}}
                            <span class="inter rating-and-sold">Order Now</span>
                        </div>
                    </div>
                </div>

                <div class="catering-info-right-wrapper">
                    <div class="hijau-luar">
                        <div class="cokelat-lingkaran">
                            <div>
                                {{-- <img src="{{ asset('asset/catering-detail/logo-aldenaire-catering.jpg') }}" alt="Catering Image" class="logo-catering"> --}}
                                <img src="{{ asset($vendor->logo) }}" alt="Catering Image" class="logo-catering">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="food-preview-container">
        <h1 class="lexend">From Our Kitchen to Your Table</h1>

        <div class="carousel-wrapper">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('asset/catering-detail/food preview 1.jpeg') }}" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('asset/catering-detail/food preview 2.jpg') }}" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('asset/catering-detail/food preview 3.jpeg') }}" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('asset/catering-detail/food preview 4.jpg') }}" class="d-block w-100"
                            alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    </div>

    <div class="price-and-shipping-container">
        <div class="weekly-price-wrapper">
            <h1 class="lexend">Weekly Price</h1>
            <div class="price-container">
                <div class="price-bulet">
                    {{-- <h1 class="lexend">625k</h1> --}}
                    <h1 class="lexend" id="displayedPrice"></h1>
                </div>
                <div class="price-kanan">
                    <div class="dropdown">
                        <button id="dropdownMenuButton" class="btn btn-secondary dropdown-toggle inter" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $packages[0]->name }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($packages as $package)
                                {{-- <li class="dropdown-item inter">{{ $package->name }}</li> --}}
                                <li class="dropdown-item inter" data-package-id="{{ $package->packageId }}"
                                    data-breakfast-price="{{ $package->breakfastPrice ?? 'null' }}"
                                    data-lunch-price="{{ $package->lunchPrice ?? 'null' }}"
                                    data-dinner-price="{{ $package->dinnerPrice ?? 'null' }}">
                                    {{ $package->name }}
                                </li>
                            @endforeach
                            {{-- <li class="dropdown-item inter">Package A</li>
                            <li class="dropdown-item inter">Package B</li>
                            <li class="dropdown-item inter">Package C</li> --}}
                        </ul>
                    </div>

                    <!-- Hidden input to hold selected value for form submission -->
                    <input type="hidden" name="selected_package" id="selectedPackage" value="Package A">

                    <ul class="list-group inter" id="mealOptions">
                        {{-- These will be dynamically populated by JavaScript --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="shipping-wrapper">
            <h1 class="lexend">Shipping Time</h1>
            <p class="inter text-white schedule-dipake">Monday - Sunday</p>
            @if ($vendor->breakfast_delivery)
                <div class="section-makan">
                    <h3 class="inter">Breakfast</h3>
                    <p class="inter">{{ $vendor->breakfast_delivery }}</p>
                </div>
            @endif
            @if ($vendor->lunch_delivery)
                <div class="section-makan">
                    <h3 class="inter">Lunch</h3>
                    <p class="inter">{{ $vendor->lunch_delivery }}</p>
                </div>
            @endif
            @if ($vendor->dinner_delivery)
                <div class="section-makan">
                    <h3 class="inter">Dinner</h3>
                    <p class="inter">{{ $vendor->dinner_delivery }}</p>
                </div>
            @endif
        </div>
    </div>

    <section id="packages">
        <div class="container packages">
            <h1 class="lexend">Our Packages</h1>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="accordions inter">
                            @foreach ($packages as $package)
                                <div class="accordion-item">
                                    <div class="accordion-title" data-package-id="{{ $package->packageId }}">
                                        <div class="left-card-wrapper">
                                            @if ($package->imgPath)
                                                <div>
                                                    <img src="{{ asset($package->imgPath) }}"
                                                        alt="{{ $package->name }} Image" class="package-image">
                                                </div>
                                            @else
                                                <div>
                                                    <img src="{{ asset('asset/catering-detail/logo-packages.png') }}"
                                                        alt="Packages Image" class="package-image">
                                                </div>
                                            @endif
                                            <div>
                                                <div class="nama-package-dan-download-wrapper">
                                                    <h4>{{ $package->name }}</h4>
                                                    <div class="download-wrapper">
                                                        {{-- <span class="material-symbols-outlined download-icon" data-pdf="{{ asset('asset/catering-detail/pdf/vegetarian-package-menu.pdf') }}"> --}}
                                                        <span class="material-symbols-outlined download-icon"
                                                            data-pdf="{{ asset($package->menuPDFPath) }}">
                                                            download
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="category-cuisine-wrapper">
                                                    <span class="category-cuisine-bold">Category:</span>
                                                    <span>{{ $package->category->categoryName ?? 'N/A' }}</span>
                                                    <div></div>
                                                    <span class="category-cuisine-bold">Cuisine Type:</span>
                                                    <span>
                                                        @forelse ($package->cuisineTypes as $cuisine)
                                                            {{ $cuisine->cuisineName }}{{ !$loop->last ? ', ' : '' }}
                                                        @empty
                                                            N/A
                                                        @endforelse
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-card-wrapper">
                                            {{-- <p class="view-menu-text inter" data-pdf="{{ asset('asset/catering-detail/pdf/vegetarian-package-menu.pdf') }}"> --}}
                                            <p class="view-menu-text inter"
                                                data-pdf="{{ asset($package->menuPDFPath) }}">
                                                View Package's Menu
                                            </p>
                                            <div class="add-button" data-tab="item{{ $package->packageId }}">
                                                <p class="add-text inter">Add</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-content" id="item{{ $package->packageId }}">
                                        <div class="menu-item">
                                            @if (!is_null($package->breakfastPrice))
                                                <div class="item-row">
                                                    <span>Breakfast</span>
                                                    <span class="price" data-price="{{ $package->breakfastPrice }}">Rp.
                                                        {{ number_format($package->breakfastPrice, 0, ',', '.') }},-</span>
                                                    <div class="qty-control">
                                                        <button class="decrement">−</button>
                                                        <span class="qty">0</span>
                                                        <button class="increment">+</button>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!is_null($package->lunchPrice))
                                                <div class="item-row">
                                                    <span>Lunch</span>
                                                    <span class="price" data-price="{{ $package->lunchPrice }}">Rp.
                                                        {{ number_format($package->lunchPrice, 0, ',', '.') }},-</span>
                                                    <div class="qty-control">
                                                        <button class="decrement">−</button>
                                                        <span class="qty">0</span>
                                                        <button class="increment">+</button>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!is_null($package->dinnerPrice))
                                                <div class="item-row">
                                                    <span>Dinner</span>
                                                    <span class="price" data-price="{{ $package->dinnerPrice }}">Rp.
                                                        {{ number_format($package->dinnerPrice, 0, ',', '.') }},-</span>
                                                    <div class="qty-control">
                                                        <button class="decrement">−</button>
                                                        <span class="qty">0</span>
                                                        <button class="increment">+</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="button-order inter" id="proceedToPaymentButton">
            <span class="order-message">No Package Selected Yet.</span>
            <span class="package-count" style="display:none;"></span>
            <span class="item-count" style="display:none;"></span>
            <span class="price-total" style="display:none;"></span>
        </div> --}}
        <a href="{{ route('payment.show', ['vendor' => $vendor->vendorId]) }}" class="button-order inter"
            id="proceedToPaymentLink"
            style="cursor: default; pointer-events: none; text-decoration: none;">
            <span class="order-message">No Package Selected Yet.</span>
            <span class="package-count" style="display:none;"></span>
            <span class="item-count" style="display:none;"></span>
            <span class="price-total" style="display:none;"></span>
        </a>
    </section>

    <!-- Modal PDF Viewer -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <iframe id="pdfFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/catering detail/modalPdf-cateDetail.js') }}"></script>
    <script src="{{ asset('js/catering detail/dropdown-cateDetail.js') }}"></script>
    <script src="{{ asset('js/catering detail/package-cateDetail.js') }}"></script>
@endsection
