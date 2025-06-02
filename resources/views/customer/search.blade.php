@extends('master')

@section('title', 'Eat-Well | Search')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/search.css') }}">
@endsection

@section('content')
    <main>
        {{-- Location and Search --}}
        <section class="location-search mb-3">
            <div class="container">
                <div class="row mb-3 gy-2 gy-sm-0">
                    <div class="location-container col-sm-3">
                        <div class="dropdown location-dropdown">
                            <button
                                class="location-wrapper btn btn-neutral dropdown-toggle d-flex align-items-center w-100 text-start"
                                type="button" id="location-dropdown-button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined icon-md me-1"> location_on</span>
                                <span class="location-text"id="location-txt">Jl. Jendral Sudirman No.1 Blok D17</span>
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="locationDropdown">
                                <li><a class="dropdown-item location-text" href="#">Jl. Jendral Sudirman No. 1 Blok
                                        D17</a></li>
                                <li><a class="dropdown-item location-text" href="#">Jl. Melati Raya No. 5</a></li>
                                <li><a class="dropdown-item location-text" href="#">Jl. Mawar Indah No. 12</a></li>
                                <li><a class="dropdown-item location-text" href="#">Jl. Kenanga No. 8</a></li>
                                <li><a class="dropdown-item location-text" href="#">Jl. Anggrek No. 3</a></li>
                            </ul>
                        </div>

                        <!-- Hidden input to hold selected value for form submission -->
                        <input type="hidden" name="selected-address" id="selected-location"
                            value="Jl. Jendral Sudirman No.1 Blok D17">
                    </div>
                    {{-- Search Container --}}
                    <div class="search-container col-sm">
                        <div class="search-wrapper search-style-1 d-flex align-items-center">
                            <form action="#" class="d-flex align-items-center w-100 h-100">
                                @csrf
                                <div class="input-group">
                                    <button type="submit" class="input-group-text bg-white border-end-0 p-0"
                                        style="border:none; background:transparent;" title="Search">
                                        <span class="material-symbols-outlined">search</span>
                                    </button>
                                    <input type="text" name="query"
                                        class="form-control border-start-0 input-text-style-1"
                                        placeholder="Search for food, drinks, etc."
                                        aria-label="Search for food, drinks, etc." required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Refine and Result Section --}}
        <section class="refine-result">
            <div class="container mb-4">
                <div class="row m-1 m-sm-0 refine-result-wrapper">
                    {{-- Filter Section --}}
                    <div class="col-lg-4 mb-4 filter-wrapper d-none d-lg-block">
                        <h4 class="mb-1">Filter</h4>
                        <form>
                            {{-- Price Range --}}
                            <div class="mb-4">
                                <label class="form-label label-filter">Price Range</label>
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="number" class="form-control" placeholder="Min" min="0"
                                            name="min_price">
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <span>to</span>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" placeholder="Max" min="0"
                                            name="max_price">
                                    </div>
                                </div>
                            </div>
                            {{-- Rating Filter --}}
                            <div class="mb-4">
                                <label class="form-label label-filter">Rating</label>
                                <div class="d-xl-flex gap-2">
                                    <div class="custom-rating-radio mb-1 mb-sm-0">
                                        <input class="form-check-input" type="radio" name="rating" id="rating4"
                                            value="4">
                                        <label class="form-check-label d-flex align-items-center justify-content-center"
                                            for="rating4">
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="ms-2">4+</span>
                                        </label>
                                    </div>
                                    <div class="custom-rating-radio">
                                        <input class="form-check-input" type="radio" name="rating" id="rating45"
                                            value="4.5">
                                        <label class="form-check-label d-flex align-items-center justify-content-center"
                                            for="rating45">
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star</span>
                                            <span class="material-symbols-outlined star-icon">star_half</span>
                                            <span class="ms-2">4.5+</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- Category Filter --}}
                            <div class="mb-4">
                                <label class="form-label label-filter">Category</label>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Indonesian"
                                                id="catIndo" name="category[]">
                                            <label class="form-check-label mt-1" for="catIndo">
                                                Indonesian
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Western"
                                                id="catWest" name="category[]">
                                            <label class="form-check-label mt-1" for="catWest">
                                                Western
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Asian"
                                                id="catAsian" name="category[]">
                                            <label class="form-check-label mt-1" for="catAsian">
                                                Asian
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Healthy"
                                                id="catHealthy" name="category[]">
                                            <label class="form-check-label mt-1" for="catHealthy">
                                                Healthy
                                            </label>
                                        </div>
                                    </div>
                                    {{-- Add more categories as needed --}}
                                </div>
                            </div>
                            {{-- Apply Button --}}
                            <div class="text-start">
                                <button type="submit" class="btn btn-orange">Apply Filter</button>
                            </div>
                        </form>
                    </div>

                    {{-- Filter Button for Mobile --}}
                    <button class="btn btn-orange d-lg-none w-100 mb-3 d-flex align-items-center" id="openFilterBtn"
                        type="button">
                        <span class="material-symbols-outlined me-1">tune</span> Filter
                    </button>

                    {{-- Sort and Results Section --}}
                    <div class="col-lg-8 p-0">
                        {{-- Sort Section --}}
                        <div class="mb-2 sort-slider">
                            <div class="d-flex align-items-center flex-wrap gap-2 ">
                                <h4 class="mb-0 d-none d-lg-block pe-3">Sort</h4>
                                <div class="custom-rating-radio">
                                    <input class="form-check-input" type="radio" name="sort" id="sortClosest" value="closest">
                                    <label class="form-check-label border d-flex align-items-center justify-content-center" for="sortClosest">
                                        <span class="material-symbols-outlined me-1 mb-lg-1 mb-0">location_on</span>
                                        Closest
                                    </label>
                                </div>
                                <div class="custom-rating-radio">
                                    <input class="form-check-input" type="radio" name="sort" id="sortCheapest" value="cheapest">
                                    <label class="form-check-label border d-flex align-items-center justify-content-center" for="sortCheapest">
                                        <span class="material-symbols-outlined me-1">attach_money</span>
                                        Cheapest
                                    </label>
                                </div>
                                <div class="custom-rating-radio">
                                    <input class="form-check-input" type="radio" name="sort" id="sortLatest" value="latest">
                                    <label class="form-check-label border d-flex align-items-center justify-content-center" for="sortLatest">
                                        <span class="material-symbols-outlined me-1">schedule</span>
                                        Latest
                                    </label>
                                </div>
                                <div class="custom-rating-radio">
                                    <input class="form-check-input" type="radio" name="sort" id="sortBestSeller" value="best_seller">
                                    <label class="form-check-label border d-flex align-items-center justify-content-center" for="sortBestSeller">
                                        <span class="material-symbols-outlined me-1">star</span>
                                        Best Seller
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="catering-results d-flex flex-wrap gap-3">
                            @for ($i = 0; $i < 2; $i++)
                            <a href="{{ url('/catering/1') }}" class="catering-card-link">
                                <div class="catering-card">
                                    <div class="catering-card-img-wrapper">
                                        <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="Catering Picture" class="catering-card-img">
                                    </div>
                                    <div class="catering-card-body d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="catering-city small text-muted">Jakarta</span>
                                            <button class="btn btn-light btn-fav p-1" title="Favorite" type="button" onclick="event.stopPropagation();">
                                                <span class="material-symbols-outlined icon-sm">favorite</span>
                                            </button>
                                        </div>
                                        <div class="card-details-wrapper">
                                            <span class="catering-name">Delicious Catering</span>
                                        </div>
                                        <div class="catering-slots mb-1">
                                            <span class="badge badge-breakfast">Breakfast</span>
                                            <span class="badge badge-lunch">Lunch</span>
                                            <span class="badge badge-dinner">Dinner</span>
                                        </div>
                                        <div class="catering-rating d-flex align-items-center">
                                            <span class="material-symbols-outlined star-icon me-1">star</span>
                                            <span class="fw-semibold">4.7</span>
                                            <span class="text-muted ms-1 small">(120 reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endfor
                            <a href="{{ url('/catering/1') }}" class="catering-card-link">
                                <div class="catering-card">
                                    <div class="catering-card-img-wrapper">
                                        <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="Catering Picture" class="catering-card-img">
                                    </div>
                                    <div class="catering-card-body d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="catering-city small text-muted">Jakarta</span>
                                            <button class="btn btn-light btn-fav p-1" title="Favorite" type="button" onclick="event.stopPropagation();">
                                                <span class="material-symbols-outlined icon-sm">favorite</span>
                                            </button>
                                        </div>
                                        <div class="card-details-wrapper">
                                            <span class="catering-name">Delicious Catering Lorem ipsum XYZ Duar</span>
                                        </div>
                                        <div class="catering-slots mb-1">
                                            <span class="badge bg-warning text-dark me-1">Breakfast</span>
                                            <span class="badge bg-success me-1">Lunch</span>
                                            <span class="badge bg-primary">Dinner</span>
                                        </div>
                                        <div class="catering-rating d-flex align-items-center">
                                            <span class="material-symbols-outlined star-icon me-1">star</span>
                                            <span class="fw-semibold">4.7</span>
                                            <span class="text-muted ms-1 small">(120 reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @for ($i = 0; $i < 2; $i++)
                            <a href="{{ url('/catering/1') }}" class="catering-card-link">
                                <div class="catering-card">
                                    <div class="catering-card-img-wrapper">
                                        <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="Catering Picture" class="catering-card-img">
                                    </div>
                                    <div class="catering-card-body d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="catering-city small text-muted">Jakarta</span>
                                            <button class="btn btn-light btn-fav p-1" title="Favorite" type="button" onclick="event.stopPropagation();">
                                                <span class="material-symbols-outlined icon-sm">favorite</span>
                                            </button>
                                        </div>
                                        <div class="card-details-wrapper">
                                            <span class="catering-name">Delicious Catering</span>
                                        </div>
                                        <div class="catering-slots mb-1">
                                            <span class="badge bg-warning text-dark me-1">Breakfast</span>
                                            <span class="badge bg-success me-1">Lunch</span>
                                            <span class="badge bg-primary">Dinner</span>
                                        </div>
                                        <div class="catering-rating d-flex align-items-center">
                                            <span class="material-symbols-outlined star-icon me-1">star</span>
                                            <span class="fw-semibold">4.7</span>
                                            <span class="text-muted ms-1 small">(120 reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endfor
                        </div>
                    </div>
            </div>
        </section>

        {{-- Filter Popup (hidden by default, visible on mobile when active) --}}
        <div class="filter-popup" id="filterPopup">
            <div class="filter-popup-content">
                <div class="row justify-content-between w-100">
                    <h4 class="w-auto ps-0">Filter</h4>
                    <button type="button" class="btn-close mb-3 ms-5 d-block" id="closeFilterBtn"
                        aria-label="Close"></button>
                </div>  
                <form>
                    {{-- Price Range --}}
                    <div class="mb-4">
                        <label class="form-label label-filter">Price Range</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Min" min="0"
                                    name="min_price">
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <span>to</span>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Max" min="0"
                                    name="max_price">
                            </div>
                        </div>
                    </div>
                    {{-- Rating Filter --}}
                    <div class="mb-4">
                        <label class="form-label label-filter">Rating</label>
                        <div class="d-sm-flex gap-2">
                            <div class="custom-rating-radio mb-1 mb-sm-0">
                                <input class="form-check-input" type="radio" name="rating" id="rating4"
                                    value="4">
                                <label class="form-check-label d-flex align-items-center justify-content-center"
                                    for="rating4">
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="ms-2">4+</span>
                                </label>
                            </div>
                            <div class="custom-rating-radio">
                                <input class="form-check-input" type="radio" name="rating" id="rating45"
                                    value="4.5">
                                <label class="form-check-label d-flex align-items-center justify-content-center"
                                    for="rating45">
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star</span>
                                    <span class="material-symbols-outlined star-icon">star_half</span>
                                    <span class="ms-2">4.5+</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Category Filter --}}
                    <div class="mb-4">
                        <label class="form-label label-filter">Category</label>
                        <div class="row row-cols-2">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Indonesian" id="catIndo"
                                        name="category[]">
                                    <label class="form-check-label mt-1" for="catIndo">
                                        Indonesian
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Western" id="catWest"
                                        name="category[]">
                                    <label class="form-check-label mt-1" for="catWest">
                                        Western
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Asian" id="catAsian"
                                        name="category[]">
                                    <label class="form-check-label mt-1" for="catAsian">
                                        Asian
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Healthy" id="catHealthy"
                                        name="category[]">
                                    <label class="form-check-label mt-1" for="catHealthy">
                                        Healthy
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-start">
                        <button type="submit" class="btn btn-orange w-100">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/searchCatering.js') }}"></script>p
@endsection
