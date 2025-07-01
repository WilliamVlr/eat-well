@extends('master')

@section('title', 'Penjualan')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
@endsection

@section('content')
    @include('penjualanTable', [$orders, $totalSales])
@endsection
