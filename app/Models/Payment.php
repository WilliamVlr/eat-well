<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'paymentId'; // Matches your migration

    protected $fillable = [
        'methodId', // Matches your migration
        'orderId', // Matches your migration
        'paid_at', // Matches your migration
    ];

    protected $casts = [
        'paid_at' => 'datetime', // Matches your migration
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'methodId', 'methodId');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }

    // Based on your migration, 'payments' table does not have a direct 'userId'.
    // If you intend for payments to be directly linked to users, you need to add 'userId' column to 'payments' table in your migration.
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'userId', 'userId');
    // }
}