@extends('master')

@section('title', 'Manage Profile')
@section('css')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <link rel="stylesheet" href="{{asset('css/manageProfile.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
@endsection

@section('content')
    <div class="container container-custom">
        <div class="left-panel outer-panel">
            <div class="lexend font-medium manage-profile">
                <div class="left-panel-in photo-prof">    
                    <img src="{{asset('asset/profile/profil.jpg')}}" alt="Profile Picture" class="prof-pict">
                </div>
                <div class="right-panel-in data-prof">
                    <p class="profile-name text-white lexend font-regular">John Doe</p>
                    <p class="profile-status lexend font-bold">Healthy Customer<p>
                    <p class="joined-date text-white lexend font-regular">
                        Joined Since: <span class="date">05/27/2025</span>
                    </p>
                </div>
            </div>
            <div class="menu ">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="menu-link active inter font-regular" id="profileTab" href="#management-profile">Manage Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu-link inter font-regular" id="securityTab" href="#management-security">Manage Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu-link inter font-regular" href="/manage-address">Manage Address</a>
                    </li>
                </ul>
            </div>
            <ul class="nav flex-column sidebar-menu mobile-tabs">
                <li class="nav-item">
                    <a class="menu-link active inter font-regular" id="profileTab" href="#management-profile">Manage Profile</a>
                </li>
                <li class="nav-item">
                    <a class="menu-link inter font-regular" id="securityTab" href="#management-security">Manage Security</a>
                </li>
                <li class="nav-item">
                    <a class="menu-link inter font-regular" href="/manage-address">Manage Address</a>
                </li>
            </ul>
            <div class="logout">
                <form method="POST" action="{{ route('login-register') }}" class="logout-form">
                @csrf
                    <button type="submit" class="logout-btn inter font-regular">
                        Log out
                    </button>
                </form>
            </div>
        </div>
            
        
        <div class="right-panel outer-panel">
            <div class="lexend font-medium outer-box scrollable-box">
                <div id="management-profile" class="management-section">
                    <div class="profile-manage">
                        <p class="lexend font-medium text-black title">Personal Profile</p>
                        <p class="inter font-regular text-black description">This is your profile page. Looking healthy as ever! Manage your account profile here.</p>
                    </div>
                    <hr style="height: 1.8px; background-color:black; opacity:100%; border: none; margin-left: 180px; margin-right: 180px;">
                    <div class="manage-profile-in">
                        <div class="datafoto">
                            <div class="data">
                                <p class="inter font-bold text-black data-title">Name</p>
                                <input type="text" class="lexend font-regular text-black name-input" id="nameInput" value="John Doe">

                                <p class="inter font-bold text-black data-title">Date of Birth</p>
                                <div class="dob-picker">
                                    <select class="dob-select font-regular" name="dob_month" id="dob_month">
                                        <option value="" selected>MM</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <select class="dob-select" name="dob_day" id="dob_day">
                                        <option value="" selected>DD</option>
                                        @for ($d = 1; $d <= 31; $d++)
                                        <option value="{{ $d }}">{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <select class="dob-select" name="dob_year" id="dob_year">
                                        <option value="" selected>YYYY</option>
                                        @for ($y = date('Y'); $y >= 1900; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <p class="inter font-bold text-black data-title gender">Gender</p>
                                <div class="gender-group">
                                    <input type="radio" id="male" name="gender" value="male" class="gender-radio" checked>
                                    <label for="male" class="gender-label">Male</label>
                                    <input type="radio" id="female" name="gender" value="female" class="gender-radio">
                                    <label for="female" class="gender-label lexend font-medium text-black">Female</label>
                                </div>
                            </div>
                            <div class="photo-data">
                                <div class="profile-image-wrapper">
                                    <img src="{{ asset('asset/profile/profil.jpg') }}" alt="Profile Picture" class="profile-picture" id="profilePicPreview">
                                    <label for="profilePicInput" class="change-image-label">
                                        <span class="material-symbols-outlined change-image-icon">
                                            add_photo_alternate
                                        </span>
                                        <input type="file" id="profilePicInput" accept="image/*" style="display:none;">
                                    </label>
                                </div>  
                                <div class="edit-btn-group">
                                    <button class="inter font-medium edit-data">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <hr class="section-divider">
                 <div id="management-security" class="management-section">

                <div class="security-manage">
                    <p class="lexend font-medium text-black title">Security Management</p>
                    <p class="inter font-regular text-black description">This is where we lock security with top grade protection. Safest place on earth! Manage your account security here.</p>
                    <hr style="height: 1.8px; background-color:black; opacity:100%; border: none; margin-left: 180px; margin-right: 180px;">
                </div>
                        <div class="left-right-security">
                            <div class="left-security">
                                <p class="inter font-bold title-security">MFA Management</p>
                                <div class="mfa-warning">
                                    <span class="material-symbols-outlined mfa-warning-icon">warning</span>
                                    <span class="inter font-bold mfa-warning-text">
                                        Your account is not fully protected,<br>
                                        we recommend you to activate 2FA!
                                    </span>
                                </div>

                                <div class="mfa-toggle-row">
                                    <label class="mfa-switch">
                                        <input type="checkbox" id="mfaToggle">
                                        <span class="mfa-slider"></span>
                                    </label>
                                    <span class="inter font-bold mfa-toggle-label">Enable Multi Factor Authentication</span>
                                </div>

                                <p class="mfa-desc inter font-bold">
                                    Multi Factor Authentication works by sending OTP to your email and requiring it every time you log in onto the account.
                                </p>
                            </div>
                            <div class="security-divider"></div>
                            <div class="right-security">
                                <p class="inter font-bold title-security">Change Password</p>
                                <div class="change-password-form">
                                    <div class="password-input-group">
                                        <input type="password" id="oldPassword" class="password-input" placeholder="Old Password">
                                        <span class="toggle-password" data-target="oldPassword">
                                            <span class="material-symbols-outlined">visibility_off</span>
                                        </span>
                                    </div>
                                    <div class="password-input-group">
                                        <input type="password" id="newPassword" class="password-input" placeholder="New Password">
                                        <span class="toggle-password" data-target="newPassword">
                                            <span class="material-symbols-outlined">visibility_off</span>
                                        </span>
                                    </div>
                                    <div class="password-input-group">
                                        <input type="password" id="verifyPassword" class="password-input" placeholder="New Password Verification">
                                        <span class="toggle-password" data-target="verifyPassword">
                                            <span class="material-symbols-outlined">visibility_off</span>
                                        </span>
                                    </div>
                                    <div class="change-btn-group">
                                        <button class="inter save-password-btn">Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/manageProfile.js')}}"></script>
@endsection