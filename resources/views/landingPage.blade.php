{{-- <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" href="css/navigation.css"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
</head>

<body>
    @extends('navigation')

    <div class="isiLandingPage">

        <div class="landingText">
            <h2 style="font-size: 100px; font-weight:bold">EAT WELL</h2>
            <p style="font-size: 20px">Eat Well is a smart platform that connects users with healthy meal catering
                services. Discover, compare, and subscribe to trusted catering providers based on your dietary needs and
                preferences—all in one place.</p>
        </div>
        <div class="landingImages">

            <img src="{{ asset('asset/landing_page/gambarMakanan.png') }}" alt="Landing Image 1" width="70%">
            
        </div>
    </div>

    @extends('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body> --}} 



@extends('master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">

@endsection

@section('content')
<div class="isiLandingPage">

        <div class="landingText">
            <h2 style="font-size: 100px; font-weight:bold">EAT WELL</h2>
            <p style="font-size: 20px">Eat Well is a smart platform that connects users with healthy meal catering
                services. Discover, compare, and subscribe to trusted catering providers based on your dietary needs and
                preferences—all in one place.</p>
        </div>
        <div class="landingImages">

            <img src="{{ asset('asset/landing_page/gambarMakanan.png') }}" alt="Landing" width="70%">
            
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>
@endsection


