@extends('master')

@section('title', 'EatWell | Orders History')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/orderHistory.css') }}">
@endsection

@section('content')
    <main>
        {{-- TAB CONTROL --}}
        <section class="tab-control mb-3 mt-1">
            <div class="container">
                <div class="row tab-control-wrapper">
                    <a href=""
                        class="col-3 d-flex text-center justify-content-center align-items-center tab-control-text-wrapper active">
                        <span class="tab-control-text">All</span>
                    </a>
                    <a href=""
                        class="col-3 d-flex text-center justify-content-center align-items-center tab-control-text-wrapper">
                        <span class="tab-control-text">Active</span>
                    </a>
                    <a href=""
                        class="col-3 d-flex text-center justify-content-center align-items-center tab-control-text-wrapper">
                        <span class="tab-control-text">Finished</span>
                    </a>
                    <a href=""
                        class="col-3 d-flex text-center justify-content-center align-items-center tab-control-text-wrapper">
                        <span class="tab-control-text">Cancelled</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- SEARCH ORDER --}}
        <section class="search-bar mb-3">
            <div class="container">
                <div class="search-container col-sm">
                    <div class="search-wrapper search-style-1 d-flex align-items-center">
                        <form action="#" class="d-flex align-items-center w-100 h-100">
                            @csrf
                            <div class="input-group">
                                <button type="submit" class="input-group-text search-button border-end-0 p-0"
                                    title="Search">
                                    <span class="material-symbols-outlined search-icon-1">search</span>
                                </button>
                                <input type="text" name="query" class="form-control border-start-0 input-text-style-1"
                                    placeholder="Search for food, drinks, etc." aria-label="Search for food, drinks, etc."
                                    required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        {{-- ORDER LIST --}}
        <section class="order-list mb-3">
            <div class="container d-flex flex-column gap-3">
                <div class="card-order text-decoration-none">
                    <div class="card-header">
                        <div class="left-container">
                            <div class="text-wrapper vendor-name-wrapper">
                                <h5 class="">Catering Name Here HEHEHE</h5>
                            </div>
                            <button onclick="" class="text-wrapper btn-view">
                                <p>View Catering</p>
                            </button>
                        </div>
                        <div class="right-container">
                            <div class="text-wrapper order-date">
                                <p class="date">19/06/2025</p>
                                <p class="date">-</p>
                                <p class="date">19/07/2025</p>
                            </div>
                            <div class="text-wrapper label-status status-active">
                                Active
                            </div>
                        </div>
                    </div>
                    <a href="#" class="card-content-wrapper">
                        <div class="card-content">
                            <div class="image-wrapper">
                                <img src="{{ asset('asset/catering-detail/logo-packages.png') }}" alt="gambar paket">
                            </div>
                            <div class="right-container">
                                <div class="package-detail">
                                    <div class="text-container detail-primary">Paket Catering ABCXYZ</div>
                                    <div class="text-container d-flex flex-row flex-md-column column-gap-2">
                                        <div class="text-wrapper detail-secondary">
                                            Variant: Breakfast
                                        </div>
                                        <div class="text-wrapper detail-secondary">
                                            x2
                                        </div>
                                    </div>
                                </div>
                                <div class="price-wrapper">
                                    <div class="text-wrapper">
                                        <p>
                                            Rp 50.000
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="image-wrapper">
                                <img src="{{ asset('asset/catering-detail/logo-packages.png') }}" alt="gambar paket">
                            </div>
                            <div class="right-container">
                                <div class="package-detail">
                                    <div class="text-container detail-primary">Paket Catering ABCXYZ LOREM IPSUM DOLOR SIT
                                        AMET</div>
                                    <div class="text-container d-flex w-100 flex-row flex-md-column column-gap-2">
                                        <div class="text-wrapper detail-secondary">
                                            Variant: Breakfast
                                        </div>
                                        <div class="text-wrapper detail-secondary">
                                            x2
                                        </div>
                                    </div>
                                    {{-- <div class="text-container detail-secondary">x2</div> --}}
                                </div>
                                <div class="price-wrapper">
                                    <div class="text-wrapper">
                                        <p>
                                            Rp 50.000
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="card-bottom">
                        <div class="left-container">
                            <div class="rating-container">
                                <span class="detail-primary">Rate this catering</span>
                                <div class="rating-icon-list">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" class="material-symbols-outlined star-icon"
                                            data-index="{{ $i }}">star</button>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="right-container">
                            <div class="total-container">
                                <span class="detail-primary">Total 2 packages: </span>
                                <span class="detail-highlight">Rp 128.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{asset('js/customer/orderHistory.js')}}"></script>
@endsection
