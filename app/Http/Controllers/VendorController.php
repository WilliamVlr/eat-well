<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Vendor;
use App\Models\User;
use App\Models\VendorReview;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        $categories = PackageCategory::all();
        return view('vendors.index', compact('vendors', 'categories'));
    }

    /**
     * Menampilkan detail dari satu vendor/catering spesifik.
     * Menggunakan Route Model Binding.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Vendor $vendor, Request $request)
    {
        // Memuat relasi User dan Address secara efisien jika Anda ingin menampilkannya
        $vendor->load(['user', 'previews']);
        // MEMUAT PAKET DENGAN RELASI CATEGORY DAN CUISINE_TYPES SECARA EFFICIENT
        // Pastikan Anda telah mendefinisikan relasi 'packages' di model Vendor dan relasi 'category' serta 'cuisineTypes' di model Package.
        $packages = $vendor->packages()->with(['category', 'cuisineTypes'])->get();
        $numSold = Order::where('vendorId', $vendor->vendorId)->count();

        $selectedAddressId = $request->query('address_id');

        Log::info('VendorController@show: selectedAddressId received = ' . $selectedAddressId);

        $selectedAddress = null;
        if ($selectedAddressId) {
            $selectedAddress = Address::find($selectedAddressId);
            // Opsional: Pastikan alamat ini milik user yang sedang login
            if ($selectedAddress && Auth::check() && $selectedAddress->userId !== Auth::id()) {
                $selectedAddress = null; // Abaikan jika bukan milik user
            }
        }

        // Fallback jika tidak ada address_id di query string atau tidak valid
        if (!$selectedAddress && Auth::check()) {
            $user = Auth::user();
            // Jika Anda punya relasi defaultAddress di model User:
            if (method_exists($user, 'defaultAddress')) {
                $selectedAddress = $user->defaultAddress;
            } else {
                // Atau cari manual jika tidak ada relasi defaultAddress (pastikan user->userId benar)
                $selectedAddress = Address::where('userId', $user->userId)
                    ->where('is_default', 1)
                    ->first();
            }
        }

        // Pastikan $selectedAddress tidak null sebelum diakses di view
        // Jika masih null, mungkin set default kosong atau tangani error
        if (!$selectedAddress) {
            // Anda bisa set default ke null atau membuat objek Address kosong
            $selectedAddress = (object)['addressId' => null, 'jalan' => 'No Address Selected'];
            // Atau redirect user untuk memilih alamat
            // return redirect()->route('search')->with('error', 'Please select a delivery address.');
        }

        return view('cateringDetail', compact('vendor', 'packages', 'numSold', 'selectedAddress'));
    }

    public function review(Vendor $vendor)
    {

        $vendorReviews = VendorReview::where('vendorId', $vendor->vendorId)
            ->with(['user', 'order']) // Load user dan order
            ->orderBy('created_at', 'desc')
            ->get();

        $numSold = Order::where('vendorId', $vendor->vendorId)->count();

        return view('ratingAndReview', compact('vendor', 'vendorReviews', 'numSold'));
    }

    public function reviewVendor()
    {
        // Ambil vendor yang sedang login
        $vendor = Auth::user(); // Pastikan user login adalah vendor

        // Ambil review dari vendor yang sedang login
        $vendorReviews = VendorReview::where('vendorId', $vendor->vendorId)
            ->with(['user', 'order']) // Load relasi user dan order
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung jumlah order yang dijual oleh vendor
        $numSold = Order::where('vendorId', $vendor->vendorId)->count();

        return view('ratingAndReviewVendor', compact('vendor', 'vendorReviews', 'numSold'));
    }

    public function search(Request $request)
    {
        // Get request query
        $query = $request->query('query');
        $minPrice = $request->query('min_price') ?? 0;
        $maxPrice = $request->query('max_price') ?? 999999999;
        $rating = $request->query('rating');
        $categories = $request->query('category', []);
        $all_categories = PackageCategory::all();

        $vendors = \App\Models\Vendor::query()
            // Search by vendor name or related models — grouped properly
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhereHas('packages', function ($q2) use ($query) {
                            $q2->where('name', 'like', "%{$query}%")
                                ->orWhereHas('category', function ($q3) use ($query) {
                                    $q3->where('categoryName', 'like', "%{$query}%");
                                })
                                ->orWhereHas('cuisineTypes', function ($q4) use ($query) {
                                    $q4->where('cuisineName', 'like', "%{$query}%");
                                });
                        });
                });
            })

            // Filter by rating
            ->when($rating, function ($q) use ($rating) {
                $q->where('rating', '>=', $rating);
            })

            // Filter by category (package's category)
            ->when($categories, function ($q) use ($categories) {
                $q->whereHas('packages.category', function ($q2) use ($categories) {
                    $q2->whereIn('categoryName', (array) $categories);
                });
            })

            // Filter by price range (any package price in range)
            ->when($minPrice || $maxPrice, function ($q) use ($minPrice, $maxPrice) {
                $q->whereHas('packages', function ($q2) use ($minPrice, $maxPrice) {
                    $q2->where(function ($q3) use ($minPrice, $maxPrice) {
                        if ($minPrice) {
                            $q3->where(function ($q4) use ($minPrice) {
                                $q4->where('breakfastPrice', '>=', $minPrice)
                                    ->orWhere('lunchPrice', '>=', $minPrice)
                                    ->orWhere('dinnerPrice', '>=', $minPrice);
                            });
                        }
                        if ($maxPrice) {
                            $q3->where(function ($q4) use ($maxPrice) {
                                $q4->where('breakfastPrice', '<=', $maxPrice)
                                    ->orWhere('lunchPrice', '<=', $maxPrice)
                                    ->orWhere('dinnerPrice', '<=', $maxPrice);
                            });
                        }
                    });
                });
            })

            // Include relations
            ->with(['packages.category', 'packages.cuisineTypes'])

            // Avoid duplicate vendors due to joins
            ->distinct()

            // Paginate results and keep filters in URL
            ->paginate(9)
            ->appends($request->query());

        Auth::check();
        $user =  Auth::user();

        $mainAddress = null;
        $addressIdFromUrl = $request->query('address_id');

        if ($addressIdFromUrl) {
            // Coba temukan alamat berdasarkan ID dari URL
            $mainAddress = Address::find($addressIdFromUrl);
            // Validasi: pastikan alamat ini milik user yang sedang login
            if ($mainAddress && $user && $mainAddress->userId !== $user->userId) {
                $mainAddress = null; // Abaikan jika bukan milik user
            }
        }

        // Fallback: Jika tidak ada address_id di URL atau tidak valid, gunakan alamat default user
        if (!$mainAddress && $user) {
            if (method_exists($user, 'defaultAddress')) { // Jika ada relasi defaultAddress di model User
                $mainAddress = $user->defaultAddress;
            } else {
                // Alternatif jika tidak ada relasi defaultAddress (cari manual is_default = 1)
                $mainAddress = Address::where('userId', $user->userId)
                    ->where('is_default', 1)
                    ->first();
            }
        }

        // Pass paginated vendors to the view
        return view('customer.search', compact('vendors', 'all_categories', 'user', 'mainAddress'));
    }
}
