<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>


<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="#">
                <img src="/asset/navigation/eatwellLogo.png" alt="logo" style="width: 6vh;">
            </a>

            <!-- Language Dropdown -->
            <div class="dropdown">

                <button id="languageToggle" class="btn btn-outline-light dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 20px">
                    EN
                </button>

                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" onclick="setLanguage('EN')">EN</button></li>
                    <li><button class="dropdown-item" onclick="setLanguage('ID')">ID</button></li>
                </ul>
            </div>


            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <img class="offcanvas-title" id="offcanvasNavbarLabel" src="/asset/navigation/eatwellLogo.png"
                        alt="logo" style="width: 10vh;">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" aria-current="page" href='homepage'>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="aboutUs">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="Contact">Contact</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div style="padding: 0.5rem 1rem; border-radius: 0.25rem; margin-right: 2vw">
                <a class="login-button p-0" href="#">
                    <button type="button" class="login_button">Log In</button>
                </a>
            </div>
            

            {{-- @auth
          <!-- Jika sudah login -->
          <div style="padding: 0.5rem 1rem; border-radius: 0.25rem; margin-right: 2vw">
            <a class="login-button p-0" href="{{ route('profile') }}">
              <button type="button" class="login_button">
                <i class="bi bi-gear-fill"></i> Profile
              </button>
            </a>
          </div>
        @else
          <!-- Jika belum login -->
          <div style="padding: 0.5rem 1rem; border-radius: 0.25rem; margin-right: 2vw">
            <a class="login-button p-0" href="{{ route('login') }}">
              <button type="button" class="login_button">Log In</button>
            </a>
          </div>
        @endauth --}}


            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>

    <div class="flex-grow-1">
        @yield('content')
    </div>

    <footer class="bg-dark text-white py-0">
        <div class="container text-center footer-page" style="margin-top: 10px; padding: 10px;">

            <div class="mb-2">
                <img src="{{ asset('asset/navigation/eatwellLogo.png') }}" alt="logo" style="width: 7vh;">
                <h5 class="mt-2 fw-semibold">EAT WELL</h5>
            </div>

            <div class="mb-0">
                <a href="/home" class="text-white mx-4 text-decoration-none">Home</a>
                <a href="/login" class="text-white mx-4 text-decoration-none">About Us</a>
                <a href="/catering" class="text-white mx-4 text-decoration-none">Contact</a>
            </div>

            <!-- Sosial Media -->
            <div class="mb-2">
                <a href="#" class="text-white mx-3 fs-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white mx-3 fs-4"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white mx-3 fs-4"><i class="bi bi-whatsapp"></i></a>
            </div>

            <!-- Copyright -->
            <div class="mb-1">
                <p class="text-white-50 mb-1">&copy; {{ date('Y') }} Eat Well. All rights reserved.</p>
            </div>

            <!-- Alamat -->
            <div>
                <p class="text-white-50 small" style="margin-bottom: 0px">
                    Jl. Pakuan No.3, Sumur Batu, Kec. Babakan Madang, Kabupaten Bogor, Jawa Barat 16810
                </p>
            </div>

        </div>
    </footer>

    @yield('scripts')
    <script src="{{ asset('js/navigation.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>
