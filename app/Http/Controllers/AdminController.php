<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function viewAllVendors()
    {
        // $orders = Order::all();



        $vendors = Vendor::all();

        $sales = DB::table('orders')
        ->select('vendorId', DB::raw('SUM(totalPrice) as totalSales'))
        ->groupBy('vendorId')
        ->pluck('totalSales', 'vendorId');

    return view('viewAllVendor', compact('vendors', 'sales'));

        // return view('viewAllVendor', compact('vendors'));
    }

    public function search(Request $request)
    {

        $name = $request->name;

        // $vendors = Vendor::where('name', 'like','%' .$name . '%')->get();
        $vendors = Vendor::where('name', 'like', '%'. $name . '%')->get();
        // $vendors->load('address');
        // $addresses =  Address::where('addressId', $request->addressId)->get();
        $sales = DB::table('orders')
        ->select('vendorId', DB::raw('SUM(totalPrice) as totalSales'))
        ->groupBy('vendorId')
        ->pluck('totalSales', 'vendorId');

        return view('viewAllVendor', compact('vendors', 'sales'));


        // return view('viewAllVendor', compact('vendors'));
    }
}
