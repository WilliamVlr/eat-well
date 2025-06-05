@extends('master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/customer/customerFirstPage.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_home"/>
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
@endsection


@section('content')
    <div class="position-fixed bg-black w-100 h-100 content opacity-50 disabled-area"></div>
    <div class="container-fluid content content-1 h-100">
        <div class="row align-items-center justify-content-center h-100 px-0 py-5">
            <div class="col-auto col-sm-10 col-md-9 z-3">
                <div class="card p-5 rounded-4">
                    <form>
                        <div class="row justify-content-center align-self-center py-3 gy-1">
                            <div class="col-auto mb-0 mt-0">
                                <span class="material-symbols-outlined">add_home</span>
                            </div>
                            <div class="w-100"></div>
                            <hr class="border border-black border-2 align-self-center w-50 my-0 opacity-100">    
                            <h2 class="h2 text-center account-setup-title p-2">Fill your main address to use EatWell</h2>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 gy-3 py-2">
                            <div class="col">
                                <label for="province" class="form-label">Province</label>
                                <select id="province" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>DKI Jakarta</option>
                                    <option>Jawa Barat</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="cityTown" class="form-label">City/Town</label>
                                <select id="cityTownn" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="district" class="form-label">District</label>
                                <select id="district" class="form-select">
                                <option selected>Choose...</option>
                                <option>...</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="municipalityVillage" class="form-label">Municipality/Village</label>
                                <select id="municipalityVillage" class="form-select">
                                <option selected>Choose...</option>
                                <option>...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row gy-3 py-2">
                            <div class="col-12 col-md-8">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="1234 Main St">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="zipCode" class="form-label">Zip Code</label>
                                <select id="zipCode" class="form-select">
                                <option selected>Choose...</option>
                                <option>...</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <input type="text" class="form-control" id="notes" placeholder="Blue fence, just jump over.">
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-between gy-3 py-2">
                            <div class="col-12 col-md-6">
                                <label for="recipientName" class="form-label">Recipient Name</label>
                                <input type="text" class="form-control" id="recipientName" placeholder="Davin">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="recipientTel" class="form-label">Recipient Phone Number</label>
                                <input type="tel" class="form-control" id="recipientTel" placeholder="0812-1239-3219">
                            </div>
                            <div class="col-12 col-md-4 align-self-center mx-auto mt-5">
                                <button type="submit" class="btn btn-success check-border" id='submit-button'>Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="{{ asset('js/customer/customerFirstPage.js') }}"></script>
@endsection