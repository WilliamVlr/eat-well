@extends('master')

@section('title', 'EatWell | Favorited')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/cardVendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/favoritePage.css') }}">
@endsection

@section('content')
    <section class="container d-flex flex-row justify-content-center my-3">
        <h1 class="text-center">Your Favorite Vendors</h1>
    </section>
    <section class="container mb-3 fav-vendor-container">
        <div class="row">
            @foreach ($vendors as $vendor)
                <div class="col-md-6 col-xl-4 p-2">
                    <x-card-vendor :vendor="$vendor"></x-card-vendor>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/favoriteCatering.js') }}"></script>
@endsection
