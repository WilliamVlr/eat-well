<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Exports\OrderExport;
use App\Exports\SalesExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CateringHomeController extends Controller
{
    public function index()
    {
        return view('cateringHomePage');
    }
}
