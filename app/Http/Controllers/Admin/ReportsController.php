<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Customer;
use App\Product;
use App\Sales;
use App\SalesDetails;
use App\Delivery;
use App\DeliveryDetails;
use App\Expenses;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $option = (!is_null($request->option)) ? $request->option : 1;
        $monthSel = (!is_null($request->monthly)) ? $request->monthly : 1;
        if(strlen($monthSel) == 1)
        {
            $monthSel = '0'.$monthSel;
        }

        $daySel = (!is_null($request->daily)) ? $request->daily : $dateToFormat;

        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($request->year == '') ? date('Y') : $request->year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];

            while($startYear <= $endYear)
            {
                $years[$startYear] = $startYear;
                $startYear++;
            }

        $month = $request->monthly;

        #dd($request->all());

       if(!is_null($request->monthly))
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
        }
        else
        {
            $day = (strlen($request->daily) < 2) ? ('0'.$request->daily) : $request->daily;

            $reportStart = $daySel.' 00:00:00';
            $reportEnd = $daySel.' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
        }

        $sumSales = 0;
        $sumCredit =0;

        foreach($reports as $report)
        {
             $sumSales += $report->totalsales;
             $sumCredit += $report->myPayment->where('sales_id', $report->sales_id)->latest('payment_id')->first()->balancedue;
        }

        //$sumCash = $sumSales - $sumCredit;

        return view('admin.report.index', compact('dateToFormat', 'years', 'yearSel', 'months', 'monthSel', 'day', 'daySel', 'reports', 'sumSales', 'option'));
    }

    public function printReport($option, $day, $month)
    {
         $dateToFormat = date('Y-m-d');

        if($option == 2)
        {
            $reportStart = date('Y-'.$month.'-01').' 00:00:00';
            $reportEnd = date('Y-'.$month.'-31').' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
        }
        else
        {
            $reportStart = $day.' 00:00:00';
            $reportEnd = $day.' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
        }

        $sumSales = 0;
        $sumCredit =0;


        foreach($reports as $report)
        {
            #$sumSales += $report->myPayments->sum('amountpaid');
            $sumSales += $report->totalsales;
            $sumCredit += $report->myPayment->where('sales_id', $report->sales_id)->latest('payment_id')->first()->balancedue;
        }

        $sumCash = $sumSales - $sumCredit;

        return view('admin.report.print', compact('dateToFormat', 'reports', 'reportStart', 'sumSales', 'sumCredit', 'sumCash', 'reportEnd'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function inventory(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $catSel = ($request->category == 0) ? null : $request->category;

        if(is_null($catSel))
        {
            $reports = Product::orderby('productname', 'asc')->get();
        }
        else
        {
            $reports = Product::where('category_id', $catSel)->orderby('productname', 'asc')->get();
        }
        
        $totalInventoryValue = 0;
        foreach($reports as $report)
        {
            $totalInventoryValue += $report->stock * $report->unitprice;
        }

        $categories = ['0'=>'--Select Category--'] + Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();

        return view('admin.report.inventory', compact('dateToFormat', 'catSel', 'reports', 'categories', 'totalInventoryValue'));
    }

    public function printInventoryReport($category)
    {
        $dateToFormat = date('Y-m-d');

        $catSel = ($category == 0 || is_null($category) || $category == '') ? null : $category;

        if(is_null($catSel))
        {
            $reports = Product::orderby('productname', 'asc')->get();
        }
        else
        {
            $reports = Product::where('category_id', $catSel)->orderby('productname', 'asc')->get();
        }

        $totalInventoryValue = 0;
        foreach($reports as $report)
        {
            $totalInventoryValue += $report->stock * $report->unitprice;
        }

        return view('admin.report.printinventory', compact('dateToFormat', 'reports', 'totalInventoryValue', 'catSel'));
    }

    public function custAgent(Request $request)
    {
        $custSel = ($request->customer == 0) ? null : $request->customer;

        $payments = Payment::orderby('paymentdate', 'desc');

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

         if(is_null($custSel))
         {
             $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->orderby('sales.salesdate', 'desc')
                ->paginate(25);
         }
         else
         {
            $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->where('sales.totalsales', 0)
                ->where('sales.discount', 0)
                ->where('sales.fixedAmtDiscount', 0)
                ->orderby('sales.salesdate', 'desc')
                ->orwhere('customer.bound', $custSel)
                ->paginate(25);
         }             

        foreach($credits as $credit)
        {
            $discounted = $credit->totalsales - ($credit->totalsales * ($credit->discount/100)) - $credit->fixedAmtDiscount;
            $paid = $credit->myPayments()->sum('amounttendered');        
        }

        #$customerType = ['0'=>'-Select Agent', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',];
        $customerCity = ['0'=>'-Select Place', '17'=>'Bangui/Pagudpud', '18'=>'Claveria-Pamplona', '19'=>'Abulog-Aparri', '20'=>'Sta. Marcela', '21'=>'Flora', '22'=>'Pudtol', '23'=>'Luna'];
  
        return view('admin.report.custAgent', compact('credits', 'custSel', 'customerCity', 'discounted', 'paid', 'mode', 'skey', 'payments', 'fourTerms', 'eightTerms', 'twelveTerms'));
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

    public function agent(Request $request)
    {
        $custSel = ($request->customer == 0) ? null : $request->customer;

        $payments = Payment::orderby('paymentdate', 'desc');

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

         if(is_null($custSel))
         {
             $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->orderby('sales.salesdate', 'desc')
                ->paginate(25);
         }
         else
         {
            $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->where('sales.totalsales', 0)
                ->where('sales.discount', 0)
                ->where('sales.fixedAmtDiscount', 0)
                ->orderby('sales.salesdate', 'desc')
                ->orwhere('customer.bound', $custSel)
                ->paginate(25);
         }             

        foreach($credits as $credit)
        {
            $discounted = $credit->totalsales - ($credit->totalsales * ($credit->discount/100)) - $credit->fixedAmtDiscount;
            $paid = $credit->myPayments()->sum('amounttendered');        
        }

        #$customerType = ['0'=>'-Select Agent', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',];
        $customerCity = ['0'=>'-Select Place', '1'=>'Laoag', '2'=>'San Nicolas', '3'=>'Bangui', '4'=>'Dumalneg', '5'=>'Dingras', '6'=>'Solsona', '7'=>'Piddig', '8'=>'Banna', '9'=>'Nueva Era', '10'=>'Pasuquin', '11'=>'Badoc', '12'=>'Pagudpud', '13'=>'Vintar', '14'=>'Burgos', '15'=>'Sarrat', '16'=>'Marcos'];
  
        return view('admin.report.agent', compact('credits', 'custSel', 'customerCity', 'discounted', 'paid', 'mode', 'skey', 'payments', 'fourTerms', 'eightTerms', 'twelveTerms'));
        #return view('admin.report.agent', compact('dateToFormat', 'custSel', 'reports', 'customerType'));
    }

    public function printAgentReport($customer)
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

        return view('admin.report.printagent', compact('dateToFormat', 'reports', 'custSel'));
    }




    public function sales(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $optSel = ($request->option == 0) ? 0 : $request->option;

        $monthSel = (!is_null($request->monthly)) ? $request->monthly : 0;
        $months = [
            '0' => '--Select Month--',
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($request->yearly == '') ? date('Y') : $request->yearly;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];
        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        if($optSel > 0)
        {
            if($monthSel != 0)
            {
                $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
                $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->where('customer.cust_type', $optSel)->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
            else
            {
                $reportStart = date($yearSel.'-m-01').' 00:00:00';
                $reportEnd = date($yearSel.'-m-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->where('customer.cust_type', $optSel)->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
           
            }
        }
        else
        {
            if($monthSel != 0)
            {
                $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
                $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
            else
            {
                $reportStart = date($yearSel.'-m-01').' 00:00:00';
                $reportEnd = date($yearSel.'-m-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
        }

        return view('admin.report.sales', compact('dateToFormat', 'months', 'years', 'monthSel', 'yearSel', 'reports', 'optSel'));
    }

    public function salesPrint($option, $year, $month)
    {
        $dateToFormat = date('Y-m-d');

        if($option > 0)
        {
            if($month != 0)
            {
                $reportStart = date($year.'-'.$month.'-01').' 00:00:00';
                $reportEnd = date($year.'-'.$month.'-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->where('customer.cust_type', $option)->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
            else
            {
                $reportStart = date($year.'-m-01').' 00:00:00';
                $reportEnd = date($year.'-m-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->where('customer.cust_type', $option)->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
        }
        else
        {
            if($month != 0)
            {
                $reportStart = date($year.'-'.$month.'-01').' 00:00:00';
                $reportEnd = date($year.'-'.$month.'-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
            else
            {
                $reportStart = date($year.'-m-01').' 00:00:00';
                $reportEnd = date($year.'-m-31').' 23:59:59';

                $reports = Sales::join('customer', 'sales.cust_id', '=', 'customer.cust_id')->wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
            }
        }

        return view('admin.report.salesprint', compact('dateToFormat','reports', 'option', 'reportEnd', 'reportStart'));
    }

    public function customers(Request $request)
    {
        $key = ($request->key == '') ? null : $request->key;

        if(!is_null($key))
        {
            $reports = Customer::where('firstname', 'like', '%'.$key.'%')->orwhere('lastname', 'like', '%'.$key.'%')->orderby('cust_id', 'asc')->get();
        }
        else
        {
            $reports = Customer::orderby('cust_id', 'asc')->get();
        }

        return view('admin.report.customer', compact('reports'));
    }

    public function customerSales(Request $request, $id)
    {
        $dateSel = ($request->date == '') ? null : $request->date;

        if(is_null($dateSel))
        {
            $reports = Sales::where('cust_id', $id)->get();
        }
        else
        {
            $reportStart = $dateSel.' 00:00:00';
            $reportEnd = $dateSel.' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('cust_id', $id)->get();
        }

        return view('admin.report.customersales', compact('reports', 'id', 'dateSel'));
    }

    public function customerSalesPrint($date, $id)
    {
        $customer = Customer::find($id);
        if($date == 0)
        {
            $reports = Sales::where('cust_id', $id)->get();
        }
        else
        {
            $reportStart = $date.' 00:00:00';
            $reportEnd = $date.' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('cust_id', $id)->get();
        }

        return view('admin.report.customersalesprint', compact('reports', 'customer'));
    }

    public function payment(Request $request)
    {
        #$mode = Payment::where('payment_id', $id)->get();
        $dateToFormat = date('Y-m-d');

        $monthSel = (!is_null($request->month)) ? $request->month : date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($request->year == '') ? date('Y') : $request->year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];
        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        $option = ($request->option == '') ? 1 : $request->option;

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

        if($monthSel == 0)
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            if($option == 1)
            {
                $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('status', 1)->orderby('salesdate', 'desc')->get();
                
            }
            elseif($option == 2)
            {
                $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('status', 0)->orwhere('status', 2)->orderby('salesdate', 'desc')->get();
            }
        }
        else
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            if($option == 1)
            {
                $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('status', 1)->orderby('salesdate', 'desc')->get();
            }
            elseif($option == 2)
            {
                $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('status', 0)->orwhere('status', 2)->orderby('salesdate', 'desc')->get();
            }
        }


        return view('admin.report.payment', compact('dateToFormat', 'reports', 'mode', 'option', 'months', 'monthSel', 'yearSel', 'years'));
    }

    public function paymentPrint($option, $month, $year)
    {
        $dateToFormat = date('Y-m-d');

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

        if($month == 0)
        {
            if($option == 1)
            {
                $reports = Sales::where('status', 1)->orderby('salesdate', 'desc')->get();
            }
            elseif($option == 2)
            {
                $reports = Sales::where('status', 0)->orwhere('status', 2)->orderby('salesdate', 'desc')->get();
            }
        }
        else
        {
            $reportStart = date($year.'-'.$month.'-01').' 00:00:00';
            $reportEnd = date($year.'-'.$month.'-31').' 23:59:59';

            if($option == 1)
            {
                $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('status', 1)->orderby('salesdate', 'desc')->get();
            }
            elseif($option == 2)
            {
                $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->where('status', 0)->orwhere('status', 2)->orderby('salesdate', 'desc')->get();
            }
        }

        return view('admin.report.paymentprint', compact('dateToFormat', 'reports', 'option', 'mode'));
    }

    public function delivery(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $monthSel = (!is_null($request->month)) ? $request->month : date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($request->year == '') ? date('Y') : $request->year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];
        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        $option = ($request->option == '') ? 1 : $request->option;

        $month = $request->monthly;

        if($monthSel == 0)
        {
            $reports = Delivery::orderby('delivery_id', 'desc')->get();
        }
        else
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';
            $reports = Delivery::wherebetween('deliverydate', [$reportStart, $reportEnd])->orderby('delivery_id', 'desc')->get();

        }

       
        $totalCost = 0;

        foreach($reports as $report)
        {
            $totalDeliveryCost = 0;
            $deliveryDetails = $report->myDetails2;
            foreach($deliveryDetails as $deliveryDetail)
            {
                $totalDeliveryCost += $deliveryDetail->qty * $deliveryDetail->unitcost;
            }
            $totalCost += $totalDeliveryCost;
        }

        return view('admin.report.delivery', compact('dateToFormat', 'months', 'monthSel','reports', 'yearSel', 'years', 'monthDel', 'reports', 'option', 'totalCost', 'delivery'));
    }

    public function deliveryPrint($month, $year)
    {
        $dateToFormat = date('Y-m-d');

        if($month == 0)
        {
                $reports = Delivery::orderby('delivery_id', 'desc')->get();
        }
        else
        {
                $reportStart = date($year.'-'.$month.'-01').' 00:00:00';
                $reportEnd = date($year.'-'.$month.'-31').' 23:59:59';

                $reports = Delivery::wherebetween('deliverydate', [$reportStart, $reportEnd])->orderby('delivery_id', 'desc')->get();
        }

        $totalCost = 0;
        foreach($reports as $report)
        {
            $totalDeliveryCost = 0;
            $deliveryDetails = $report->myDetails2;
            foreach($deliveryDetails as $deliveryDetail)
            {
                $totalDeliveryCost += $deliveryDetail->qty * $deliveryDetail->unitcost;
            }
            $totalCost += $totalDeliveryCost;
        }

        #return view('admin.report.deliveryPrint', compact('dateToFormat', 'reports', 'reportStart', 'reportEnd', 'totalCost'));
        return view('admin.report.deliveryPrint', compact('dateToFormat', 'reports', 'reportStart', 'reportEnd', 'totalCost'));
    }

    public function stat(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $monthSel = (!is_null($request->month)) ? $request->month : date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($request->year == '') ? date('Y') : $request->year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];

        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        $option = ($request->option == '') ? 1 : $request->option;

        if($monthSel == 0)
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $reports = Product::select('product.product_id', 'product.productname', 'product.pattern', 'product.category_id', DB::raw('count(*) as count'))
                ->join('salesdetails', 'salesdetails.product_id', '=', 'product.product_id')
                ->join('sales', 'salesdetails.sales_id', '=', 'sales.sales_id')
                ->wherebetween('salesdate', [$reportStart, $reportEnd])
                ->groupby('product_id')
                ->orderby('count', 'desc')
                ->limit(15)->get();


            $overallCtr = 0;
            
            foreach($reports as $report)
            {
               
                $overallCtr += $report->count;
            }
            
        }
        else
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $reports = Product::select('product.product_id', 'product.productname', 'product.pattern', 'product.category_id', DB::raw('count(*) as count'))
                ->join('salesdetails', 'salesdetails.product_id', '=', 'product.product_id')
                ->join('sales', 'salesdetails.sales_id', '=', 'sales.sales_id')
                ->wherebetween('salesdate', [$reportStart, $reportEnd])
                ->groupby('product_id')
                ->orderby('count', 'desc')
                ->limit(15)->get();


            $overallCtr = 0;
            
            foreach($reports as $report)
            {
               
                $overallCtr += $report->count;
            }
            
        }

        return view('admin.report.stat', compact('monthSel', 'months', 'yearSel', 'years', 'dateToFormat', 'reports', 'overallCtr'));
    }

    public function statPrint($month, $year)
    {
        $dateToFormat = date('Y-m-d');

        $monthSel = (!is_null($month)) ? $month : date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($year == '') ? date('Y') : $year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];

        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        if($monthSel == 0)
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $reports = Product::select('product.product_id', 'product.productname', 'product.pattern', 'product.category_id', DB::raw('count(*) as count'))
                ->join('salesdetails', 'salesdetails.product_id', '=', 'product.product_id')
                ->join('sales', 'salesdetails.sales_id', '=', 'sales.sales_id')
                ->wherebetween('salesdate', [$reportStart, $reportEnd])
                ->groupby('product_id')
                ->orderby('count', 'desc')
                ->limit(15)->get();


            $overallCtr = 0;
            
            foreach($reports as $report)
            {
               
                $overallCtr += $report->count;
            }
            
        }
        else
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $reports = Product::select('product.product_id', 'product.productname', 'product.pattern', 'product.category_id', DB::raw('count(*) as count'))
                ->join('salesdetails', 'salesdetails.product_id', '=', 'product.product_id')
                ->join('sales', 'salesdetails.sales_id', '=', 'sales.sales_id')
                ->wherebetween('salesdate', [$reportStart, $reportEnd])
                ->groupby('product_id')
                ->orderby('count', 'desc')
                ->limit(15)->get();


            $overallCtr = 0;
            
            foreach($reports as $report)
            {
               
                $overallCtr += $report->count;
            }
            
        }

        return view('admin.report.printStat', compact('dateToFormat', 'reportStart', 'reportEnd', 'monthSel', 'yearSel', 'months', 'years', 'reports', 'overallCtr'));
    }

    public function incomeStatement(Request $request)
    {

        $dateToFormat = date('Y-m-d');

        $monthSel = (!is_null($request->month)) ? $request->month : date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($request->year == '') ? date('Y') : $request->year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];
        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        $option = ($request->option == '') ? 1 : $request->option;

        if($monthSel == 0)
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $sales = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->get();

            #$expenses = Expenses::wherebetween('expensedate', [$reportStart, $reportEnd])->get();

            $grossSales = 0;
            $deliveryCost = 0;

            //added - 12/09 10:48
            $sumSales = 0;
            foreach($sales as $sale)
            {
                foreach ($sale->myDetails as $salesD) {
                    $product = Product::where('product_id', $salesD->product_id)->first();
                    $deliveryCost += $product->unitcost * $salesD->qty;

                    //added - 12/09 10:48
                    $sumSales += $report->totalsales;
                }
                $grossSales += $sale->myDetails()->sum('sales_price'); //qty product_id
            }

        }
        else
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $sales = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->get();

            $grossSales = 0;
            $deliveryCost = 0;
            foreach($sales as $sale)
            {
                foreach ($sale->myDetails as $salesD) {
                    $product = Product::where('product_id', $salesD->product_id)->first();
                    $deliveryCost += $product->unitcost * $salesD->qty;
                }
                $grossSales += $sale->myDetails()->sum('sales_price'); //qty product_id
            }

            #$deliveries = Delivery::whereBetween('deliverydate', [$reportStart, $reportEnd])->get();
            #$deliveryCost = $deliveries->sum('totalcost');

        }

        return view('admin.report.incomestatement', compact('dateToFormat', 'monthSel', 'yearSel', 'months', 'years', 'grossSales', 'deliveryCost'));
    
    }

    public function incomeStatementPrint($month, $year)
    {
        $dateToFormat = date('Y-m-d');

        $monthSel = (!is_null($month)) ? $month : date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $yearSel = ($year == '') ? date('Y') : $year;
        $endYear = date('Y');
        $startYear = $endYear - 10;
        $years = [];

        while($startYear <= $endYear)
        {
            $years[$startYear] = $startYear;
            $startYear++;
        }

        if($monthSel == 0)
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $sales = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->get();

            $grossSales = 0;
            $deliveryCost = 0;
            foreach($sales as $sale)
            {
                 foreach ($sale->myDetails as $salesD) {
                    $product = Product::where('product_id', $salesD->product_id)->first();
                    $deliveryCost += $product->unitcost * $salesD->qty;
                }
                $grossSales += $sale->myDetails()->sum('sales_price');
            }
        }
        else
        {
            $reportStart = date($yearSel.'-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date($yearSel.'-'.$monthSel.'-31').' 23:59:59';

            $sales = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->get();

            $grossSales = 0;
            $deliveryCost = 0;
            foreach($sales as $sale)
            {
                foreach ($sale->myDetails as $salesD) {
                    $product = Product::where('product_id', $salesD->product_id)->first();
                    $deliveryCost += $product->unitcost * $salesD->qty;
                }

                $grossSales += $sale->myDetails()->sum('sales_price'); //qty product_id
            }
        }

        return view('admin.report.printincomestatement', compact('dateToFormat', 'reportStart', 'reportEnd', 'monthSel', 'yearSel', 'months', 'years', 'grossSales', 'deliveryCost'));
    }

    public function reorder(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $reports = Product::orderby('productname', 'asc')->get();

        foreach($reports as $report)
        {
            $report->reorderlimit;
            $report->stock;
        }

        return view('admin.report.reorder', compact('dateToFormat', 'reports'));
    }

    public function reorderPrint($option, $month)
    {
        $dateToFormat = date('Y-m-d');

        $reports = Product::orderby('productname', 'asc')->get();

        foreach($reports as $report)
        {
            $report->reorderlimit;
            $report->stock;
        }

        return view('admin.report.printReorder', compact('dateToFormat', 'reports'));
    }

   public function weeklyPayment(Request $request)
    {
        $custSel = ($request->customer == 0) ? null : $request->customer;

        $payments = Payment::orderby('paymentdate', 'desc');

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

         if(is_null($custSel))
         {
             $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->orderby('sales.salesdate', 'desc')
                ->paginate(25);
         }
         else
         {
            $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->where('sales.totalsales', 0)
                ->where('sales.discount', 0)
                ->where('sales.fixedAmtDiscount', 0)
                ->orderby('sales.salesdate', 'desc')
                ->orwhere('customer.bound', $custSel)
                ->paginate(25);
         }             

        foreach($credits as $credit)
        {
            $discounted = $credit->totalsales - ($credit->totalsales * ($credit->discount/100)) - $credit->fixedAmtDiscount;
            $paid = $credit->myPayments()->sum('amounttendered');        
        }

        #$customerType = ['0'=>'-Select Agent', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',];
        $customerCity = ['24'=>'Batac-Currimao', '25'=>'Badoc-Pinili', '26'=>'Sinait-San Juan', '27'=>'Bantay-Vigan', '28'=>'Narvacan-La Union', '29'=>'Abra'];
  
        return view('admin.report.weeklypayment', compact('credits', 'custSel', 'customerCity', 'discounted', 'paid', 'mode', 'skey', 'payments', 'fourTerms', 'eightTerms', 'twelveTerms'));

        #return view('admin.report.weeklypayment', compact('skey', 'dateToFormat', 'custSel', 'reports', 'customerType', 'discounted', 'paid'));

    }
}