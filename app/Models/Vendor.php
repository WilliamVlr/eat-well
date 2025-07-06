<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

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
        'provinsi', // Added based on your migration
        'kota',
        'kabupaten', // Added based on your migration
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'jalan',
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
        return $this->belongsToMany(User::class, 'favorite_vendors', 'vendorId', 'userId')->withTimestamps();
    }

    public function favorited()
    {
        return (bool) FavoriteVendor::where('userId', Auth::id())
            ->where('vendorId', $this->id)
            ->first();
    }

    public function isFavoritedBy($userId)
    {
        return $this->favoriteVendors()->where('userId', $userId)->exists();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'vendorId', 'vendorId');
    }

    public function carts()
    {
        return $this->hasOne(Cart::class, 'vendorId', 'vendorId');
    }

    public function previews()
    {
        return $this->hasMany(VendorPreview::class, 'vendorId', 'vendorId');
    }
}