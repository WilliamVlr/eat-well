<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'package_categories';
    protected $primaryKey = 'categoryId'; // Matches your migration

    protected $fillable = [
        'categoryName', // Matches your migration
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'categoryId', 'categoryId');
    }
}