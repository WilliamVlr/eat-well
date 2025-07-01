<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    public $orders;
    public $totalSales;
    public $periodText;

    public function __construct($orders, $totalSales, $periodText)
    {
        $this->orders = $orders;
        $this->totalSales = $totalSales;
        $this->periodText = $periodText;
    }
    public function view(): View
    {
        return view('catering.salesTable', ['orders' => $this->orders, 'totalSales' => $this->totalSales, 'periodText' => $this->periodText]);
    }
}
