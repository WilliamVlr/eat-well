@php
    use Carbon\Carbon;
@endphp
<table class="table table-striped">
    <thead>
        <tr>
            <th class="d-flex flex-row justify-content-between">
                <span>Period</span>
                <span>:</span>
            </th>
            <th>
                {{ $periodText }}
            </th>
        </tr>
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
                <td>ORD{{ $order->orderId }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ Carbon::parse($order->startDate)->format('Y-m-d') }}</td>
                <td>{{ Carbon::parse($order->endDate)->format('Y-m-d') }}</td>
                <td>
                    @foreach ($order->groupedPackages as $pkg)
                        {{ $pkg['packageName'] }} ({{ $pkg['timeSlots'] }}) <br>
                    @endforeach
                </td>
                <td>Rp {{ number_format($order->totalPrice, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-end fw-bold">Total Sales</td>
            <td class="fw-bold">Rp{{ number_format($totalSales, 2, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
