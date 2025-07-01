@extends('master')

@section('title', 'Penjualan')

@section('css')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Package Ordered</th>
                <th>Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>ORD{{$order->orderId}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{Carbon::parse($order->startDate)->format('Y-m-d')}}</td>
                <td>{{Carbon::parse($order->endDate)->format('Y-m-d')}}</td>
                <td>
                    @foreach ($order->orderItems as $item)
                        {{$item->package->name . !$loop->last ? ', ' : ''}}
                    @endforeach
                </td>
                <td>Rp {{$order->totalPrice}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-end fw-bold">Total Sales</td>
            <td class="fw-bold">$ 200.00</td>
        </tr>
    </tfoot>
    </table>
@endsection
