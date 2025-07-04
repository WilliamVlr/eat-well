<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function viewAllVendors()
    {
        $vendors = Vendor::all();

        return view('viewAllVendor', compact('vendors'));
    }

    public function search(Request $request)
    {

        $name = $request->name;

        // $vendors = Vendor::where('name', 'like','%' .$name . '%')->get();
        $vendors = Vendor::where('name', 'like', '%'. $name . '%')->get();
        $vendors->load('address');
        // $addresses =  Address::where('addressId', $request->addressId)->get();

        return view('viewAllVendor', compact('vendors'));
    }
}
