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

        logActivity('Successfully', 'Visited', 'Catering Detail Page');
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
        logActivity('Successfully', 'Visited', "Vendor Search Page and Searched for: {$query}");
        return view('customer.search', compact('vendors', 'all_categories', 'user', 'mainAddress'));
    }

    public function manageProfile()
    {
        // untuk kasih breakfast delivery, jam menitnya, ambil dulu variable nya, lalu pecah, jadi jam 1 dan 2
        $user = Auth::user();
        $vendor = Vendor::where('userId', $user->userId)->first();

        $breakfastDelivery = $vendor->breakfast_delivery;
        $lunchDelivery = $vendor->lunch_delivery;
        $dinnerDelivery = $vendor->dinner_delivery;

        $breakfastStart = explode('-', $breakfastDelivery)[0];
        $breakfastEnd = explode('-', $breakfastDelivery)[1];
        $lunchStart = explode('-', $lunchDelivery)[0];
        $lunchEnd = explode('-', $lunchDelivery)[1];
        $dinnerStart = explode('-', $dinnerDelivery)[0];
        $dinnerEnd = explode('-', $dinnerDelivery)[1];

        $bsh = explode(':', $breakfastStart)[0];
        $bsm = explode(':', $breakfastStart)[1];
        $beh = explode(':', $breakfastEnd)[0];
        $bem = explode(':', $breakfastEnd)[1];
        $lsh = explode(':', $lunchStart)[0];
        $lsm = explode(':', $lunchStart)[1];
        $leh = explode(':', $lunchEnd)[0];
        $lem = explode(':', $lunchEnd)[1];
        $dsh = explode(':', $dinnerStart)[0];
        $dsm = explode(':', $dinnerStart)[1];
        $deh = explode(':', $dinnerEnd)[0];
        $dem = explode(':', $dinnerEnd)[1];

        logActivity('Successfully', 'Visited', 'Manage Profile Vendor Page');

        return view('manage-profile-vendor', compact(
            'user',
            'vendor',
            'bsh',
            'bsm',
            'beh',
            'bem',
            'lsh',
            'lsm',
            'leh',
            'lem',
            'dsh',
            'dsm',
            'deh',
            'dem'
        ));
    }

    public function updateProfile(Request $request)
    {
        try {
            // dd($request);
            $user = Auth::user();
            $userId = $user->userId;
            $vendor = Vendor::where('userId', $userId)->first();

            $request_validation = $request->validate(
                [
                    'nameInput' => 'required|string|max:255',
                    'telpInput' => 'required|string|max:255',
                ],
                [
                    'nameInput.required' => 'Vendor name must be filled !.',
                    'telpInput.required' => 'Telp number must be filled !',
                ]
            );

            $vendor->name = $request->nameInput;
            $vendor->phone_number = $request->telpInput;

            $vendor->breakfast_delivery = $request->breakfast_hour_start . ':' . $request->breakfast_minute_start . '-' .
                $request->breakfast_hour_end . ':' . $request->breakfast_minute_end;
            $vendor->lunch_delivery = $request->lunch_hour_start . ':' . $request->lunch_minute_start . '-' .
                $request->lunch_hour_end . ':' . $request->lunch_minute_end;
            $vendor->dinner_delivery = $request->dinner_hour_start . ':' . $request->dinner_minute_start . '-' .
                $request->dinner_hour_end . ':' . $request->dinner_minute_end;

            if ($request->hasFile('profilePicInput')) {
                $file = $request->file('profilePicInput');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('asset/profile'), $filename);
                $vendor->logo = 'asset/profile/' . $filename;
            }

            $vendor->save();

            logActivity('Successfully', 'Updated', 'Manage Profile Vendor Page');
            return redirect()->route('manage-profile-vendor')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Log::error('Error updating vendor profile: ' . $e->getMessage());
            logActivity('Failed', 'Updated', 'Vendor Profile, Due to Validation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update profile.']);
        }
    }
}
