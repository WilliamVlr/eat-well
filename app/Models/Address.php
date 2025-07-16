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
        'userId',
        'provinsi',
        'kota',
        'kabupaten', 
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'jalan',
        'recipient_name',
        'recipient_phone',
        'is_default',
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