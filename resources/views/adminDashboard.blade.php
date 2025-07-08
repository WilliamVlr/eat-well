{{-- npm install chart.js --}}
{{-- import Chart from 'chart.js/auto'; --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    @endsection



</head>


<body>
    <x-admin-nav></x-admin-nav>

    <div style="margin: 2vw">
        {{-- Untuk button ini jangan dihapus, untuk sementara button logout disini, menunggu UI logout beneran dibuat --}}
        <form action="{{ route('logout.admin') }}" method="post">
            @csrf
            <button type="submit"></button>
        </form>
        <h1 class="text-center mt-3 fw-bold">EAT-WELL</h1>
        <div class="" style="margin: 4vw">
            <div class="row mt-5">
                <div class="col-lg-6" style="">

                    <div class="row d-flex flex-direction-column p-4"
                        style="background-color: white; margin-right:0px; border-radius: 30px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        <h4 class="mt-0 mb-3 fw-bold">Preview</h4>
                        <div class="col-lg-6 mb-2">
                            <div class="card"
                                style="background-image: url('asset/admin/card.png'); background-size: cover; background-position: center">
                                <div class="card-body">
                                    {{-- keuntungan ambil data di order aja dari total price lalu anggap saja kita kasih pajak 5% --}}
                                    <h5 class="card-title text-center fw-bolder mt-2 fs-4 mb-3" style="color: white">
                                        Keuntungan</h5>
                                    <p class="card-text text-center fs-5" style="color: rgb(255, 255, 255)"> Rp.
                                        {{ $profit }}, 00 </p>

                                    <p class="card-text text-center fs-6" style="color: rgb(233, 248, 235)">
                                        {{ $percentageprofit >= 0 ? 'Increased' : 'Decreased' }} by
                                        {{ number_format(abs($percentageprofit), 2) }} % {{ $percentageprofit >= 0 ? '📈' : '📉' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6" style="margin-right: 0px">
                            <div class="card"
                                style="background-image: url('asset/admin/card2.png'); background-size: cover; background-position: center">
                                <div class="card-body">
                                    {{-- keuntungan ambil data di order aja dari total price lalu anggap saja kita kasih pajak 5% --}}
                                    <h5 class="card-title text-center fw-bolder mt-2 fs-4 mb-3" style="color: white">
                                        Total Sales</h5>
                                    <p class="card-text text-center fs-5" style="color: rgb(255, 255, 255)"> Rp.
                                        {{ $totalPrice }},00 </p>

                                    <p class="card-text text-center fs-6" style="color: rgb(233, 248, 235)">
                                        {{ $increment >= 0 ? 'Increased' : 'Decreased' }} by
                                        {{ number_format(abs($percentage), 2) }} % {{ $increment >= 0 ? '📈' : '📉' }}
                                    </p>

                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row mt-5">
                        <div class="col-lg-11">
                            <div>
                                <canvas id="myChart" height="400"></canvas>
                            </div>
                        </div>
                    </div>



                    <div class="row"></div>
                </div>

                <div class="col-lg-1">

                </div>

                <div class="col-lg-5"
                    style="background-color: white; margin-right:0px; border-radius: 30px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); padding:10px">
                    <h1 class="fw-bold mt-3" style="margin-left: 1vw">Recent Logs</h1>
                    <hr>
                    <table class="table table-log">
                        <thead>
                            <tr>
                                <th scope="col">No. </th>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Activity</th>
                                <th scope="col">Time</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>@social</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>@social</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">8</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                            <tr>
                                <th scope="row">9</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>@social</td>
                                <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="view-all-logsbtn">
                        <a href="" type="button" class="btn btn-primary">View All Logs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.chartData = @json($chartData);
        window.labels = @json($labels);
    </script>

    <script src="{{ asset('js/admin/dashboard.js') }}"></script>


</body>

</html>
