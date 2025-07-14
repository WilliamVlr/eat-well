<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VendorController extends Controller
{

    public function display()
    {
            return view('cateringHomePage');
    }


    public function index()
    {
        // dd(Auth()->user);
        // $vendors = Vendor::all();
        // $categories = PackageCategory::all();

        // if(!$vendors->name){
        //     return redirect('cateringHomePage');
        // }
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
        $vendor->load(['user']);
        // MEMUAT PAKET DENGAN RELASI CATEGORY DAN CUISINE_TYPES SECARA EFFICIENT
        // Pastikan Anda telah mendefinisikan relasi 'packages' di model Vendor
        // dan relasi 'category' serta 'cuisineTypes' di model Package.
        $packages = $vendor->packages()->with(['category', 'cuisineTypes'])->get();
        $numSold = Order::where('vendorId', $vendor->vendorId)->count();

        return view('cateringDetail', compact('vendor', 'packages', 'numSold'));
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

    public function store(Request $request){
        // validating
        // dd($request);
        $userId = Auth::id();
        // dd($userId);

        $vendor = Vendor::where('userId', $userId)->first();

        // dd($vendor);
        $validated = $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg',
            'name' => 'required|string|max:255',
            'startBreakfast' => 'nullable',
            'closeBreakfast' => 'nullable',
            'startLunch' => 'nullable',
            'closeLunch' => 'nullable',
            'startDinner' => 'nullable',
            'closeDinner' => 'nullable',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'kode_pos' => 'required|string|max:5',
            'phone_number' => 'required|string',
            'jalan' => 'required|string',
        ]);

        // dd($validated);

        // upload logo
        $logoPath = null;
        
        $file = $request->file('logo');
        // dd($file);
        $filename = time().'_'.$file->getClientOriginalName();
        // dd($filename);
        $file->storeAs('public/vendor_logos', $filename);
        // dd($file);
        $logoPath = 'vendor_logos/'.$filename;
        // dd($logoPath);
        // format delivery times
       // Convert and combine delivery times from 12-hour format (like "05:30 PM") to "HH:MM-HH:MM"
        $breakfast = $request->startBreakfast && $request->closeBreakfast
            ? $request->startBreakfast. '-' .$request->closeBreakfast
            : null;
        // dd($breakfast);

        $lunch = $request->startLunch && $request->closeLunch
            ? $request->startLunch. '-' .$request->closeLunch
            : null;
        // dd($lunch);

        $dinner = $request->startDinner && $request->closeDinner
            ? $request->startDinner . '-' . $request->closeDinner
            : null;
        // dd($dinner);

        /** @var User|Authenticable $user */
        // $user = Auth::user();
        // dd($user);
        // $vendor = $user->vendor();
        // dd($vendor);
        //Vendor udah kebuat, tinggal update datanya satu2

        // $userid = Auth::user()->userId;

        // $vendor = Vendor::query()->find($userid);
        
        // dd($vendor);
        // Store the vendor
        
        $vendor->update([
            'name'=> $validated['name'],
            'logo' => $logoPath, 
            'phone_number'=> $validated['phone_number'],
            'breakfast_delivery'=> $breakfast,
            'lunch_delivery'=> $lunch,
            'dinner_delivery'=> $dinner,
            'provinsi'=> $validated['provinsi'],
            'kota'=> $validated['kota'],
            'kabupaten'=> $validated['kota'],
            'kecamatan'=> $validated['kecamatan'],
            'kelurahan'=> $validated['kelurahan'],
            'kode_pos' => $validated['kode_pos'],
            'jalan' => $validated['jalan'],
            'rating' => 0.0,
        ]);
        // ]);

        return redirect('cateringHomePage');
    }
}