<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id(); // ambil ID user yang login (vendor)

        $orders = Order::with([
            'user',
            'orderItems.package',
            'deliveryStatuses'
        ])
        ->where('vendorId', $vendorId) // hanya order untuk vendor ini
        ->get()
        ->map(function ($order) {
            return [
                'id' => $order->orderId, // gunakan 'orderId' kalau memang ini primary key-mu
                'user' => [
                    'name' => $order->user->name ?? 'Guest',
                    'phone' => $order->user->phone ?? '-',
                    'address' => $order->user->address ?? '-',
                    'notes' => $order->user->notes ?? '-',
                ],
                'order_items' => $order->orderItems->map(function ($item) {
                    return [
                        'package' => [
                            'name' => $item->package->name ?? 'Paket',
                        ],
                        'quantity' => $item->quantity,
                        'package_time_slot' => $item->packageTimeSlot
                    ];
                }),
                'delivery_statuses' => $order->deliveryStatuses->map(function ($ds) {
                    return [
                        'slot' => $ds->slot,
                        'status' => is_object($ds->status) ? $ds->status->value : $ds->status
                    ];
                })
            ];
        });

        return view('manageOrder', compact('orders'));
    }

    public function updateStatus(Request $request, $orderId, $slot)
    {
        $request->validate([
            'status' => 'required|in:Prepared,Delivering,Received'
        ]);

        $orderStatus = \App\Models\DeliveryStatus::where('orderId', $orderId)
            ->where('slot', $slot)
            ->first();

        if ($orderStatus) {
            $orderStatus->status = $request->status;
            $orderStatus->save();
        }

        return response()->json(['success' => true]);
    }
}
