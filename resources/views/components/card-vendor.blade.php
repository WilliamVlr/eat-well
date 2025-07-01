@php
    $isFavorited = auth()->check() && $vendor->favoriteVendors->contains(auth()->id());
@endphp
<a href="{{ route('catering-detail', $vendor->vendorId) }}" class="catering-card-link">
    <div class="catering-card">
        <div class="catering-card-img-wrapper">
            {{-- <img src="{{ $vendor->logo ? asset($vendor->logo) : asset('asset/customer/home/Iklan 2.jpg') }}"
                                                alt="Catering Picture" class="catering-card-img"> --}}
            <img src="{{ asset('asset/customer/home/Iklan 2.jpg') }}" alt="Catering Picture" class="catering-card-img">
        </div>
        <div class="catering-card-body d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <span class="catering-city small text-muted">{{ $vendor->kota ?? '-' }}</span>

                <button class="btn btn-light btn-fav {{ $isFavorited ? 'favorited' : '' }} p-1" title="Favorite"
                    type="button" data-vendor-id="{{ $vendor->vendorId }}" onclick="event.stopPropagation();">
                    <span class="material-symbols-outlined icon-sm">favorite</span>
                </button>
            </div>
            <div class="card-details-wrapper">
                <span class="catering-name">{{ $vendor->name }}</span>
            </div>
            <div class="catering-slots mb-1">
                @if ($vendor->breakfast_delivery ?? false)
                    <span class="badge badge-breakfast">Breakfast</span>
                @endif
                @if ($vendor->lunch_delivery ?? false)
                    <span class="badge badge-lunch">Lunch</span>
                @endif
                @if ($vendor->dinner_delivery ?? false)
                    <span class="badge badge-dinner">Dinner</span>
                @endif
            </div>
            <div class="catering-rating d-flex align-items-center">
                <span class="material-symbols-outlined star-icon me-1">star</span>
                <span class="fw-semibold">{{ $vendor->rating ?? '-' }}</span>
            </div>
        </div>
    </div>
</a>