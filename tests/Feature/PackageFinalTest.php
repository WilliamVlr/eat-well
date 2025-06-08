<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\CuisineType;
use Tests\TestCase;

class PackageFinalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_package_with_a_nullable_vendorId(): void
    {
        
        $category = PackageCategory::create(['categoryName' => 'Test Kategori 1']);

        $packageData = [
            'name' => 'Paket Tanpa Vendor',
            'categoryId' => $category->categoryId,
            'lunchPrice' => 25000,
        ];

        $this->post(route('packages.store'), $packageData);

        $this->assertDatabaseHas('packages', [
            'name' => 'Paket Tanpa Vendor',
            'vendorId' => null,
        ]);
    }

    /**
     * @test
     */
    public function it_can_create_a_package_with_all_fields_and_files(): void
    {
        
        $category = PackageCategory::create(['categoryName' => 'Test Kategori Lengkap']);
        $cuisine1 = CuisineType::create(['cuisineName' => 'Masakan Test 1']);
        $cuisine2 = CuisineType::create(['cuisineName' => 'Masakan Test 2']);
        $cuisineIds = [$cuisine1->cuisineId, $cuisine2->cuisineId];

        $pdfFile = UploadedFile::fake()->create('menu.pdf', 100);
        $imageFile = UploadedFile::fake()->image('gambar.jpg');

        $fullPackageData = [
            'name' => 'Paket Super Lengkap',
            'categoryId' => $category->categoryId,
            'cuisine_types' => $cuisineIds,
            'breakfastPrice' => 20000,
            'lunchPrice' => 25000,
            'dinnerPrice' => 22000,
            'averageCalories' => 550,
            'menuPDFPath' => $pdfFile,
            'imgPath' => $imageFile,
        ];

        $response = $this->post(route('packages.store'), $fullPackageData);

        $response->assertSessionHasNoErrors();
        $package = Package::where('name', 'Paket Super Lengkap')->first();
        $this->assertNotNull($package);
        $this->assertCount(2, $package->cuisineTypes);

        
        $pdfPath = public_path('asset/menus/' . $package->menuPDFPath);
        $imgPath = public_path('asset/menus/' . $package->imgPath);
        $this->assertTrue(file_exists($pdfPath));
        $this->assertTrue(file_exists($imgPath));

        
        if (file_exists($pdfPath)) unlink($pdfPath);
        if (file_exists($imgPath)) unlink($imgPath);
    }

    /**
     * @test
     */
    public function it_fails_validation_if_name_and_category_are_missing(): void
    {
        $response = $this->post(route('packages.store'), []);
        $response->assertSessionHasErrors(['name', 'categoryId']);
    }

    /**
     * @test
     */
    public function it_can_delete_a_package(): void
    {
        
        $category = PackageCategory::create(['categoryName' => 'Kategori untuk Hapus']);
        $package = Package::create([
            'categoryId' => $category->categoryId,
            'name' => 'Paket yang akan dihapus',
        ]);

        $this->delete(route('packages.destroy', $package->packageId));

        $this->assertSoftDeleted('packages', [
            'packageId' => $package->packageId,
        ]);
    }
}