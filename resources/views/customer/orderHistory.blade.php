@extends('master')

@section('title', 'EatWell | Orders History')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{asset('css/customer/orderHistory.css')}}">
@endsection

@section('content')
    <main>
        <section class="order-history">
            <div class="container mb-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="custom-rating-radio">
                        <input type="radio" class="form-check-input" name="tabControlHistory" id="allHistory" value="all">
                        <label for="allOrders" class="form-check-label border d-flex align-items-center justify-content-center">
                            All
                        </label>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    
@endsection