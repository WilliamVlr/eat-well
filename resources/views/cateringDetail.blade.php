xa<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catering Detail</title>
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/cateringDetail.css') }}">
    {{-- bootstrap --}}
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    {{-- Lexend & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    {{-- Icon call, location, star --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=call,pin_drop,star" />
    
</head>
<body>
    <div class="profile-container">
        <div class="container daun-container">
            <img src="{{ asset('asset/catering-detail/daun1.png') }}" alt="Catering Image" class="daun1">
            <img src="{{ asset('asset/catering-detail/daun2.png') }}" alt="Catering Image" class="daun2">
            <div class="container all-profile-wrapper">
                <div class="catering-info-left-wrapper">
                    <h1 class="lexend">Aldenaire Catering</h1>

                    <div class="phone-number-and-schedule-wrapper">
                        <div class="phone-number-container">
                            <span class="material-symbols-outlined call-icon">call</span>
                            <span class="inter phone-number">+62 812 3456 7890</span>
                        </div>
                        <div class="schedule-container">
                            <span class="inter schedule">Monday - Sunday</span>
                        </div>
                    </div>

                    <div class="location-wrapper">
                        <span class="material-symbols-outlined location-icon">pin_drop</span>
                        <span class="inter address">Jl. Pakuan No.3, Sumur Batu, Kec. Babakan Madang, Kabupaten Bogor, Jawa Barat 16810</span>
                    </div>

                    <div class="rating-and-number-sold-wrapper">
                        <div class="rating-container">
                            <span class="material-symbols-outlined star-icon">star</span>
                            <span class="inter rating-and-sold">4.5</span>
                        </div>
                        <div class="number-sold-container">
                            <span class="inter rating-and-sold">10k+</span>
                            <span class="inter sold-text">sold</span>
                        </div>
                    </div>
                </div>

                <div class="catering-info-right-wrapper">
                    <div class="hijau-luar">
                        <div class="cokelat-lingkaran">
                            <div>
                                <img src="{{ asset('asset/catering-detail/logo-aldenaire-catering.jpg') }}" alt="Catering Image" class="logo-catering">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="food-preview-container">
        <h1 class="lexend">From Our Kitchen to Your Table</h1>

        <div class="carousel-wrapper">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('asset/catering-detail/food preview 1.jpeg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('asset/catering-detail/food preview 2.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('asset/catering-detail/food preview 3.jpeg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('asset/catering-detail/food preview 4.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    </div>
            </div>
        </div>
    </div>

    <div class="price-and-shipping-container">
        <div class="weekly-price-wrapper">
            <h1 class="lexend">Weekly Price</h1>
            <div class="price-container">
                <div class="price-bulet">
                    <h1 class="lexend">625k</h1>
                </div>
                <div class="price-kanan">
                    <div class="dropdown">
                        <button id="dropdownMenuButton" class="btn btn-secondary dropdown-toggle inter" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Package A
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item inter">Package A</li>
                            <li class="dropdown-item inter">Package B</li>
                            <li class="dropdown-item inter">Package C</li>
                        </ul>
                    </div>

                    <!-- Hidden input to hold selected value for form submission -->
                    <input type="hidden" name="selected_package" id="selectedPackage" value="Package A">
                    
                    <ul class="list-group inter">
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" id="firstCheckboxStretched" checked>
                            <label class="form-check-label stretched-link" for="firstCheckboxStretched">Breakfast</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" id="secondCheckboxStretched" checked>
                            <label class="form-check-label stretched-link" for="secondCheckboxStretched">Lunch</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckboxStretched" checked>
                            <label class="form-check-label stretched-link" for="thirdCheckboxStretched">Dinner</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="shipping-wrapper">
            <h1 class="lexend">Shipping Time</h1>
            <div class="section-makan">
                <h3 class="inter">Breakfast</h3>
                <p class="inter">07.00 AM - 09.00 AM</p>
            </div>
            <div class="section-makan">
                <h3 class="inter">Lunch</h3>
                <p class="inter">11.00 AM - 13.00 PM</p>
            </div>
            <div class="section-makan">
                <h3 class="inter">Dinner</h3>
                <p class="inter">05.00 PM - 07.00 PM</p>
            </div>
        </div>
    </div>

    <div class="packages-container">
        <h1 class="lexend">Our Packages</h1>

        <div class="aaccordionn-wrapper">

        </div>
    </div>
</body>
<script src="{{ asset('js/cateringDetail.js') }}"></script>
</html>