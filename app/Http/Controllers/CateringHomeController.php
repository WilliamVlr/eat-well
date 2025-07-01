<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CateringHomeController extends Controller
{
    public function index()
    {
        return view('cateringHomePage');
    }

    public function export_excel()
    {
        return Excel::download(new OrderExport, "laporan_penjualan.xlsx");
    }

    public function laporan()
    {
        $user = Auth::check() ? Auth::user() : null;
        
        if($user && $user->role == 'Vendor')
        {
            $vendorId = $user->vendor->vendorId;

            $orders = Order::where('vendorId', $vendorId)
            ->get();

            $orders->load(['user', 'orderItems.package']);
            
            return view('laporanPenjualanVendor', compact('orders'));
        } else {
            return redirect('/');
        }

    }
}
