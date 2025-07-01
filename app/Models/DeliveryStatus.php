<?php

namespace App\Models;

use App\Enums\DeliveryStatuses;
use App\Enums\TimeSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Type\Time;

class DeliveryStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delivery_statuses';
    protected $primaryKey = 'statusId'; // Matches your migration

    protected $fillable = [
        'orderId', // Matches your migration
        'deliveryDate', // Matches your migration
        'slot', // Matches your migration
        'status', // Matches your migration
    ];

    protected $casts = [
        'slot' => TimeSlot::class,
        'status' => DeliveryStatuses::class,
        'deliveryDate' => 'datetime', // Matches your migration
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }
}