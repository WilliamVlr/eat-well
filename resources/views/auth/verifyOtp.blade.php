@extends('master')

@section('title', 'Login')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row content align-items-center justify-content-center p-4 p-md-5">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="card text-bg-light rounded-4 d-block" id="login-card">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center p-3">Please check your email for the OTP</h2>

                        <form method="POST" action="{{ route('auth.check') }}" novalidate>
                            @csrf
                            <input type="hidden" name="email" value="{{$email}}">
                            <div class="form-floating mb-3">
                                <input type="text" inputmode="numeric" pattern="[0-9\s]*" name="otp" class="form-control m-0 @error('otp') is-invalid @enderror" id="otp" value="{{ old('otp') }}" placeholder="" >
                                <label for="otp" class="form-label m-0">OTP</label>
                                <div class="invalid-feedback">{{ $errors->first('otp') }}</div>
                            </div>

                            <button type="submit" class="btn btn-dark my-2 login-register-btn">Sign in</button>
                        </form>

                        <form action="{{route('auth.resend-otp')}}" method="post" novalidate>
                            @csrf
                            <input type="hidden" name="email" value="{{$email}}">
                            <button type="submit" class="btn btn-dark">Resend</button>
                        </form>
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
