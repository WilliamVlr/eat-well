@extends('master')

@section('title', 'EatWell | Order Detail')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/orderHistory.css') }}">
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
                <section class="card-content">

                </section>
            </div>
        </div>
    </main>
@endsection

@section('scripts')

@endsection
