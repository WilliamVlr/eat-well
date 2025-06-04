<?php

namespace App\Http\Controllers;

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
        // Laravel secara otomatis akan menemukan vendor berdasarkan ID dari URL ({vendor})
        // dan menyediakannya sebagai objek $vendor.
        // Jika tidak ditemukan, Laravel akan otomatis melempar 404 Not Found.

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
}
