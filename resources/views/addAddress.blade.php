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
                <select id="provinsi" class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Provinsi</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select id="kota" class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kota</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select id="kecamatan" class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kecamatan</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select id="kelurahan" class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>Kelurahan</option>
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
                <input class="form-control form-control-sm" type="text" placeholder="Kode pos" aria-label=".form-control-sm example">
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

    <script>
        const API_KEY = '543d80b3b490190006f5a670ce47292b0ebe9a3da6a097a0efc32b87096de8e4';

        async function fetchData(url)
        {
            const res = await fetch(url);
            const data = await res.json();
            return data.value
        }

        // load provinsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', async() => {
            const provinsiSelect = document.getElementById('provinsi');
            const data = await fetchData(`https://api.binderbyte.com/wilayah/provinsi?api_key=${API_KEY}`);
            data.forEach(prov=>{
                provinsiSelect.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
            });
        });

        // Load Kota saat Provinsi dipilih
    document.getElementById('provinsi').addEventListener('change', async function() {
        const kotaSelect = document.getElementById('kota');
        kotaSelect.innerHTML = '<option selected>Kota</option>';
        const provID = this.value;
        const data = await fetchData(`https://api.binderbyte.com/wilayah/kabupaten?api_key=${API_KEY}&id_provinsi=${provID}`);
        data.forEach(kota => {
            kotaSelect.innerHTML += `<option value="${kota.id}">${kota.name}</option>`;
        });
    });

    // Load Kecamatan saat Kota dipilih
    document.getElementById('kota').addEventListener('change', async function() {
        const kecSelect = document.getElementById('kecamatan');
        kecSelect.innerHTML = '<option selected>Kecamatan</option>';
        const kotaID = this.value;
        const data = await fetchData(`https://api.binderbyte.com/wilayah/kecamatan?api_key=${API_KEY}&id_kabupaten=${kotaID}`);
        data.forEach(kec => {
            kecSelect.innerHTML += `<option value="${kec.id}">${kec.name}</option>`;
        });
    });

    // Load Kelurahan saat Kecamatan dipilih
    document.getElementById('kecamatan').addEventListener('change', async function() {
        const kelSelect = document.getElementById('kelurahan');
        kelSelect.innerHTML = '<option selected>Kelurahan</option>';
        const kecID = this.value;
        const data = await fetchData(`https://api.binderbyte.com/wilayah/kelurahan?api_key=${API_KEY}&id_kecamatan=${kecID}`);
        data.forEach(kel => {
            kelSelect.innerHTML += `<option value="${kel.id}">${kel.name}</option>`;
        });
    });
    </script>
@endsection
