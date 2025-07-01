<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\Util\Percentage;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $orders = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        // ini total sales bulan ini
        $totalPrice = $orders->sum(function ($order) {
            return (float) $order->totalPrice;
        });

        $lastMonthOrder = Order::whereMonth('created_at', Carbon::now()->subMonth()->month())
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $lastMonthSale = $lastMonthOrder->sum(function ($lastMonthOrder) {
            return (float) $lastMonthOrder->totalPrice;
        });

        // $lastMonthSale = 100000000000;
        // perbedaan sales bulan ini dan bulan lalu
        $increment = $totalPrice - $lastMonthSale;

        // $increment = -10000;

        $percentage = 0;
        if ($lastMonthSale == 0) {
            $percentage = 100;
        } else {
            $percentage = ($increment / $lastMonthSale) * 100;
        }

        // dd($lastMonthSale);

        // dd($totalPrice);

        $lmprofit = 0.05 * $lastMonthSale;

        $profit = 0.05 * $totalPrice;

        $lmprofit = 10000;
        
        $percentageprofit = (($profit - $lmprofit) / $lmprofit) * 100;

        $profit = number_format($profit, 0, ',', '.');

        $totalPrice = number_format($totalPrice, 0, ',', '.');

       

        return view('adminDashboard', compact('totalPrice', 'percentage', 'profit', 'increment', 'percentageprofit'));
    }
}
