@extends('master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/addAddress.css') }}">
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

        <div class="row justify-content-center mb-4">
            <div class="col-sm-3">
                <select class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Provinsi</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kota</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kecamatan</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kelurahan</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-sm-9">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="text" placeholder="Alamat" aria-label=".form-control-sm example">
                </div>
            </div>
            <div class="col-sm-3">
                <select class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kode Pos</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>

        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-sm-12">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="text" placeholder="Catatan" aria-label=".form-control-sm example">
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-sm-3">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="text" placeholder="Nama Penerima" aria-label=".form-control-sm example">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="text" placeholder="Nomor telpon" aria-label=".form-control-sm example">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="mb-3">
                    <button type="button" class="btn btn-success btn-sm" style="width: 140px"><a href="manage-address" style="text-decoration: none; color:white">Save</a></button>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="mb-3">
                    <button type="button" class="btn btn-danger btn-sm" style="width: 140px"><a href="manage-address" style="text-decoration: none; color:white">Cancel</a></button>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
@endsection
