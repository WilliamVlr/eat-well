<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rating & Review</title>
    <link rel="stylesheet" href="{{ asset('css/ratingAndReview.css') }}">
    {{-- bootstrap --}}
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    {{-- Lexend & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    {{-- google font --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1" rel="stylesheet" />
</head>
<body>
    <div class="container all-container">
        <div class="title-and-num-sold">
            <div class="back-and-cate-name-wrapper">
                <a href="{{ route("catering-detail") }}">
                    <span class="material-symbols-outlined back-icon">arrow_circle_left</span>
                </a>
                <h1 class="lexend judul-gede">Aldenaire Catering's Review</h1>
            </div>
            <h5 class="num-sold inter">10k+ sold</h5>
        </div>
        <div class="review-card-container">
            <div class="review-card-wrapper">
                <div class="profile-rating-wrapper">
                    <div class="profile-wrapper">
                        <div class="profile">
                            <img src="{{ asset('asset/rating-page/user-profile.jpg') }}" alt="Catering Image" class="profile-user">
                        </div>
                        <h5 class="username inter">m******</h5>
                    </div>
                    <div class="rating-wrapper">
                        <span class="material-symbols-outlined star-icon">star</span>
                        <span class="inter rating">4</span>
                    </div>
                </div>
                <div class="review-wrapper inter">
                    <p>
                        A delicious selection of meat-free dishes made with fresh vegetables, tofu, tempeh, and plant-based ingredients. Perfect for guests following a healthy or vegetarian lifestyle.
                    </p>
                </div>
                <div class="order-label">
                    <p class="inter">Ordered on 27th May 2025</p>
                </div>
            </div>

            @for ($i = 1; $i <= 10; $i++)
                {{-- <p>Perulangan ke-{{ $i }}</p> --}}
                <div class="review-card-wrapper">
                    <div class="profile-rating-wrapper">
                        <div class="profile-wrapper">
                            <div class="profile">
                                <img src="{{ asset('asset/rating-page/user-profile.jpg') }}" alt="Catering Image" class="profile-user">
                            </div>
                            <h5 class="username inter">m******</h5>
                        </div>
                        <div class="rating-wrapper">
                            <span class="material-symbols-outlined star-icon">star</span>
                            <span class="inter rating">4</span>
                        </div>
                    </div>
                    <div class="review-wrapper inter">
                        <p>
                            A delicious selection of meat-free dishes made with fresh vegetables, tofu, tempeh, and plant-based ingredients. Perfect for guests following a healthy or vegetarian lifestyle. A delicious selection of meat-free dishes made with fresh vegetables, tofu, tempeh, and plant-based ingredients. Perfect for guests following a healthy or vegetarian lifestyle.
                        </p>
                    </div>
                    <div class="order-label">
                        <p class="inter">Ordered on 27th May 2025</p>
                    </div>
                </div>
            @endfor

        </div>
    </div>

    <x-footer></x-footer>
</body>
</html>