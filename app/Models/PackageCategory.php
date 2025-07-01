<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'package_categories';
    protected $primaryKey = 'categoryId';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'categoryName',
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
