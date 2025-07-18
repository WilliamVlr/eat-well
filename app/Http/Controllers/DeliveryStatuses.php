<?php

namespace App\Http\Controllers;

use App\Models\DeliveryStatus;
use App\Enums\DeliveryStatuses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class DeliveryStatusController extends Controller
{
    public function update(Request $request, $orderId, $slot)
    {

        $request->validate([
            'status' => ['required', new Enum(DeliveryStatuses::class)],
        ]);

        $delivery = DeliveryStatus::firstOrNew([
            'orderId'      => $orderId,
            'slot'         => $slot,
            'deliveryDate' => now()->toDateString(),   // sesuaikan logika tanggalmu
        ]);

        $delivery->status = DeliveryStatuses::from($request->status);
        $delivery->save();

        return response()->json(['success' => true]);
    }
}
