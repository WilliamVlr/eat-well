@extends('master')

@section('title', 'Home')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
@endsection

@section('content')
    <div class="dark-bg mt-5 p-5">
        <div class="subscription-card">
            <div class="subscription-header">
                <div class="text-wrapper">My Subscription</div>
                <div class="view-all-wrapper">View All</div>
            </div>
            <div class="subscription-header-2">
                <div class="subscription-content">
                    <div class="head-wrapper-2">Active From</div>
                    <div class="sub-frame">
                        <div class="content-wrapper-3">DD/MM/YYYY</div>
                    </div>
                </div>
                <div class="subscription-content">
                    <div class="head-wrapper-2">Active Until</div>
                    <div class="sub-frame">
                        <div class="content-wrapper-3">DD/MM/YYYY</div>
                    </div>
                </div>
            </div>
            <div class="subscription-header-3">
                <div class="subscription-content">
                    <div class="head-wrapper-2">Nama Penerima</div>
                    <div class="sub-frame">
                        <div class="content-wrapper-3">Adit Tolongin Dit</div>
                    </div>
                </div>
                <div class="subscription-content-2">
                    <div class="head-wrapper-2">Alamat Pengiriman</div>
                    <div class="sub-frame">
                        <div class="content-wrapper-3">Jl. Pegangsaan Timur No. 56, Jakarta</div>
                    </div>
                </div>
            </div>
            <div class="subscription-header-2">
                <div class="subscription-content-2">
                    <div class="catering-name">Catering XYZ Lorem</div>
                </div>
            </div>
            <div class="order-details">
                <div class="time-slot-container">
                    <div class="header">
                        <div class="text-wrapper-5">Breakfast</div>
                        <div class="text-frame">
                            <div class="text-wrapper-6">Preparing</div>
                        </div>
                    </div>
                    <div class="paket-list-container">
                        <div class="paket-container">
                            <div class="text-wrapper-7">Paket Lorem Ipsum Dolor</div>
                            <div class="text-wrapper-8">10x</div>
                        </div>
                    </div>
                </div>
                <div class="time-slot-container-2">
                    <div class="header">
                        <div class="text-wrapper-5">Lunch</div>
                        <div class="text-frame">
                            <div class="text-wrapper-6">Preparing</div>
                        </div>
                    </div>
                    <div class="paket-list-container-2">
                        <div class="paket-container">
                            <p class="text-wrapper-7">Paket Dolor Amet Situ Mang</p>
                            <div class="text-wrapper-8">2x</div>
                        </div>
                        <div class="paket-container">
                            <p class="text-wrapper-7">Paket Cing Cong Fan Amet Lorem Ipsum</p>
                            <div class="text-wrapper-9">1x</div>
                        </div>
                    </div>
                </div>
                <div class="time-slot-container-2">
                    <div class="header">
                        <div class="text-wrapper-5">Dinner</div>
                        <div class="text-frame">
                            <div class="text-wrapper-6">Preparing</div>
                        </div>
                    </div>
                    <div class="paket-list-container">
                        <div class="paket-container">
                            <p class="text-wrapper-7">Paket Amet Dolorosa Situtu Puranang</p>
                            <div class="text-wrapper-9">3x</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
