<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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
    public function show(Vendor $vendor)
    {
        // Memuat relasi User dan Address secara efisien jika Anda ingin menampilkannya
        $vendor->load(['user', 'address']);
        // MEMUAT PAKET DENGAN RELASI CATEGORY DAN CUISINE_TYPES SECARA EFFICIENT
        // Pastikan Anda telah mendefinisikan relasi 'packages' di model Vendor
        // dan relasi 'category' serta 'cuisineTypes' di model Package.
        $packages = $vendor->packages()->with(['category', 'cuisineTypes'])->get();

        return view('cateringDetail', compact('vendor', 'packages'));
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

        // Pass paginated vendors to the view
        return view('customer.search', compact('vendors', 'all_categories'));
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
