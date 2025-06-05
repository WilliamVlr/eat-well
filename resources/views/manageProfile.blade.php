<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/manageProfile.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
    {{-- <x-navigation></x-navigation> --}}
    <div class="container">
        <div class="left-panel outer-panel">
            <div class="lexend font-medium manage-profile">
                <div class="left-panel-in photo-prof">    
                    <img src="{{asset('asset/profile/profil.jpg')}}" alt="Profile Picture" class="profile-picture">
                </div>
                <div class="right-panel-in data-prof">
                    <p class="profile-name text-white lexend font-regular">John Doe</p>
                    <p class="profile-status lexend font-bold">Healthy Customer<p>
                    <p class="joined-date text-white lexend font-regular">
                        Joined Since: <span class="date">05/27/2025</span>
                    </p>
                </div>
            <hr style="height: 1.5px; background-color:rgb(121, 13, 13); opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">
            </div>
            <div class="menu">
                <ul class="nav flex-column sidebar-menu">
                    <li class="nav-item">
                        <a class="menu-link active inter font-regular text-white">Manage Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu-link inter font-regular text-white">Manage Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu-link inter font-regular text-white">Manage Address</a>
                    </li>
                </ul>
            </div>
        </div>
            
        
        <div class="right-panel outer-panel">
            <div class="lexend font-medium outer-box">
                <div class="profile-manage">
                    <p class="lexend font-medium text-black title">Personal Profile</p>
                    <p class="inter font-regular text-black description">This is your profile page. Looking healthy as ever! Manage your account profile here.</p>
                </div>
                <hr style="height: 1.5px; background-color:black; opacity:100%; border: none; margin-left: 200px; margin-right: 200px;">
                <div class="manage-profile-in">
                    <div class="data">
                        <p class="lexend font-bold text-black data-title">Name</p>
                        <p class="lexend font-regular text-black">John Doe</p>
                        <p class="lexend font-bold text-black">Date of Birth</p>
                    </div>
                    <div class="photo-data">
                        <img src="{{asset('asset/profile/profil.jpg')}}" alt="Profile Picture" class="profile-picture">
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script src="{{ asset('js/manageProdile.js')}}"></script>
</body>
{{-- <x-footer></x-footer> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script> --}}
</html>