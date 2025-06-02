<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

// This model represents the pivot table 'package_cuisine'
class PackageCuisine extends Model
{
    use HasFactory;

    protected $table = 'package_cuisine';
    // No primary key, as it's a composite primary key
    public $incrementing = false; // Disable auto-incrementing for composite primary key
    protected $primaryKey = ['packageId', 'cuisineId']; // Define composite primary key

    protected $fillable = [
        'packageId',
        'cuisineId',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'packageId', 'packageId');
    }

    public function cuisineType()
    {
        return $this->belongsTo(CuisineType::class, 'cuisineId', 'cuisineId');
    }
}