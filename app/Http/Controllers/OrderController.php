<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

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

        // For now, use userId = 8
        $userId = 8; // Replace with Auth::id() when ready
        $status = $request->query('status', 'all');
        $query = $request->query('query');
        $now = Carbon::now();
        
        $orders = Order::with(['orderItems.package', 'vendor'])
            ->where('userId', $userId)
            ->when($status === 'active', function ($q) use ($now){
                $q->where('isCancelled', 0)
                ->whereDate('startDate', '<=', $now)
                ->whereDate('endDate', '>=', $now);
            })
            ->when($status === 'finished', function ($q) use ($now){
                $q->where('isCancelled', 0)
                ->whereDate('endDate', '<', $now);
            })
            ->when($status === 'cancelled', function ($q) use ($now){
                $q->where('isCancelled', 1);
            })
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('orderId', 'like', "%$query%")
                    ->orWhereHas('vendor', function ($vendorQ) use ($query) {
                        $vendorQ->where('name', 'like', "%$query%");
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
        //
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
