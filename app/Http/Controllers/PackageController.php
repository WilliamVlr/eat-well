<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\CuisineType;
use App\Models\PackageCuisine;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PackagesImport;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    // Menampilkan semua package
    public function index()
    {
        // $vendorId = Auth::id();
        // $vendorId = 24;
        $vendorId = Auth::user()->vendor->vendorId ?? 24;

        $packages = Package::with('cuisineTypes', 'category')
            ->where('vendorId', $vendorId)
            ->get();

        $cuisines = CuisineType::all();
        return view('manageCateringPackage', compact('packages', 'cuisines'));
    }

    // Menyimpan data package baru
    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'categoryId'       => 'required|integer',
            'vendorId'         => 'nullable|integer',
            'name'             => 'required|string|max:255',

            'averageCalories'  => 'nullable|numeric|gt:0',
            'breakfastPrice'   => 'nullable|numeric|gt:0',
            'lunchPrice'       => 'nullable|numeric|gt:0',
            'dinnerPrice'      => 'nullable|numeric|gt:0',

            'menuPDFPath'      => 'nullable|file|mimes:pdf',
            'imgPath'          => 'nullable|image|mimes:jpeg,png,jpg',
        ]);
        $validated['vendorId'] = Auth::id() ?? 24;

        // Upload file PDF ke public/asset/menus
        if ($request->hasFile('menuPDFPath')) {
            $menuFile = $request->file('menuPDFPath');
            $menuFileName = 'menu_' . time() . '.' . $menuFile->getClientOriginalExtension();
            $menuFile->move(public_path('asset/menus'), $menuFileName);
            $validated['menuPDFPath'] = $menuFileName;
        }

        // Upload gambar ke public/asset/menus
        if ($request->hasFile('imgPath')) {
            $imgFile = $request->file('imgPath');
            $imgFileName = 'img_' . time() . '.' . $imgFile->getClientOriginalExtension();
            $imgFile->move(public_path('asset/menus'), $imgFileName);
            $validated['imgPath'] = $imgFileName;
        }


        // Ambil cuisine_types terpisah
        $cuisineTypes = $validated['cuisine_types'] ?? [];

        // Hapus dari validated array
        unset($validated['cuisine_types']);

        // Simpan ke database (tanpa cuisine_types)
        $newpackage = Package::create($validated);

        if (!empty($cuisineTypes)) {
            $newpackage->cuisineTypes()->sync($cuisineTypes);
        }

        return redirect(route('manageCateringPackage'));
    }

    // Menghapus package berdasarkan ID
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully'
        ]);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'categoryId'      => 'required|integer',

            'breakfastPrice'  => 'nullable|decimal:0,2|gte:0',
            'lunchPrice'      => 'nullable|decimal:0,2|gte:0',
            'dinnerPrice'     => 'nullable|decimal:0,2|gte:0',
            'averageCalories' => 'nullable|decimal:0,2|gte:0',

            'menuPDFPath'     => 'nullable|file|mimes:pdf',
            'imgPath'         => 'nullable|image|mimes:jpeg,png,jpg',

            'cuisine_types'   => 'nullable|array',
            'cuisine_types.*' => 'exists:cuisine_types,cuisineId',
        ]);


        $package = Package::findOrFail($id);

        // Upload file PDF ke public/asset/menus
        if ($request->hasFile('menuPDFPath')) {
            $menuFile = $request->file('menuPDFPath');
            $menuFileName = 'menu_' . time() . '.' . $menuFile->getClientOriginalExtension();
            $menuFile->move(public_path('asset/menus'), $menuFileName);
            $validated['menuPDFPath'] = $menuFileName;
        }

        // Upload gambar ke public/asset/menus
        if ($request->hasFile('imgPath')) {
            $imgFile = $request->file('imgPath');
            $imgFileName = 'img_' . time() . '.' . $imgFile->getClientOriginalExtension();
            $imgFile->move(public_path('asset/menus'), $imgFileName);
            $validated['imgPath'] = $imgFileName;
        }

        $package->update($validated);

        return redirect()->back()->with('success', 'Berhasil mengubah paket!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new PackagesImport, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Packages imported successfully!');
    }
}
