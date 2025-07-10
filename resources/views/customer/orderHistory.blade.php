@extends('master')

@php
    use Carbon\Carbon;
    $tabs = [
        'all' => 'All',
        'active' => 'Active',
        'upcoming' => 'Upcoming',
        'cancelled' => 'Cancelled',
        'finished' => 'Finished',
    ];
@endphp

@section('title', 'EatWell | Orders History')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/orderHistory.css') }}">
@endsection

@section('content')
    <main>
        <div class="container mt-4">
            <section class="">
                <div class="row">
                    @foreach ($tabs as $key => $label)
                        <div class="{{$loop->first ? 'col-12' : 'col-6'}} col-md-2 mb-3 ps-0 pe-3">
                            <a href="{{ route('order-history', ['status' => $key]) }}"
                                class="btn filter-order {{ $status === $key ? 'active' : '' }}" style="width: 100%;">
                                <span class="tab-control-text">{{ $label }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
        {{-- TAB CONTROL --}}
        {{-- <section class="tab-control mb-3 mt-4">
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
        </section> --}}

        {{-- SEARCH ORDER --}}
        <section class="search-bar mb-3">
            <div class="container">
                <div class="search-container col-sm">
                    <div class="search-wrapper search-style-1 d-flex align-items-center">
                        <form action="{{ route('order-history') }}" method="GET"
                            class="d-flex align-items-center w-100 h-100">
                            @csrf
                            <div class="input-group">
                                <button type="submit" class="input-group-text search-button border-end-0 p-0"
                                    title="Search">
                                    <span class="material-symbols-outlined search-icon-1">search</span>
                                </button>
                                <input type="text" name="query" class="form-control border-start-0 input-text-style-1"
                                    placeholder="Search order by order ID or vendor name"
                                    aria-label="Search for food, drinks, etc." value="{{ request('query') }}">
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
                            @elseif ($status === 'upcoming')
                                You have no upcoming orders.
                            @else
                                You haven't ordered anything yet.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Manual Rate & Review Modal -->
        <div id="rateReviewModal" class="custom-modal-overlay" style="display:none;">
            <div class="custom-modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center pb-1">
                    <h5 class="modal-title">Rate & Review</h5>
                    <button type="button" class="btn-close" id="closeRateReviewModal" aria-label="Close">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="rating-icon-list-modal d-flex gap-1 mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="material-symbols-outlined star-icon-modal"
                                data-index="{{ $i }}">star</button>
                        @endfor
                    </div>
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Your Review</label>
                        <textarea class="form-control" id="reviewText" rows="3" placeholder="Write your comment here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" id="cancelRateReviewModal">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div id="successModal" class="custom-modal-overlay" style="display:none;">
            <div class="custom-modal-content text-center">
                <div class="modal-header d-flex justify-content-between align-items-center pb-1">
                    <h5 class="modal-title w-100">Thank You!</h5>
                    <button type="button" class="btn-close" id="closeSuccessModal" aria-label="Close">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <span class="material-symbols-outlined" style="font-size:48px;color:#ffc107;">star</span>
                    </div>
                    <div class="mb-2">
                        <strong>Your review has been submitted successfully.</strong>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-primary" id="okSuccessModal">OK</button>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/orderHistory.js') }}"></script>
@endsection
