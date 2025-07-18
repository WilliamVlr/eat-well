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
    protected $primaryKey = 'statusId';

    protected $fillable = [
        'orderId', 
        'deliveryDate', 
        'slot', 
        'status', 
    ];

    protected $casts = [
        'slot' => 'string',
        'status' => DeliveryStatuses::class,
        'deliveryDate' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }
}
