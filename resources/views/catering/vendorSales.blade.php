@extends('components.vendor-nav')

@section('title', 'Penjualan')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catering/salesTable.css') }}">
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
    <section class="container d-flex flex-row flex-wrap justify-content-between align-items-end gap-2">
        <form action="{{ route('sales.show') }}" method="GET" class="d-flex flex-row flex-wrap gap-2 align-items-end">
            <div>
                <label for="startDate" class="form-label mb-0">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-control"
                    value="{{ request()->query('startDate') }}">
            </div>
            <div>
                <label for="endDate" class="form-label mb-0">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-control"
                    value="{{ request()->query('endDate') }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
        <div>
            <a href="{{ route('sales.export', ['startDate' => request()->query('startDate'), 'endDate' => request()->query('endDate')]) }}" class="btn btn-green">
                Export
            </a>
        </div>
    </section>

    {{-- SALES TABLE --}}
    <div class="container px-2 my-1 my-sm-3">
        @include('catering.salesTable', [$orders, $totalSales, $startDate, $endDate])
    </div>
@endsection
