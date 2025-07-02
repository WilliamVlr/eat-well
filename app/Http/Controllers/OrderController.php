<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentMethod;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $userId = Auth::check() ? Auth::user()->userId : 5;
        $userId = Auth::id();
        if (!$userId) {
            // Arahkan ke halaman login atau tampilkan error
            // return redirect()->route('login')->with('error', 'Please log in to view your cart.');
            return redirect()->route('landingPage');
        }
        
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
  
    public function showPaymentPage(Vendor $vendor) // Menggunakan Route Model Binding untuk Vendor
    {
        $userId = Auth::id();
        // $userId = 1;
        if (!$userId) {
            // Arahkan ke halaman login atau tampilkan error
            // return redirect()->route('login')->with('error', 'Please log in to view your cart.');
            return redirect()->route('landingPage');
        }

        // Ambil cart user untuk vendor tertentu
        $cart = Cart::with(['cartItems.package']) // Eager load cartItems dan package untuk performa
            ->where('userId', $userId)
            ->where('vendorId', $vendor->vendorId)
            ->first();

        // Jika tidak ada cart atau cart kosong, arahkan kembali
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('warning', 'Your cart is empty. Please add items before proceeding to payment.');
        }

        $orderDateTime = Carbon::now();
        // startDate: Selalu Senin minggu depan dari waktu order
        $startDate = $orderDateTime->copy()->next(Carbon::MONDAY)->toDateString();
        // endDate: Minggu seminggu setelah startDate (yaitu Minggu dari minggu depannya)
        $endDate = Carbon::parse($startDate)->copy()->next(Carbon::SUNDAY)->toDateString();

        // Data yang akan diteruskan ke view
        $cartDetails = [];
        $totalOrderPrice = 0;

        foreach ($cart->cartItems as $item) {
            $package = $item->package;
            if ($package) {
                $itemPrice = ($item->breakfastQty * ($package->breakfastPrice ?? 0)) +
                    ($item->lunchQty * ($package->lunchPrice ?? 0)) +
                    ($item->dinnerQty * ($package->dinnerPrice ?? 0));

                $cartDetails[] = [
                    'package_id' => $package->packageId,
                    'package_name' => $package->name,
                    'breakfast_qty' => $item->breakfastQty,
                    'lunch_qty' => $item->lunchQty,
                    'dinner_qty' => $item->dinnerQty,
                    'breakfast_price' => $item->breakfastQty * ($package->breakfastPrice ?? 0),
                    'lunch_price' => $item->lunchQty * ($package->lunchPrice ?? 0),
                    'dinner_price' => $item->dinnerQty * ($package->dinnerPrice ?? 0),
                    'item_total_price' => $itemPrice,
                ];
                $totalOrderPrice += $itemPrice;
            }
        }

        return view('payment', compact('vendor', 'cart', 'cartDetails', 'totalOrderPrice', 'startDate', 'endDate'));
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
