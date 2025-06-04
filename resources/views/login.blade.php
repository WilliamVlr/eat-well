@extends('master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row content align-items-center justify-content-evenly check-border p-4 p-md-5">
            <div class="col-12 col-md-4 check-border">
                <div class="card text-bg-light rounded-5 ">
                    <div class="card-body p-5">
                        <h5 class="card-title text-center p-3">Sign in to EatWell</h5>
                        <form action="#" class="needs-validation" novalidate>
                            <div class="form-floating mb-3 ">
                                <input type="email" class="form-control m-0" placeholder="example@gmail.com" id="email" required>
                                <label class="form-label m-0" for="email">Email</label>
                                <div class="invalid-feedback">Please choose a valid email</div>
                            </div>
                            <div class="form-floating mb-1">
                                <input type="password m-0" class="form-control" placeholder="" id="password" required>
                                <label class="form-label m-0" for="password">Password</label>
                                <div class="invalid-feedback">Please enter a correct password</div>
                            </div>
                            <div class="form-check mb-5">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            <span class="placeholder col-4 placeholder-lg"></span>
                            <button type="submit" class="btn btn-dark my-2 login">Sign in</button>
                        </form>
                        <span class="placeholder col-12 placeholder-lg"></span>
                        <p class="text-center m-0 mt-2">Don't have an account? <u>Register now!</u></p>
                        <p class="text-center m-0">or</p>
                        <p class="text-center m-0">Join EatWell as a <u>vendor!</u></p>
                    </div>
                </div>
            </div>
            <div class="fruits-img d-none d-md-block col-md-6">
                <img src="{{ asset('asset/login-page/login-fruits.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="{{asset('js/login.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script src="https://accounts.google.com/gsi/client" async></script>
@endsection