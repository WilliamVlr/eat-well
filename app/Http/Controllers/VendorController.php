<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(){
        $vendors = Vendor::all();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Menampilkan detail dari satu vendor/catering spesifik.
     * Menggunakan Route Model Binding.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Vendor $vendor)
    {
        // Memuat relasi User dan Address secara efisien jika Anda ingin menampilkannya
        $vendor->load(['user', 'address']);
        // $packages = $vendor->packages;
        // MEMUAT PAKET DENGAN RELASI CATEGORY DAN CUISINE_TYPES SECARA EFFICIENT
        // Pastikan Anda telah mendefinisikan relasi 'packages' di model Vendor
        // dan relasi 'category' serta 'cuisineTypes' di model Package.
        $packages = $vendor->packages()->with(['category', 'cuisineTypes'])->get();

        return view('cateringDetail', compact('vendor', 'packages'));
    }

    public function search(Request $request)
    {
        // Get all vendors, 9 per page
        $vendors = Vendor::paginate(9);

        // Pass paginated vendors to the view
        return view('customer.search', compact('vendors'));
    }

     public function updateOrderSummary(Request $request)
    {
        $selectedPackages = $request->input('packages', []); // Ambil data 'packages' dari permintaan AJAX

        $totalItems = 0;
        $totalPrice = 0;

        foreach ($selectedPackages as $packageId => $packageData) {
            // Temukan paket dari database untuk mendapatkan harga sebenarnya
            $package = Package::find($packageId);

            if ($package) {
                // Pastikan $packageData['items'] ada dan merupakan array
                if (isset($packageData['items']) && is_array($packageData['items'])) {
                    foreach ($packageData['items'] as $itemName => $qty) {
                        $itemPrice = 0;
                        if ($itemName === 'Breakfast' && !is_null($package->breakfastPrice)) {
                            $itemPrice = (float) $package->breakfastPrice;
                        } elseif ($itemName === 'Lunch' && !is_null($package->lunchPrice)) {
                            $itemPrice = (float) $package->lunchPrice;
                        } elseif ($itemName === 'Dinner' && !is_null($package->dinnerPrice)) {
                            $itemPrice = (float) $package->dinnerPrice;
                        }

                        $qty = (int) $qty;

                        $totalItems += $qty;
                        $totalPrice += $qty * $itemPrice;
                    }
                }
            }
        }

        // Kembalikan total yang diperbarui sebagai respons JSON
        return response()->json([
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
            // Anda bisa mengembalikan lebih banyak data jika diperlukan, misal total per-paket
        ]);
    }
}
