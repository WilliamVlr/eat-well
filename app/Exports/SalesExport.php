<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
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

        foreach ($orders as $order) {
            $grouped = $order->orderItems
                ->groupBy('packageId')
                ->map(function ($items) {
                    $first = $items->first();
                    return [
                        'packageName' => $first->package->name,
                        'timeSlots' => $items->pluck('packageTimeSlot')
                            ->map(fn($ts) => ucfirst(strtolower($ts->name))) // proper format
                            ->unique()
                            ->join(', '),
                    ];
                });

            $order->groupedPackages = $grouped->values(); // Add custom property
        }

        return view('catering.salesTable', ['orders' => $orders, 'totalSales' => $totalSales]);
    }
}
