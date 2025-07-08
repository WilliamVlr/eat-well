<?php

namespace App\Http\Controllers;

use App\Enums\DeliveryStatuses;
use App\Enums\TimeSlot;
use App\Models\DeliveryStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderVendorController extends Controller
{
    public function index()
    {
        // $vendorId = Auth::id(); // ambil ID user yang login (vendor)
        // $vendorId = 24;

        $vendorId = Auth::user()->vendor->vendorId ?? 24;

        $orders = Order::with([
            'user.defaultAddress',
            'orderItems.package',
            'deliveryStatuses' => function ($query) {
                $query->whereDate('deliveryDate', Carbon::today());
            }
        ])
            ->where('vendorId', $vendorId)
            ->get()
            ->map(function ($order) {
                $defaultAddress = $order->user->defaultAddress;

                return [
                    'id' => $order->orderId,
                    'start_date' => $order->start_date
                        ? Carbon::parse($order->start_date)->format('Y-m-d')
                        : $order->created_at->format('Y-m-d'),

                    'user' => [
                        'name' => $order->user->name ?? 'Guest',
                        'phone' => $defaultAddress->recipient_phone ?? '-',
                        'address' => $defaultAddress->jalan ?? '-',
                        'notes' => $defaultAddress->notes ?? '-',
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
                            'slot' => strtolower($ds->slot),
                            'status' => is_object($ds->status) ? $ds->status->value : $ds->status,
                        ];
                    })
                ];
            });

        $packages = $orders
            ->flatMap(fn($order) => $order['order_items']->pluck('package.name'))
            ->unique()
            ->values();

        return view('manageOrder', compact('orders', 'packages'));
    }

    public function totalOrder()
    {
        $vendorId = Auth::user()->vendor->vendorId ?? 24;

        $orders = Order::with([
            'user.defaultAddress',
            'orderItems.package',
            'deliveryStatuses' => function ($query) {
                $query->whereDate('deliveryDate', Carbon::today());
            }
        ])
            ->where('vendorId', $vendorId)
            ->get()
            ->map(function ($order) {
                $defaultAddress = $order->user->defaultAddress;

                return [
                    'id' => $order->orderId,
                    'start_date' => $order->start_date
                        ? Carbon::parse($order->start_date)->format('Y-m-d')
                        : $order->created_at->format('Y-m-d'),

                    'user' => [
                        'name' => $order->user->name ?? 'Guest',
                        'phone' => $defaultAddress->recipient_phone ?? '-',
                        'address' => $defaultAddress->jalan ?? '-',
                        'notes' => $defaultAddress->notes ?? '-',
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
                            'slot' => strtolower($ds->slot),
                            'status' => is_object($ds->status) ? $ds->status->value : $ds->status,
                        ];
                    })
                ];
            });

        // Konversi enum slot → label
        $slotEnumToLabel = [
            TimeSlot::Morning->value   => 'breakfast',
            TimeSlot::Afternoon->value => 'lunch',
            TimeSlot::Evening->value   => 'dinner',
        ];

        $slotCounts = [
            'breakfast' => [],
            'lunch'     => [],
            'dinner'    => [],
        ];

        foreach ($orders as $order) {
            foreach ($order['order_items'] as $item) {
                $slotLabel = $slotEnumToLabel[$item['package_time_slot']] ?? null;
                if (!$slotLabel) continue;

                $pkgName = $item['package']['name'];
                if (!isset($slotCounts[$slotLabel][$pkgName])) {
                    $slotCounts[$slotLabel][$pkgName] = 0;
                }

                $slotCounts[$slotLabel][$pkgName] += $item['quantity'];
            }
        }

        foreach ($slotCounts as $slot => $pkgs) {
            ksort($slotCounts[$slot]);
        }

        $packages = $orders
            ->flatMap(fn($order) => $order['order_items']->pluck('package.name'))
            ->unique()
            ->values();

        return view('cateringHomePage', compact('orders', 'packages', 'slotCounts'));
    }

    public function updateStatus(Request $request, $orderId, $slot)
    {
        try {
            $request->validate([
                'status' => 'required|in:Prepared,Delivered,Arrived',
            ]);

            $row = DeliveryStatus::query()
                ->where('orderId', $orderId)
                ->where('slot', $slot)
                ->whereDate('deliveryDate', now())
                ->first();

            $row->status = $request->status;
            $row->save();

            return response()->json(['success' => true, 'data_order' => $row]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
                'trace'   => collect($e->getTrace())->take(5),
            ], 500);
        }
    }
}
