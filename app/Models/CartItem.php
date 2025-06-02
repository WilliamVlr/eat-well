<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    // No primary key, as it's a composite primary key in migration
    public $incrementing = false; // Disable auto-incrementing for composite primary key
    protected $primaryKey = ['cartId', 'packageId']; // Define composite primary key

    protected $fillable = [
        'cartId',
        'packageId',
        'breakfastQty', // Matches your migration
        'lunchQty', // Matches your migration
        'dinnerQty', // Matches your migration
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartId', 'cartId');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'packageId', 'packageId');
    }
}