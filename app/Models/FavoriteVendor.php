<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class FavoriteVendor extends Model
{
    use HasFactory;

    protected $table = 'favorite_vendors';
    // No primary key, as it's a composite primary key in migration
    public $incrementing = false; // Disable auto-incrementing for composite primary key
    protected $primaryKey = ['userId', 'vendorId']; // Define composite primary key

    protected $fillable = [
        'userId',
        'vendorId',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendorId', 'vendorId');
    }
}