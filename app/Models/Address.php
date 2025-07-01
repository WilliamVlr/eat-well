<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

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
        'recipient_name', // Matches your migration
        'recipient_phone', // Matches your migration
        'is_default', // Matches your migration
        'notes',
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