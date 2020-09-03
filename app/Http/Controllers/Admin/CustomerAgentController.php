<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Customer;
use App\Orders;
use App\Product;
use App\Payment;
use App\Sales;
use App\SalesDetails;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Debug\Dumper;


class CustomerAgentController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }


public function custAgent(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $custSel = ($request->customer == 0) ? null : $request->customer;

        $customers = Customer::where('cust_type', $custSel)->orderby('lastname', 'asc')->get();

        $agents = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];

        #$custSel = ($request->customer == 0) ? null : $request->customer;

        if(is_null($custSel))
        {
            $reports = Customer::orderby('lastname', 'asc')->get();
        }
        else
        {
            $reports = Customer::where('cust_type', $custSel)->orderby('lastname', 'asc')->get();
        }

       

        $customerType = ['0'=>'--Select Agent--', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',]; #+ Customer::orderby('cust_type', 'asc')->lists('cust_type', 'cust_id')->all();


        $agents = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];

        return view('admin.report.custAgent', compact('dateToFormat', 'custSel', 'reports', 'customerType', 'agents'));
    }

    public function printCustAgentReport($customer)
    {
        $dateToFormat = date('Y-m-d');

        $custSel = ($cust_type == 0 || is_null($cust_type) || $cust_type == '') ? null : $cust_type;

        if(is_null($custSel))
        {
            $reports = Customer::orderby('lastname', 'asc')->get();
        }
        else
        {
            $reports = Customer::where('cust_id', $custSel)->orderby('lastname', 'asc')->get();
        }

        return view('admin.report.printCustAgent', compact('dateToFormat', 'reports', 'custSel'));
    }
}