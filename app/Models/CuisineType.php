<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuisineType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuisine_types';
    protected $primaryKey = 'cuisineId'; // Matches your migration

    protected $fillable = [
        'cuisineName', // Matches your migration
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function packages()
    {
        // This is a many-to-many relationship with Package through 'package_cuisine'
        return $this->belongsToMany(Package::class, 'package_cuisine', 'cuisineId', 'packageId');
        // atau:
        // return $this->hasMany(Package::class, 'cuisineId', 'cuisineId');
    }
}
