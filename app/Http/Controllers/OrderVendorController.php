<?php

namespace App\Http\Controllers;

use App\Enums\TimeSlot;
use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderVendorController extends Controller
{
    public function cancel(Order $order)
    {
        // pastikan vendor yang login memang pemilik pesanan
        if ($order->vendorId !== (Auth::user()->vendor->vendorId ?? 73)) {
            abort(403);
        }

        $order->isCancelled = 1;
        $order->save();

        return response()->json(['success' => true]);
    }

    /* ------------------------------------------------------------
     *  Helper: batas minggu
     * ---------------------------------------------------------- */
    private function weekBounds(string $which = 'current'): array
    {
        $monday = Carbon::now('Asia/Jakarta')->startOfWeek(Carbon::MONDAY); // Senin

        return $which === 'next'
            ? [$monday->copy()->addWeek(), $monday->copy()->endOfWeek()->addWeek()]
            : [$monday,                    $monday->copy()->endOfWeek()];
    }

    /* ------------------------------------------------------------
     *  Daftar order (this week / next week lewat query ?week=)
     * ---------------------------------------------------------- */
    public function index(Request $request)
    {
        $vendor = Auth::user()->vendor ?? Vendor::find(73);
        $vendorId   = Auth::user()->vendor->vendorId ?? 73;
        $whichWeek  = $request->query('week', 'current');       // current | next
        [$from, $to] = $this->weekBounds($whichWeek);

        $orders = Order::with([
            'user.defaultAddress',
            'orderItems.package',
            'deliveryStatuses',
        ])
            ->where('vendorId', $vendorId)
            ->where('isCancelled', 0)
            ->whereDate('startDate', '>=', $from)   // ← pakai startDate
            ->whereDate('startDate', '<=', $to)
            ->get()
            ->map(function ($order) {
                $addr = $order->user->defaultAddress;

                return [
                    'id'         => $order->orderId,
                    'startDate'  => Carbon::parse($order->startDate)->format('Y-m-d'),

                    'user' => [
                        'name'    => $order->user->name ?? 'Guest',
                        'phone'   => $addr->recipient_phone ?? '-',
                        'address' => $addr->jalan ?? '-',
                        'notes'   => $addr->notes ?? '-',
                    ],

                    'order_items' => $order->orderItems->map(fn($it) => [
                        'package' => ['name' => $it->package->name ?? 'Paket'],
                        'quantity' => $it->quantity,
                        'package_time_slot' => $it->packageTimeSlot,
                    ]),

                    'delivery_statuses' => collect($order->deliveryStatuses)
                        ->groupBy('slot')
                        ->map(fn($g) => [
                            'slot'   => strtolower($g->first()->slot),
                            'status' => optional($g->sortByDesc('deliveryDate')->first()->status)->value
                                ?? $g->sortByDesc('deliveryDate')->first()->status,
                        ])->values(),
                ];
            });

        $packages = $orders
            ->flatMap(fn($o) => $o['order_items']->pluck('package.name'))
            ->unique()
            ->values();

        return view('manageOrder', compact('orders', 'packages', 'vendor'));
    }

    /* ------------------------------------------------------------
     *  Rekap total (hari ini)
     * ---------------------------------------------------------- */
    public function totalOrder()
    {
        $vendor   = Auth::user()->vendor ?? Vendor::find(91);
        $vendorId = Auth::user()->vendor->vendorId ?? 91;
        $today    = Carbon::today('Asia/Jakarta');

        $orders = Order::with([
            'orderItems.package',
            'deliveryStatuses' => fn($q) =>
            $q->whereDate('deliveryDate', $today),
        ])
            ->where('vendorId', $vendorId)
            ->where('isCancelled', 0)
            ->whereDate('startDate', '<=', $today)
            ->whereDate('endDate',   '>=', $today)
            ->get();

        /* ---- bangun $slotCounts persis seperti kode lama ---- */
        $slotEnumToLabel = [
            TimeSlot::Morning->value   => 'breakfast',
            TimeSlot::Afternoon->value => 'lunch',
            TimeSlot::Evening->value   => 'dinner',
        ];

        $slotCounts = ['breakfast' => [], 'lunch' => [], 'dinner' => []];

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $slotLabel = $slotEnumToLabel[$item->packageTimeSlot] ?? null;
                if (!$slotLabel) continue;

                $pkg = $item->package->name ?? 'Package';
                $slotCounts[$slotLabel][$pkg] =
                    ($slotCounts[$slotLabel][$pkg] ?? 0) + $item->quantity;
            }
        }
        foreach ($slotCounts as &$pkgs) ksort($pkgs);

        return view('cateringHomePage', compact('slotCounts', 'vendor'));
    }


    /* ------------------------------------------------------------
     *  Update status delivery
     * ---------------------------------------------------------- */
    public function updateStatus(Request $request, $orderId, $slot)
    {
        $request->validate(['status' => 'required|in:Prepared,Delivered,Arrived']);

        $ds = DeliveryStatus::where('orderId', $orderId)
            ->where('slot', $slot)
            ->latest('deliveryDate')->first();

        if (!$ds) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery status not found for this order and slot.'
            ], 404);
        }

        $ds->status = $request->status;
        $ds->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'updated_status' => $ds
        ]);
    }
}
