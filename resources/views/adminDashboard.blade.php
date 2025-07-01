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



        <h1 class="text-center mt-5 fw-bold">Admin Dashboard</h1>

        <div class="" style="margin: 4vw">
            <div class="row mt-5">
                <div class="col-lg-6" style="">

                    <div class="row d-flex flex-direction-column p-4"
                        style="background-color: white; margin-right:0px; border-radius: 30px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        <h4 class="mt-0 mb-3 fw-bold">Preview</h4>
                        <div class="col-lg-6 mb-2">
                            <div class="card"
                                style="height: 20vh; background-image: url('asset/admin/card.png'); background-size: cover; background-position: center">
                                <div class="card-body">
                                    {{-- keuntungan ambil data di order aja dari total price lalu anggap saja kita kasih pajak 5% --}}
                                    <h5 class="card-title text-center fw-bolder mt-2 fs-4 mb-3" style="color: white">
                                        Keuntungan</h5>
                                    <p class="card-text text-center fs-5" style="color: rgb(255, 255, 255)"> Rp.
                                        1.400.500.250,00 </p>

                                    <p class="card-text text-center fs-6" style="color: rgb(233, 248, 235)"> Increased
                                        by
                                        100% 📈</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6" style="height: 20vh" style="margin-right: 0px">
                            <div class="card"
                                style="height: 20vh; background-image: url('asset/admin/card2.png'); background-size: cover; background-position: center">
                                <div class="card-body">
                                    {{-- keuntungan ambil data di order aja dari total price lalu anggap saja kita kasih pajak 5% --}}
                                    <h5 class="card-title text-center fw-bolder mt-2 fs-4 mb-3" style="color: white">
                                        Total Sales</h5>
                                    <p class="card-text text-center fs-5" style="color: rgb(255, 255, 255)"> Rp.
                                        1.400.500.250,00 </p>

                                    <p class="card-text text-center fs-6" style="color: rgb(233, 248, 235)"> Increased
                                        by
                                        100% 📈</p>
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

                <div class="col-lg-5" style="height: 70vh; background-color: white; margin-right:0px; border-radius: 30px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); padding:10px">
                    <h1 class="fw-bold mt-3" style="margin-left: 1vw">Logs</h1>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>@social</td>
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
        const ctx = document.getElementById('myChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C'],
                datasets: [{
                    label: 'Contoh',
                    data: [10, 20, 30],
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


</body>

</html>
