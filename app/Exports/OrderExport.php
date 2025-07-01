<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::check() ? Auth::user() : 0;
        if($user->role == 'Vendor'){
            $vendor = $user->vendor;
            dd($vendor);
        }
        $orders = 0;
    }
}
