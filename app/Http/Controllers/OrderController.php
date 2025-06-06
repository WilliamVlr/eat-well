<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the currently authenticated user
        // $user = Auth::user();

        // Get all orders for this user
        // $orders = Order::with(['orderItems.package'])
        // ->where('user_id', auth()->user()->id)
        // ->orderBy('created_at','desc')
        // ->get();

        // For now, use userId = 8
        $orders = Order::with(['orderItems.package'])
            ->where('userId', 8)
            ->orderByDesc('created_at')
            ->get();

        return view('customer.orderHistory', compact('orders'));
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
