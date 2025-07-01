<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    public function view(): View
    {
        $user = Auth::check() ? Auth::user() : null;
        $vendorId = $user->vendor->vendorId;

        $orders = Order::where('vendorId', $vendorId)
            ->get();

        $orders->load(['user', 'orderItems.package']);
        // dd($orders);

        $totalSales = $orders->sum('totalPrice');
        // dd($totalSales);

        return view('penjualanTable', ['orders' => $orders, 'totalSales' => $totalSales]);
    }
}
