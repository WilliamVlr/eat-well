<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'packages';
    protected $primaryKey = 'packageId'; // Matches your migration

    protected $fillable = [
        'categoryId', // Matches your migration
        'vendorId', // Matches your migration
        'name',
        'menuPDFPath', // Matches your migration
        'imgPath', // Matches your migration
        'averageCalories', // Matches your migration
        'breakfastPrice', // Matches your migration
        'lunchPrice', // Matches your migration
        'dinnerPrice', // Matches your migration
    ];

    protected $casts = [
        'averageCalories' => 'decimal:2', // Matches your migration
        'breakfastPrice' => 'decimal:2', // Matches your migration
        'lunchPrice' => 'decimal:2', // Matches your migrationz
        'dinnerPrice' => 'decimal:2', // Matches your migration
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'categoryId', 'categoryId');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendorId', 'vendorId');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'packageId', 'packageId');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'packageId', 'packageId');
    }

    public function cuisineTypes()
    {
        // This is a many-to-many relationship with CuisineType through 'package_cuisine'
        return $this->belongsToMany(CuisineType::class, 'package_cuisine', 'packageId', 'cuisineId');
    }

}
