<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class PackageCuisine extends Model
{
    use HasFactory;

    protected $table = 'package_cuisine';
    public $timestamps = true;

    protected $fillable = [
        'packageId',
        'cuisineId',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'packageId');
    }

    public function cuisineType()
    {
        return $this->belongsTo(CuisineType::class, 'cuisineId');
    }
}

