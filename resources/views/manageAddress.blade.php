@extends('master')

@section('css')
    {{-- <meta name="vendor-id" content="{{ $vendor->vendorId }}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/manageAddress.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
@endsection

@section('content')
    <div class="address-container text-center">
        <div class="text-start mb-3">
            <a href="/manage-profile" style="text-decoration: none; color: black">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
        </div>

        <div class="divider"></div>
        <h4 class="section-title">Address Management</h4>
        <img src="https://img.icons8.com/ios-filled/100/000000/home--v1.png" alt="icon" width="60" class="my-3">

        <p class="text-muted small mb-4">Places where healthy foods will be delivered to. Have multiple places you wish
            food could be delivered? This page will help you to manage your multiple of your addresses.
        </p>

        <!-- Main Address Card -->
        @foreach ($user->addresses as $address)
            <div class="main-address text-start mb-3">
                @if ($address->is_default)
                    <span class="badge mb-2" style="background-color: #D96323;">Main Address</span>
                @else
                    <span class="badge mb-2" style="background-color: #909090;">Main Address</span>
                @endif
                <div class="fw-semibold">{{ $address->recipient_name }} <span class="text-muted">|
                        {{ $address->recipient_phone }}</span></div>
                <div class="fw-semibold mt-2 detail-alamat">
                    {{ $address->jalan }}, {{ $address->kelurahan }}, {{ $address->kecamatan }}, {{ $address->kota }},
                    {{ $address->provinsi }}, {{ $address->kode_pos }}
                </div>

                @if ($address->notes)
                    <div class="note-text mt-2 detail-note">
                        <strong>Notes:</strong><br>
                        {{ $address->notes }}
                    </div>
                @endif

                <div class="d-flex justify-content-end align-items-center mt-3 gap-4">
                    <div class="action-icons d-flex gap-3">
                        <a href="{{ route('add-address') }}">
                            <button type="button" class="btn btn-primary"
                                style="background-color: #185640; border-color: #185640;">✏️ Ubah</button>
                        </a>
                        <button type="button" class="btn btn-danger">🗑️ Hapus</button>
                    </div>

                    <div class="form-check form-switch toggle-switch">
                        <input class="form-check-input set-default-address" type="checkbox" role="switch"
                            data-address-id="{{ $address->addressId }}" {{ $address->is_default ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        @endforeach

        <form id="set-default-address-url-form" action="{{ route('set-default-address') }}" method="POST"
            style="display:none;">
            @csrf
        </form>

        <div class="add-address mt-3 text-start">
            <button class="button-tambah-alamat" style="border: none; background-color: transparent">
                <a href="{{ route('add-address') }}" style="text-decoration: none; color: black">+ Tambah Alamat</a>
            </button>
        </div>
    </div>

    {{-- Modal untuk Sukses --}}
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Berhasil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Alamat utama berhasil diubah.</p>
                    <i class="material-symbols-outlined text-success" style="font-size: 50px;">check_circle</i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Error/Peringatan (ketika user mencoba menonaktifkan alamat utama) --}}
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Peringatan!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="warningMessage">Alamat utama tidak bisa dinonaktifkan langsung. Pilih alamat lain sebagai utama
                        terlebih dahulu.</p>
                    <i class="material-symbols-outlined text-warning" style="font-size: 50px;">warning</i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: orange; border-color: orange;">Oke</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Error Umum (dari AJAX error) --}}
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Terjadi Kesalahan!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="errorMessage">Terjadi kesalahan saat menghubungi server.</p>
                    <i class="material-symbols-outlined text-danger" style="font-size: 50px;">error</i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/customer/manageAddress.js') }}"></script>
@endsection
