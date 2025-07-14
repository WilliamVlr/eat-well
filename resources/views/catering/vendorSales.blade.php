@extends('components.vendor-nav')

@section('title', 'Penjualan')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@php
    use Carbon\Carbon;
@endphp

@section('content')
    {{-- TITLE --}}
    <section class="container mt-3">
        <h2 class="fw-bold text-center">{{ $vendor->name }}'s Sales</h2>
    </section>

    {{-- FILTER CONTAINER --}}
    <section class="container d-flex flex-row gap-2">
        <div>
            <a href="{{ route('sales.export', ['period' => request()->query('period', 'All')]) }}" class="btn btn-green">
                Export
            </a>
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Choose Period
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('sales.show', ['period' => 'All']) }}">All</a></li>
                @foreach ($periods as $quarter => $range)
                    <li><a class="dropdown-item"
                            href="{{ route('sales.show', ['period' => $quarter]) }}">{{ $quarter }}:
                            {{ Carbon::parse($range[0])->format('M') }} - {{ Carbon::parse($range[1])->format('M') }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- SALES TABLE --}}
    <div class="container">
        @include('catering.salesTable', [$orders, $totalSales, $periodText])
    </div>
@endsection
