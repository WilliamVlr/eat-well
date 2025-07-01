@extends('master')

@php
    use Carbon\Carbon;
    $tabs = [
        'all' => 'All',
        'active' => 'Active',
        'finished' => 'Finished',
        'cancelled' => 'Cancelled',
    ];
@endphp

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
        <section class="tab-control mb-3 mt-4">
            <div class="container">
                <div class="row tab-control-wrapper">
                    @foreach ($tabs as $key => $label)
                        <a href="{{ route('order-history', ['status' => $key]) }}"
                            class="col-3 d-flex text-center justify-content-center align-items-center tab-control-text-wrapper {{ $status === $key ? 'active' : '' }}">
                            <span class="tab-control-text">{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SEARCH ORDER --}}
        <section class="search-bar mb-3">
            <div class="container">
                <div class="search-container col-sm">
                    <div class="search-wrapper search-style-1 d-flex align-items-center">
                        <form action="{{route('order-history')}}" method="GET" class="d-flex align-items-center w-100 h-100">
                            @csrf
                            <div class="input-group">
                                <button type="submit" class="input-group-text search-button border-end-0 p-0"
                                    title="Search">
                                    <span class="material-symbols-outlined search-icon-1">search</span>
                                </button>
                                <input type="text" name="query" class="form-control border-start-0 input-text-style-1"
                                    placeholder="Search order by order ID or vendor name" aria-label="Search for food, drinks, etc."
                                    value="{{request('query')}}">
                                <input type="hidden" name="status" value="{{ $status }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        {{-- ORDER LIST --}}
        <section class="order-list mb-4">
            <div class="container d-flex flex-column gap-3">
                @forelse ($orders as $order)
                    <x-card-order :order="$order"></x-card-order>
                @empty
                    <div class="empty-order text-center py-5">
                        <img src="{{ asset('asset/empty-order.png') }}" alt="No Orders" style="max-width:150px;">
                        <h5 class="mt-3">No orders found</h5>
                        <p class="text-muted">
                            @if ($status === 'active')
                                You have no active orders.
                            @elseif ($status === 'finished')
                                You have no finished orders.
                            @elseif ($status === 'cancelled')
                                You have no cancelled orders.
                            @else
                                You haven't ordered anything yet.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/orderHistory.js') }}"></script>
@endsection
