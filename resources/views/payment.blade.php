@extends('master')

@section('title', 'Payment')

@section('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <h1 class="lexend font-semi-bold text-white your-order mt-3">Your Order</h1>
        <h4 class= "jalan mb-1">
            <span class="material-symbols-outlined location-icon">pin_drop</span>
            <span class="lexend font-regular text-white">Jalan Mangga Rumah Maya Selendang</span>
        </h4>
        <p class="lexend font-regular text-white">
            Notes alamat disini
        </p>
        <div class="container-sm isi">
            <div class="orderdet">
                <p class="lexend font-semibold text-white judul">Order Detail</p>
            </div>
            <div class="detail">
                <p class="lexend font-medium text-black que">Active Period:</p>
                <p class="lexend font-bold text-black ans">{{ $startDate }} until {{ $endDate }}</p>
            </div>
            <div class="detail">
                <p class="lexend font-medium text-black que">Order Date & Time:</p>
                {{-- <p class="lexend font-bold text-black ans">06:00 AM Sat, 01 May 2025</p> --}}
                <p class="lexend font-bold text-black ans">{{ \Carbon\Carbon::now()->format('h:i A || D, d M Y') }}</p>
            </div>
            <hr
                style="height: 1.5px; background-color:black; opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">

            @foreach ($cartDetails as $packageDetail)
                <div class="fullord">
                    <p class="inter font-bold text-black detail pack-name mt-3">{{ $packageDetail['package_name'] }}</p>
                    <div class="container lexend font-regular text-black">
                        <div class="row align-items-start">
                            <div class="col text-left pack-list">
                                @if ($packageDetail['breakfast_qty'] > 0)
                                    <p>{{ $packageDetail['breakfast_qty'] }}<span>x </span>Breakfast</p>
                                @endif
                                @if ($packageDetail['lunch_qty'] > 0)
                                    <p>{{ $packageDetail['lunch_qty'] }}<span>x </span>Lunch</p>
                                @endif
                                @if ($packageDetail['dinner_qty'] > 0)
                                    <p>{{ $packageDetail['dinner_qty'] }}<span>x </span>Dinner</p>
                                @endif
                            </div>
                            <div class="col pack-price text-right">
                                @if ($packageDetail['breakfast_qty'] > 0)
                                    <p>Rp {{ number_format($packageDetail['breakfast_price'], 2, ',', '.') }}</p>
                                @endif
                                @if ($packageDetail['lunch_qty'] > 0)
                                    <p>Rp {{ number_format($packageDetail['lunch_price'], 2, ',', '.') }}</p>
                                @endif
                                @if ($packageDetail['dinner_qty'] > 0)
                                    <p>Rp {{ number_format($packageDetail['dinner_price'], 2, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- TODO: Tambahkan input untuk catatan (note) jika ada --}}
            {{-- <div class="detail note-order lexend">
                <p class="font-medium" style="opacity: 0.7">Note:</p>
                <p class="font-bold">taro makanan nya di loker aja pak.</p>
            </div> --}}

            <hr
                style="height: 1.5px; background-color:black; opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">
            <div class="payment-meth">
                <p class="inter font-semibold text-black detail pack-name mb-0">Payment Method</p>
                <div class="button-payment lexend font-medium text-black">
                    <div class="form-check m-0">
                        <input class="form-check-input radio-custom" type="radio" name="payment-button" id="wellpay">
                        <label class="form-check-label" for="wellpay">
                            Wellpay
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input radioButtonPayment radio-custom" type="radio" name="payment-button"
                            id="qris">
                        <label class="form-check-label" for="qris">
                            QRIS
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input radio-custom" type="radio" name="payment-button" id="bva">
                        <label class="form-check-label" for="bva">
                            BCA Virtual Account
                        </label>
                    </div>
                </div>
            </div>
            <hr
                style="height: 3px; background-color:black; opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">
            <div class="inter font-medium text-black total">
                <span class="detail">Total</span>
                <span class="font-bold nominal">Rp {{ number_format($totalOrderPrice, 2, ',', '.') }}</span>
            </div>
        </div>
        <div class="pay-button">
            <button type="button" class="inter font-semibold text-white pay-btn" id="mainPayButton">Pay</button>
        </div>
    </div>

    <div id="qrisPopup" class="popup-overlay">
        <div class="popup-content">
            <h2>Pay Now</h2>
            <div class="qr-code-container">
                <img src="" alt="QR Code" id="qrCodeImage">
            </div>
            <p class="timer">Expires in <span id="countdownTimer">00:59</span></p>
            <button class="popup-button download-qris" id="downloadQrisBtn">Download QRIS</button>
            <button class="popup-button done" id="doneBtn">Done</button>
        </div>
    </div>

    <div id="confirmationPopup" class="popup-overlay">
        <div class="popup-content">
            <p class="inter font-semibold", style="color: red; font-size:20px">Warning</p>
            <p style="font-weight:600; color:#222; text-align:center; margin-bottom:24px;">
                Are you sure you want to proceed with this payment?
            </p>
            <button id="confirmBtn" class="popup-button"
                style="background:#E77133; color:white; border:none; border-radius:24px; padding:12px 32px; font-size:18px; font-weight:500; box-shadow:0 2px 6px #0001;">
                Confirm Payment
            </button>
        </div>
    </div>

    <div id="successPopup" class="popup-overlay">
        <div class="popup-content">
            <p style="font-weight:600; color:#222; text-align:center; margin-bottom:24px;">
                Successfully added to your subscription. Thank you for your purchase.
            </p>
            <button id="backHomeBtn" class="popup-button"
                style="background:#E77133; color:white; border:none; border-radius:24px; padding:12px 32px; font-size:18px; font-weight:500; box-shadow:0 2px 6px #0001;">
                Back to Homepage
            </button>
        </div>
    </div>

    <div id="customMessageBox" class="message-box-overlay">
        <div class="message-box-content">
            <p id="messageBoxText">Please select a payment method.</p>
            <button id="messageBoxOkBtn">OK</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection
