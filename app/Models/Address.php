<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $primaryKey = 'addressId';

    protected $fillable = [
        // 'userId', // Not in your address migration. If Address belongs to a User, add userId to migration.
        'provinsi', // Added based on your migration
        'kota',
        'kabupaten', // Added based on your migration
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'jalan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // If address belongs to user, uncomment and adjust:
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }
}