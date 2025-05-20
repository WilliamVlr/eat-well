<!DOCTYPE html>
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
                    <h1 class="lexend">Aldenaire</h1>
                    <h1 class="lexend">Catering</h1>

                    <div class="phone-number-and-schedule-wrapper">
                        <div class="phone-number-container">
                            <span class="material-symbols-outlined">call</span>
                            <span class="inter phone-number">+62 812 3456 7890</span>
                        </div>
                        <div class="schedule-container">
                            <span class="inter schedule">Monday - Sunday</span>
                        </div>
                    </div>

                    <div class="location-wrapper">
                        <span class="material-symbols-outlined location-icon">pin_drop</span>
                        <span class="inter address">Jl. Pakuan No.3, Sumur Batu, Kec. Babakan Madang,<br>Kabupaten Bogor, Jawa Barat 16810</span>
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

    </div>
</body>
<script></script>
</html>