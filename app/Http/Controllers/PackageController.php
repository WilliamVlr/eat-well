<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\CuisineType;
use App\Models\PackageCuisine;

class PackageController extends Controller
{
    // Menampilkan semua package
    public function index()
    {
        $packages = Package::with('cuisineTypes')->get();
        $cuisines = CuisineType::all(); // Ambil semua cuisine
        logActivity('Successfully', 'Visited', 'Manage Catering Package Page');
        return view('manageCateringPackage', compact('packages', 'cuisines'));
    }

    // Menyimpan data package baru
    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate(([
            'categoryId' => 'required|integer',
            'vendorId' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'averageCalories' => 'nullable|numeric',
            'breakfastPrice' => 'nullable|numeric',
            'lunchPrice' => 'nullable|numeric',
            'dinnerPrice' => 'nullable|numeric',
            'menuPDFPath' => 'nullable|file|mimes:pdf',
            'imgPath' => 'nullable|image|mimes:jpeg,png,jpg',
            'cuisine_types' => 'nullable|array',
            'cuisine_types.*' => 'exists:cuisine_types,cuisineid'
        ]));

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

        logActivity('Successfully', 'Added', 'Catering Package');
        return redirect(route('manageCateringPackage'));
    }

    // Menghapus package berdasarkan ID
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        logActivity('Successfully', 'Deleted', 'Catering Package');

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully'
        ]);
    }

    public function update(Package $package,  Request $request)
    {

        $validated = $request->validate(([
            'categoryId' => 'required|integer',
            'vendorId' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'averageCalories' => 'nullable|numeric',
            'breakfastPrice' => 'nullable|numeric',
            'lunchPrice' => 'nullable|numeric',
            'dinnerPrice' => 'nullable|numeric',
            'menuPDFPath' => 'nullable|file|mimes:pdf',
            'imgPath' => 'nullable|image|mimes:jpeg,png,jpg',
            'cuisine_types' => 'nullable|array',
            'cuisine_types.*' => 'exists:cuisine_types,id'
        ]));

        $package->update($validated);

        logActivity('Successfully', 'Updated', 'Catering Package');
        return redirect(route('manageCateringPackage'));
    }
}
