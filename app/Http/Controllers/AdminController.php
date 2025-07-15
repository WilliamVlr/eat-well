<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\UserActivity;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function viewAllVendors()
    {
        // $orders = Order::all();



        $vendors = Vendor::all();

        $sales = DB::table('orders')
            ->select('vendorId', DB::raw('SUM(totalPrice) as totalSales'))
            ->groupBy('vendorId')
            ->pluck('totalSales', 'vendorId');

        return view('viewAllVendor', compact('vendors', 'sales'));

        // return view('viewAllVendor', compact('vendors'));
    }

    public function search(Request $request)
    {

        $name = $request->name;

        // $vendors = Vendor::where('name', 'like','%' .$name . '%')->get();
        $vendors = Vendor::where('name', 'like', '%' . $name . '%')->get();
        // $vendors->load('address');
        // $addresses =  Address::where('addressId', $request->addressId)->get();
        $sales = DB::table('orders')
            ->select('vendorId', DB::raw('SUM(totalPrice) as totalSales'))
            ->groupBy('vendorId')
            ->pluck('totalSales', 'vendorId');

        return view('viewAllVendor', compact('vendors', 'sales'));


        // return view('viewAllVendor', compact('vendors'));
    }

    public function view_all_logs()
    {
        $all_logs = UserActivity::all();

        return view('view-all-logs', compact('all_logs'));
    }

    public function view_all_payment()
    {
        $payments = PaymentMethod::all();

        return view('view-all-payment', compact('payments'));
    }

    public function delete_payment(string $id)
    {
        $payment = PaymentMethod::query()->find($id);
        $payment->delete();

        $payments = PaymentMethod::all();


        // Session::flash('message', 'Successfully delete payment !');
        // return view('view-all-payment', compact('payments'));
        // return redirect()->route('view-all-payment');
        return redirect()->route('view-all-payment')->with('message_del', 'Successfully delete payment method!');
    }

    public function add_new_payment(Request $request)
    {
        // $name = $request->payment-method;
        // $newPayment = PaymentMethod::create();

        // $newPayment->name = $request->paymentMethod;

        // $newPayment->save();

        $newPayment = PaymentMethod::create([
            'name' => $request->paymentMethod
        ]);

        $payments = PaymentMethod::all();
        
        // Session::flash('message_add', 'Successfully added payment !');
        // return view('view-all-payment', compact('payments'));
        return redirect()->route('view-all-payment')->with('message_add', 'Successfully added payment method!');

        // return redirect()->route('view-all-payment');
    }
}