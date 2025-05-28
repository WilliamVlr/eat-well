@extends('master')

@section('title', 'Home')

@section('css')
    @vite(["resources/js/app.js", "resources/sass/app.scss"])
    <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
@endsection

@section('content')
    <div class="dark-bg mt-5 p-5">
        <div class="subscription-card">
            <div class="subscription-header">
                <div class="text-wrapper">My Subscription</div>
                <div class="div">View All</div>
            </div>
            <div class="subscription-header-2">
                <div class="subscription-content">
                <div class="text-wrapper-2">Active From</div>
                <div class="date-frame"><div class="text-wrapper-3">DD/MM/YYYY</div></div>
                </div>
                <div class="subscription-content">
                <div class="text-wrapper-2">Active Until</div>
                <div class="date-frame"><div class="text-wrapper-3">DD/MM/YYYY</div></div>
                </div>
            </div>
            <div class="subscription-header-3">
                <div class="subscription-content">
                <div class="text-wrapper-2">Nama Penerima</div>
                <div class="date-frame"><div class="text-wrapper-3">Adit Tolongin Dit</div></div>
                </div>
                <div class="subscription-content-2">
                <div class="text-wrapper-2">Alamat Pengiriman</div>
                <div class="date-frame"><p class="p">Jl. Pegangsaan Timur No. 56, Jakarta</p></div>
                </div>
            </div>
            <div class="subscription-header-2">
                <div class="subscription-content-2"><div class="text-wrapper-4">Catering XYZ Lorem</div></div>
            </div>
            <div class="frame">
                <div class="subscription-content-wrapper">
                <div class="subscription-content-2">
                    <div class="text-wrapper-5">Breakfast</div>
                    <div class="paket-n-qty">
                    <div class="paket">
                        <div class="text-wrapper-6">Paket A</div>
                        <div class="text-wrapper-7">Paket B</div>
                    </div>
                    <div class="paket-2">
                        <div class="text-wrapper-8">1x</div>
                        <div class="text-wrapper-9">1x</div>
                    </div>
                    </div>
                    <div class="paket-wrapper">
                    <div class="div-wrapper"><div class="text-wrapper-10">Preparing</div></div>
                    </div>
                </div>
                </div>
                <div class="subscription-content-wrapper">
                <div class="subscription-content-2">
                    <div class="text-wrapper-5">Lunch</div>
                    <div class="paket-n-qty">
                    <div class="paket"><div class="text-wrapper-6">Paket A</div></div>
                    <div class="paket-2"><div class="text-wrapper-8">1x</div></div>
                    </div>
                </div>
                </div>
                <div class="subscription-content-wrapper">
                <div class="subscription-content-2">
                    <div class="text-wrapper-5">Dinner</div>
                    <div class="paket-n-qty">
                    <div class="paket"><div class="text-wrapper-6">Paket B</div></div>
                    <div class="paket-2"><div class="text-wrapper-8">3x</div></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection