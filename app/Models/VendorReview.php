<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    use HasFactory;

    protected $table = 'vendor_reviews';
    protected $primaryKey = 'reviewId'; // Matches your migration

    protected $fillable = [
        'vendorId', // Matches your migration
        'userId', // Matches your migration
        'orderId', // Matches your migration
        'rating',
        'review', // Matches your migration
    ];

    protected $casts = [
        'rating' => 'decimal:1', // Matches your migration
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendorId', 'vendorId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }
}