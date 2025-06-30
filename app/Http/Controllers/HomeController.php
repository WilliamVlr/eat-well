<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('role', 'like', 'Customer')->inRandomOrder()->first();
        // Check if user is logged in
        if (Auth::check()) {
            // Get user ID (custom column: userId)
            $user = Auth::user();
        }

        $user->load('addresses');
        // $anotherAddress = Address::where('userId', $user->userId)
        //                     ->where('is_default', false)
        //                     ->first();

        $address = Address::where('userId', $user->userId)->first();

        // Get vendors in same provinsi
        $nearVendors = Vendor::where('provinsi', $address->provinsi)
            ->inRandomOrder()
            ->take(6)
            ->get();

        $countNear = $nearVendors->count();

        if ($countNear < 6) {
            // Get extra vendors not in same provinsi
            $extraVendors = Vendor::where('provinsi', '!=', $address->provinsi)
                ->orderBy('created_at')
                ->take(6 - $countNear)
                ->get();

            // Combine both
            $vendors = $nearVendors->concat($extraVendors);
        } else {
            $vendors = $nearVendors;
        }

        // Get favorited vendors from this user
        $favVendors = $user->favoriteVendors()->limit(8)->get();
        // dd($favVendors);

        return view('customer.home', compact('vendors', 'favVendors'));
    }
}
