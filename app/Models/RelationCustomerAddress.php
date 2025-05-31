<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class RelationCustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'relation_customer_addresses';
    // No primary key, as it's a composite primary key in migration
    public $incrementing = false; // Disable auto-incrementing for composite primary key
    protected $primaryKey = ['customerId', 'addressId']; // Define composite primary key

    protected $fillable = [
        'customerId', // Matches your migration
        'addressId', // Matches your migration
        'recepient_name', // Matches your migration
        'recepient_phone', // Matches your migration
        'is_default', // Matches your migration
        'notes',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'addressId', 'addressId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customerId', 'userId'); // customerId in relation_customer_addresses links to userId in users
    }
}