<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile Vendor</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/manageProfile.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

</head>

<body>
    <x-vendor-nav></x-vendor-nav>
    <div class="container container-custom">
        <div class="left-panel outer-panel">
            <div class="lexend font-medium manage-profile">
                <div class="left-panel-in photo-prof">
                    <img src="{{ asset($vendor->logo) }}" alt="Profile Picture" class="prof-pict">
                </div>
                <div class="right-panel-in data-prof">
                    <p class="profile-name text-white lexend font-regular">{{ $user->name }}</p>
                    <p class="profile-status lexend font-bold">{{ $user->role }}
                    <p>
                    <p class="joined-date text-white lexend font-regular">
                        Joined Since: <span class="date">{{ $user->created_at->format('d-m-Y') }}</span>
                    </p>
                </div>
            </div>
            <div class="menu ">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="menu-link active inter font-regular" id="profileTab" href="#management-profile">Manage
                            Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu-link inter font-regular" id="securityTab" href="#management-security">Manage
                            Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="menu-link inter font-regular" href="/manage-address">Manage Address</a>
                    </li>
                </ul>
            </div>
            <ul class="nav flex-column sidebar-menu mobile-tabs">
                <li class="nav-item">
                    <a class="menu-link active inter font-regular" id="profileTab" href="#management-profile">Manage
                        Profile</a>
                </li>
                <li class="nav-item">
                    <a class="menu-link inter font-regular" id="securityTab" href="#management-security">Manage
                        Security</a>
                </li>
                <li class="nav-item">
                    <a class="menu-link inter font-regular" href="/manage-address">Manage Address</a>
                </li>
            </ul>
            <div class="logout">
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
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
                        <p class="inter font-regular text-black description">This is your profile page. Looking healthy
                            as
                            ever! Manage your account profile here.</p>
                    </div>
                    <hr
                        style="height: 1.8px; background-color:black; opacity:100%; border: none; margin-left: 180px; margin-right: 180px;">
                    @session('success')
                        <p class="text-center" style="color: green">{{ session('success') }}</p>
                    @endsession
                    <div class="manage-profile-in">
                        <form action="{{ route('manage-profile-vendor.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="datafoto">
                                <div class="data">
                                    <label class="inter font-bold text-black data-title">Name</label>
                                    <input type="text" class="lexend font-regular text-black name-input"
                                        id="nameInput" name="nameInput" value="{{ $vendor->name }}" required>
                                    @error('nameInput')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror

                                    <label class="inter font-bold text-black data-title">Telephone</label>
                                    <input type="text" class="lexend font-regular text-black name-input"
                                        id="telpInput" name="telpInput" value="{{ $vendor->phone_number }}" required>
                                    @error('telpInput')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror

                                    <label class="inter font-bold text-black data-title" style="display: none">Date of
                                        Birth</label>
                                    <div class="dob-picker" style="display: none">
                                        <select class="dob-select font-regular" name="dob_month" id="dob_month">
                                            <option value="" selected>{{ $user->dateOfBirth->format('m') }}
                                            </option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select class="dob-select" name="dob_day" id="dob_day">
                                            <option value="" selected>{{ $user->dateOfBirth->format('d') }}
                                            </option>
                                            @for ($d = 1; $d <= 31; $d++)
                                                <option value="{{ $d }}">
                                                    {{ str_pad($d, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select class="dob-select" name="dob_year" id="dob_year">
                                            <option value="" selected>{{ $user->dateOfBirth->format('Y') }}
                                            </option>
                                            @for ($y = date('Y'); $y >= 1900; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>



                                    <div class="time-row mt-3">
                                        <label class="time-label" for="breakfast_hour">Breakfast Delivery</label>
                                        {{-- Breakfast Hour Start --}}
                                        <select class="time-select" name="breakfast_hour_start"
                                            id="breakfast_hour_start">
                                            <option value="">HH</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($bsh) && $bsh == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        {{-- Breakfast Minute Start --}}
                                        <select class="time-select" name="breakfast_minute_start"
                                            id="breakfast_minute_start">
                                            <option value="">MM</option>
                                            @for ($m = 0; $m < 60; $m += 5)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($bsm) && $bsm == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <p class="mt-2">-</p>
                                        {{-- Breakfast Hour End --}}
                                        <select class="time-select" name="breakfast_hour_end"
                                            id="breakfast_hour_end">
                                            <option value="">HH</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($beh) && $beh == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        {{-- Breakfast Minute End --}}
                                        <select class="time-select" name="breakfast_minute_end"
                                            id="breakfast_minute_end">
                                            <option value="">MM</option>
                                            @for ($m = 0; $m < 60; $m += 5)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($bem) && $bem == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                    </div>

                                    <div class="time-row">
                                        <label class="time-label" for="lunch_hour">Lunch Delivery</label>
                                        {{-- Lunch Hour Start --}}
                                        <select class="time-select" name="lunch_hour_start" id="lunch_hour_start">
                                            <option value="">HH</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($lsh) && $lsh == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        {{-- Lunch Minute Start --}}
                                        <select class="time-select" name="lunch_minute_start"
                                            id="lunch_minute_start">
                                            <option value="">MM</option>
                                            @for ($m = 0; $m < 60; $m += 5)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($lsm) && $lsm == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        <p class="mt-2">-</p>

                                        {{-- Lunch Hour End --}}
                                        <select class="time-select" name="lunch_hour_end" id="lunch_hour_end">
                                            <option value="">HH</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($leh) && $leh == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        {{-- Lunch Minute End --}}
                                        <select class="time-select" name="lunch_minute_end" id="lunch_minute_end">
                                            <option value="">MM</option>
                                            @for ($m = 0; $m < 60; $m += 5)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($lem) && $lem == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                    </div>

                                    <div class="time-row">
                                        <label class="time-label" for="dinner_hour_start">Dinner Delivery</label>
                                        {{-- Dinner Hour Start --}}
                                        <select class="time-select" name="dinner_hour_start" id="dinner_hour_start">
                                            <option value="">HH</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($dsh) && $dsh == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        {{-- Dinner Minute Start --}}
                                        <select class="time-select" name="dinner_minute_start"
                                            id="dinner_minute_start">
                                            <option value="">MM</option>
                                            @for ($m = 0; $m < 60; $m += 5)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($dsm) && $dsm == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        <p class="mt-2">-</p>

                                        {{-- Dinner Hour End --}}
                                        <select class="time-select" name="dinner_hour_end" id="dinner_hour_end">
                                            <option value="">HH</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($deh) && $deh == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                        {{-- Dinner Minute End --}}
                                        <select class="time-select" name="dinner_minute_end" id="dinner_minute_end">
                                            <option value="">MM</option>
                                            @for ($m = 0; $m < 60; $m += 5)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ isset($dem) && $dem == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>

                                <div class="photo-data">
                                    <div class="profile-image-wrapper">
                                        <img src="{{ asset($vendor->logo) }}" alt="Profile Picture"
                                            class="profile-picture" id="profilePicPreview">
                                        <label for="profilePicInput" class="change-image-label">
                                            <span class="material-symbols-outlined change-image-icon">
                                                add_photo_alternate
                                            </span>
                                            <input type="file" id="profilePicInput" name="profilePicInput"
                                                accept="image/*" style="display:none;">
                                        </label>
                                    </div>
                                    <div class="edit-btn-group">
                                        <button class="inter font-medium edit-data">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>



                <hr class="section-divider">
                <div id="management-security" class="management-section">

                    <div class="security-manage">
                        <p class="lexend font-medium text-black title">Security Management</p>
                        <p class="inter font-regular text-black description">This is where we lock security with top
                            grade
                            protection. Safest place on earth! Manage your account security here.</p>
                        <hr
                            style="height: 1.8px; background-color:black; opacity:100%; border: none; margin-left: 180px; margin-right: 180px;">
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
                                <span class="inter font-bold mfa-toggle-label">Enable Multi Factor
                                    Authentication</span>
                            </div>

                            <p class="mfa-desc inter font-bold">
                                Multi Factor Authentication works by sending OTP to your email and requiring it every
                                time
                                you log in onto the account.
                            </p>
                        </div>
                        <div class="security-divider"></div>
                        <div class="right-security">
                            <p class="inter font-bold title-security">Change Password</p>
                            <div class="change-password-form">
                                <div class="password-input-group">
                                    <input type="password" id="oldPassword" class="password-input"
                                        placeholder="Old Password">
                                    <span class="toggle-password" data-target="oldPassword">
                                        <span class="material-symbols-outlined">visibility_off</span>
                                    </span>
                                </div>
                                <div class="password-input-group">
                                    <input type="password" id="newPassword" class="password-input"
                                        placeholder="New Password">
                                    <span class="toggle-password" data-target="newPassword">
                                        <span class="material-symbols-outlined">visibility_off</span>
                                    </span>
                                </div>
                                <div class="password-input-group">
                                    <input type="password" id="verifyPassword" class="password-input"
                                        placeholder="New Password Verification">
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
    <script src="{{ asset('js/customer/manageProfile.js') }}"></script>
</body>

</html>
