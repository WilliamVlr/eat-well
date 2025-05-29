@extends('master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/manageAddress.css') }}">
@endsection

@section('content')
    <div class="address-container text-center">
        <div class="text-start mb-3">
            <i class="bi bi-arrow-left fs-4"></i>
        </div>

        <div class="divider"></div>
        <h4 class="section-title">Address Management</h4>
        <img src="https://img.icons8.com/ios-filled/100/000000/home--v1.png" alt="icon" width="60" class="my-3">

        <p class="text-muted small mb-4">Places where healthy foods will be delivered to. Have multiple places you wish
            food could be delivered? This page will help you to manage your multiple of your addresses.
        </p>

        <!-- Main Address Card -->
        <div class="main-address text-start mb-3">
            <span class="badge mb-2">Main Address</span>
            <div class="fw-semibold">dvn Alviano <span class="text-muted">| (+62) 861-1272-1289</span></div>
            <div class="fw-semibold mt-2">
                Rumah Talenta BCA, Loker A99982, Jl. Pakuan Nomor 3, Sumur Batu, Babakan Madang, Kabupaten Bogor, Jawa
                Barat, 16810
            </div>

            <div class="note-text mt-2">
                <strong>Notes:</strong><br>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam.
            </div>

            <div class="d-flex justify-content-end align-items-center mt-3 gap-4">
                <div class="action-icons d-flex gap-3">
                    <span><i class="bi bi-pencil"></i>✏️ Ubah</span>
                    <span class="text-muted"><i class="bi bi-trash"></i>🗑️ Hapus</span>
                </div>
                <div class="form-check form-switch toggle-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="toggleSwitch" checked>
                </div>
            </div>

        </div>

        <div class="add-address mt-3 text-start">
            <i class="bi bi-plus-lg me-1"></i>Tambah Alamat
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
@endsection
