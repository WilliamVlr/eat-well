<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logs</title>
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
</head>

<body>
    <x-admin-nav></x-admin-nav>
    <div class="container-fluid mt-4 mb-4 lexend">
        <div class="col-lg-12 table-responsive p-0"
            style="background-color: white; margin-right:0px; border-radius: 30px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); padding:10px">
            <h1 class="fw-bold mt-3" style="margin-left: 1vw">Activity Logs</h1>
            <hr>
            <table class="table table-log">
                <thead>
                    <tr>
                        <th scope="col-1-lg">No. </th>
                        <th scope="col-2-lg">Username</th>
                        <th scope="col-1-lg">User ID</th>
                        <th scope="col-1-lg">Role</th>
                        <th scope="col-2-lg">URL</th>
                        <th scope="col-1-lg">Method</th>
                        <th scope="col-2-lg">IP Address</th>
                        <th scope="col-2-lg">Time</th>


                    </tr>
                </thead>
                <tbody>
                    @if ($all_logs->isEmpty())
                        {{-- <div class="text-center mt-5">
                            <h4>No Logs Available.</h4>
                        </div> --}}

                        <tr>
                            <th>No data</th>
                        </tr>
                    @else
                    @foreach ($all_logs as $log)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $log->name }}</td>
                            <td>{{ $log->userId }}</td>
                            <td>{{ $log->role }}</td>
                            <td>{{ $log->url }}</td>
                            <td>{{ $log->method }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>{{ $log->accessed_at }}</td>
                            {{-- <td><a type="button" class="btn btn-info fs-6 text-center p-1" style="height: 30px; width:50px">Detail</a></td> --}}
                        </tr>
                    @endforeach
                    @endif


                </tbody>
            </table>
        </div>
    </div>

    <x-footer-admin></x-footer-admin>

</body>

</html>
