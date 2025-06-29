<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';
    protected $primaryKey = 'vendorId'; // Matches your migration

    protected $fillable = [
        'userId',
        // 'addressId',
        'name', // Added based on your migration
        'breakfast_delivery',
        'lunch_delivery',
        'dinner_delivery',
        // 'description',
        'logo',
        'phone_number', // Added based on your migration
        'rating', // Added based on your migration
    ];

    protected $casts = [
        'rating' => 'decimal:1', // Matches your migration
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    // public function address()
    // {
    //     return $this->hasOne(Address::class, 'addressId', 'addressId');
    // }

    public function packages()
    {
        return $this->hasMany(Package::class, 'vendorId', 'vendorId');
    }

    public function vendorReviews()
    {
        return $this->hasMany(VendorReview::class, 'vendorId', 'vendorId');
    }

    public function favoriteVendors()
    {
        return $this->hasMany(FavoriteVendor::class, 'vendorId', 'vendorId');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'vendorId', 'vendorId');
    }

    public function carts()
    {
        return $this->hasOne(Cart::class, 'vendorId', 'vendorId');
    }
}