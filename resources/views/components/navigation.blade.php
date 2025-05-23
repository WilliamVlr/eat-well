{{-- <nav class="navbar navbar-expand-lg" style="background-color: #052418;">
  <div class="container-fluid px-4">

    <div class="d-flex justify-content-between w-100 align-items-center">


      <!-- KIRI -->
      <div class="d-flex align-items-center">
        <!-- Logo -->
        <a class="nav-link me-3" href="">
          <img src="/asset/navigation/eatwellLogo.png" alt="logo" style="width: 10vh;">
        </a>

        <!-- Language Dropdown -->
        <div class="dropdown">
          <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 20px">
            EN
          </button>
          <ul class="dropdown-menu">
            <li><button class="dropdown-item" href="#">EN</button></li>
            <li><button class="dropdown-item" href="#">ID</button></li>
          </ul>
        </div>
      </div>

      <!-- TENGAH -->
      <ul class="navbar-nav mx-auto text-center">
        <li class="nav-item mx-3">
          <a class="nav-link text-white" href="#">Home</a>
        </li>
        <li class="nav-item mx-3">
          <a class="nav-link text-white" href="#">About Us</a>
        </li>
        <li class="nav-item mx-3">
          <a class="nav-link text-white" href="#">Contact Us</a>
        </li>
      </ul>

      <!-- KANAN -->
      <div style="padding: 0.5rem 1rem; border-radius: 0.25rem; margin-right: 2vw">
        <a class="nav-link p-0" href="#">
          <button type="button" class="btn btn-primary" style="width: 150%; border-radius: 20px; background-color:#F5A623; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); border:none">Log In</button>
        </a>
      </div>

    </div>

  </div>
</nav> --}}

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand me-auto" href="#">
            <img src="/asset/navigation/eatwellLogo.png" alt="logo" style="width: 10vh;">
        </a>

        <!-- Language Dropdown -->
        <div class="dropdown">

          <button id="languageToggle" class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 20px">
            EN
          </button>

          <ul class="dropdown-menu">
            <li><button class="dropdown-item" onclick="setLanguage('EN')">EN</button></li>
            <li><button class="dropdown-item" onclick="setLanguage('ID')">ID</button></li>
          </ul>
        </div>
        

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <img class="offcanvas-title" id="offcanvasNavbarLabel" src="/asset/navigation/eatwellLogo.png" alt="logo" style="width: 10vh;">
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

<script>
  function setLanguage(lang)
  {
    document.getElementById('languageToggle').textContent = lang;
  }
</script>
