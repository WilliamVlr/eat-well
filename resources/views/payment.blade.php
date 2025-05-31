<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/payment.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="lexend font-semi-bold text-white">Your Order</h1>
        <p> 
            <span class="lexend font-medium text-white">Order ID:</span>
            <span class="lexend font-medium text-white">2702363304</span>
        </p>
        <i class="fa-solid fa-location-dot"></i>
        <p class= "jalan">
            <span class="lexend font-regular text-white"> Jalan Mangga Rumah Maya Selendang</span>
        </p>
        <div class="container-sm isi">
            <div class="orderdet">
                <p class="lexend font-semibold text-white judul">Order Detail</p>
            </div>
            <div class="detail">
                <p class="lexend font-medium text-black que">Active Period:</p>
                <p class="lexend font-bold text-black ans">3 May 2025- 10 May 2025</p>
            </div>
            <div class="detail">
                <p class="lexend font-medium text-black que">Order Date & Time:</p>
                <p class="lexend font-bold text-black ans">06:00 AM Sat, 01 May 2025</p>
            </div>
            <hr style="height: 1.5px; background-color:black; opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">
            <div class="fullord">
                <p class="inter font-bold text-black detail pack-name">Package A</p>
                <div class="container lexend font-regular text-black">
                    <div class="row align-items-start">
                        <div class="col text-left pack-list">
                            <p>2
                                <span>x</span>
                                Breakfast
                            </p>
                            <p>1 
                                <span>x</span>
                                Lunch
                            </p>
                            <p>3
                                <span>x</span>
                                Dinner
                            </p>
                        </div>
                        <div class="col pack-price text-right">
                            <p>Rp. 200.000,-</p>
                            <p>Rp. 250.000,-</p>
                            <p>Rp. 280.000,-</p>
                        </div>
                    </div>
                </div>
                <div class="detail note-order lexend">
                    <p class="font-medium" style="opacity: 0.7">Note:</p>
                    <p class="font-bold">taro makanan nya di loker aja pak.</p>
                </div>
            </div>
            <hr style="height: 1.5px; background-color:black; opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">
            <div class="payment-meth">
                <p class="inter font-semibold text-black detail pack-name">Payment Method<p>
                <div class="button-payment lexend font-medium text-black">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment-button" id="wellpay">
                        <label class="form-check-label" for="wellpay">
                            Wellpay
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input radioButtonPayment" type="radio" name="payment-button" id="qris">
                        <label class="form-check-label" for="qris">
                            QRIS
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment-button" id="bva">
                        <label class="form-check-label" for="bva">
                            BCA Virtual Account
                        </label>
                    </div>
                </div>
            </div>
            <hr style="height: 3px; background-color:black; opacity:100%; border: none; margin-left: 20px; margin-right: 20px;">
            <div class="inter font-medium text-black total">
                <span class="detail">Total</span>
                <span class="nominal">Rp. 730.000,-</span>
            </div>
        </div>
        <div class="pay-button">
            <button type="button" class="inter font-semibold text-white pay-btn">Pay</button>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</html>
