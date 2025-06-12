@extends('master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row content align-items-center justify-content-center p-4 p-md-5">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="card text-bg-light rounded-5 d-block" id="login-card">
                    <div class="card-body p-5">
                        <h5 class="card-title text-center p-3">Sign in to EatWell</h5>
                        <form method="POST" action="/login" novalidate>
                            @csrf
                            <x-form-field>
                                <x-form-input type="email" name="email" id="email" :value="old('email')" placeholder="" required/>
                                <x-form-label for="email">Email</x-form-label>
                                <x-form-error name="email"></x-form-error>
                            </x-form-field>

                            <x-form-field>
                                <x-form-input type="password" name="password" id="password" placeholder="" required/>
                                <x-form-label for="password">Password</x-form-label>
                                <x-form-error name="password"></x-form-error>
                            </x-form-field>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember"/>
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div>

                            <span class="placeholder col-4 placeholder-lg"></span>
                            <x-form-button type="submit">Sign in</x-form-button>
                        </form>
                        <span class="placeholder col-12 placeholder-lg"></span>
                        <div class="row justify-content-center p-2">
                            <button type="button" onclick="loginCregister()" class="btn btn-link change-card-link text-center w-auto p-0">Don't have an account? <u>Register now!</u></button>
                            <p class="text-center change-card-link m-0">or</p>
                            <button type="button" class="btn btn-link change-card-link text-center w-auto p-0">Join Eatwell as a <u>vendor!</u></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fruits-img d-none d-xl-block col-xl-7">
                <img src="{{ asset('asset/login-page/login-fruits.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="{{asset('js/login-register.js') }}"></script>
@endsection
