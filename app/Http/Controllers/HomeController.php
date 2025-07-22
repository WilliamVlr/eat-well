<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{
    public function index()
    {
        /**
         * @var User|null $user
         */
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $address = Address::where('userId', $user->userId)
            ->where('is_default', true)
            ->first();

        if ($address) {
            // Get vendors in same provinsi
            $nearVendors = Vendor::where('provinsi', $address->provinsi)
                ->inRandomOrder()
                ->take(6)
                ->get();

            $countNear = $nearVendors->count();

            if ($countNear < 12) {
                // Get extra vendors not in same provinsi
                $extraVendors = Vendor::where('provinsi', '!=', $address->provinsi)
                    ->orderBy('rating')
                    ->take(12 - $countNear)
                    ->get();

                // Combine both
                $vendors = $nearVendors->concat($extraVendors);
            } else {
                $vendors = $nearVendors;
            }
        } else {
            $vendors = Vendor::orderByDesc('rating')->limit(12)->get();
        }

        // Get favorited vendors from this user
        $favVendors = $user->favoriteVendors()->limit(8)->get();
        // dd($favVendors);

        // Oldest active subscription
        $order = Order::where('userId', $user->userId)
            ->where('isCancelled', false)
            ->whereDate('startDate', '<=', Carbon::now())
            ->whereDate('endDate', '>=', Carbon::now())
            ->orderBy('created_at')
            ->first();
        // dd($order);
        $slotMap = [];

        if($order){
            $order->load(['vendor', 'orderItems', 'deliveryStatuses']);
    
            // Group order items by packageTimeSlot, then by package name, and sum quantity per package
            $itemsBySlot = $order->orderItems
                ->groupBy(function ($item) {
                    return strtolower($item->packageTimeSlot->value ?? $item->packageTimeSlot);
                })
                ->map(function ($items) {
                    // Group by package name and sum quantity per package
                    return $items->groupBy(function ($item) {
                        return $item->package->name;
                    })->map(function ($groupedItems, $packageName) {
                        return [
                            'package' => $packageName,
                            'quantity' => $groupedItems->sum('quantity'),
                        ];
                    })->values();
                });
            // dd($itemsBySlot);
    
            // 2. Get today's delivery status for each slot
            $today = now()->toDateString();
            // $today = '2025-06-24';
            $deliveryStatusBySlot = $order->deliveryStatuses()
                ->whereDate('deliveryDate', $today)
                ->get()
                ->keyBy(function ($status) {
                    return strtolower($status->slot->value ?? $status->slot);
                });
            // dd($deliveryStatusBySlot);
    
            // Merge into one mapping
            foreach ($itemsBySlot as $slotKey => $packages) {
                $slotMap[$slotKey] = [
                    'packages' => $packages,
                    'deliveryStatus' => $deliveryStatusBySlot[$slotKey] ?? null,
                ];
            }
            // dd($slotMap);
        }

        $wellpay = $user->wellpay ?? 0; // Ambil saldo, default 0 jika kolom 'balance' null/tidak ada

        logActivity('successfully', 'visited', 'Homepage');

        return view('customer.home', compact('vendors', 'favVendors', 'order', 'slotMap', 'wellpay'));
    }
}
