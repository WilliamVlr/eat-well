<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the currently authenticated user
        // $user = Auth::user();

        // Get all orders for this user
        // $orders = Order::with(['orderItems.package'])
        // ->where('user_id', auth()->user()->id)
        // ->orderBy('created_at','desc')
        // ->get();

        $userId = Auth::check() ? Auth::user()->userId : 5;

        $status = $request->query('status', 'all');
        $query = $request->query('query');
        $now = Carbon::now();

        $orders = Order::with(['orderItems.package', 'vendor'])
            ->where('userId', $userId)
            ->when($status === 'active', function ($q) use ($now) {
                $q->where('isCancelled', 0)
                    ->whereDate('startDate', '<=', $now)
                    ->whereDate('endDate', '>=', $now);
            })
            ->when($status === 'finished', function ($q) use ($now) {
                $q->where('isCancelled', 0)
                    ->whereDate('endDate', '<', $now);
            })
            ->when($status === 'cancelled', function ($q) use ($now) {
                $q->where('isCancelled', 1);
            })
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('orderId', 'like', "%$query%")
                        ->orWhereHas('vendor', function ($vendorQ) use ($query) {
                            $vendorQ->where('name', 'like', "%$query%");
                        })
                        ->orWhereHas('orderItems.package', function ($packageQ) use ($query) {
                            $packageQ->where('name', 'like', "%$query%");
                        });
                });
            })
            ->orderByDesc('endDate')
            ->get();

        return view('customer.orderHistory', compact('orders', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id)
            ->load(['payment', 'deliveryStatuses', 'orderItems.package', 'vendor']);

        $paymentMethod = $order->payment ? PaymentMethod::find($order->payment->methodId) : null;

        // Define slots
        $slots = [
            ['key' => 'morning', 'label' => 'Morning', 'icon' => 'partly_cloudy_day'],
            ['key' => 'afternoon', 'label' => 'Afternoon', 'icon' => 'wb_sunny'],
            ['key' => 'evening', 'label' => 'Evening', 'icon' => 'nights_stay'],
        ];

        // Group delivery statuses by slot and date
        $statusesBySlot = [];
        foreach ($order->deliveryStatuses as $status) {
            $slotKey = strtolower($status->slot->value ?? $status->slot);
            $dateKey = Carbon::parse($status->deliveryDate)->format('l, d M Y');
            $statusesBySlot[$slotKey][$dateKey] = $status;
        }
        // dd($statusesBySlot);

        return view('customer.orderDetail', compact('order', 'paymentMethod', 'slots', 'statusesBySlot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
