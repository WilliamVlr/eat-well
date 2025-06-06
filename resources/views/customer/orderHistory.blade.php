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
                    <div class="card-order">
                        <div class="card-header">
                            <div class="left-container">
                                <div class="text-wrapper vendor-name-wrapper">
                                    <h5 class="">{{ $order->vendor->name }}</h5>
                                </div>
                                <button onclick="" class="text-wrapper btn-view">
                                    <p>View Catering</p>
                                </button>
                            </div>
                            <div class="right-container">
                                <div class="text-wrapper order-date">
                                    <p class="date">{{ Carbon::parse($order->startDate)->format('d/m/Y') }}</p>
                                    <p class="date">-</p>
                                    <p class="date">{{ Carbon::parse($order->endDate)->format('d/m/Y') }}</p>
                                </div>
                                @if ($order->isCancelled == 1)
                                    <div class="text-wrapper label-status status-cancelled">
                                        Cancelled
                                    </div>
                                @elseif (Carbon::now()->between(Carbon::parse($order->startDate), Carbon::parse($order->endDate)))
                                    <div class="text-wrapper label-status status-active">
                                        Active
                                    </div>
                                @else
                                    <div class="text-wrapper label-status status-finished">
                                        Finished
                                    </div>
                                @endif
                            </div>
                        </div>


                        <a href="#" class="card-content-wrapper text-decoration-none">
                            @foreach ($order->orderItems as $item)
                                <div class="card-content">
                                    <div class="image-wrapper">
                                        {{-- <img src="{{$item->package->imgPath ? asset($item->package->imgPath) : asset('asset/catering-detail/logo-packages.png')}}" alt="Gambar Paket"> --}}
                                        <img src="{{ asset('asset/catering-detail/logo-packages.png') }}"
                                            alt="gambar paket">
                                    </div>
                                    <div class="right-container">
                                        <div class="package-detail">
                                            <div class="text-container detail-primary">{{ $item->package->name }}</div>
                                            <div class="text-container d-flex flex-row flex-md-column column-gap-2">
                                                <div class="text-wrapper detail-secondary">
                                                    Variant: {{ $item->packageTimeSlot }}
                                                </div>
                                                <div class="text-wrapper detail-secondary">
                                                    x{{ $item->quantity }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price-wrapper">
                                            <div class="text-wrapper">
                                                <p>
                                                    Rp {{ number_format($item->price, 2, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                                    <span class="detail-primary">Total {{ count($order->orderItems) }} packages: </span>
                                    <span class="detail-highlight">Rp
                                        {{ number_format($order->totalPrice, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
