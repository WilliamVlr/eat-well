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

class OrderController extends Controller
{
    public function showPaymentPage(Vendor $vendor) // Menggunakan Route Model Binding untuk Vendor
    {
        // $userId = Auth::id();
        $userId = 1;
        if (!$userId) {
            // Arahkan ke halaman login atau tampilkan error
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
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
}
