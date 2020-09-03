<?php

namespace App\Http\Controllers\Accountant;

use App\Category;
use App\Customer;
use App\Product;
use App\Sales;
use App\SalesDetails;
use App\Delivery;
use App\DeliveryDetails;
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
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $month = $request->monthly;

        if(!is_null($request->monthly))
        {
            $reportStart = date('Y-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date('Y-'.$monthSel.'-31').' 23:59:59';

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
             #$sumSales += $report->myPayments->sum('amountpaid');
             $sumSales += $report->totalsales;
             $sumCredit += $report->myPayment->where('sales_id', $report->sales_id)->latest('payment_id')->first()->balancedue;
        }

        $sumCash = $sumSales - $sumCredit;

        return view('accountant.report.index', compact('months', 'dateToFormat', 'monthSel', 'daySel', 'reports', 'sumSales', 'sumCredit', 'sumCash', 'option'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
   
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

        return view('accountant.report.print', compact('dateToFormat', 'reports', 'reportStart', 'sumSales', 'sumCredit', 'sumCash', 'reportEnd'));
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
            $reports = Product::orderby('product_id', 'asc')->get();
        }
        else
        {
            $reports = Product::where('category_id', $catSel)->orderby('product_id', 'asc')->get();
        }

        $totalInventoryValue = 0;
        foreach($reports as $report)
        {
            $totalInventoryValue += $report->stock * $report->unitcost;
        }

        $categories = ['0'=>'--Select Category--'] + Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();

        return view('accountant.report.inventory', compact('dateToFormat', 'catSel', 'reports', 'categories', 'totalInventoryValue'));
    }

    public function printInventoryReport($category)
    {
        $dateToFormat = date('Y-m-d');

        $catSel = ($category == 0 || is_null($category) || $category == '') ? null : $category;

        if(is_null($catSel))
        {
            $reports = Product::orderby('product_id', 'asc')->get();
        }
        else
        {
            $reports = Product::where('category_id', $catSel)->orderby('product_id', 'asc')->get();
        }

        $totalInventoryValue = 0;
        foreach($reports as $report)
        {
            $totalInventoryValue += $report->stock * $report->unitprice;
        }

        return view('accountant.report.printinventory', compact('dateToFormat', 'reports', 'totalInventoryValue', 'catSel'));
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

        return view('accountant.report.sales', compact('dateToFormat', 'months', 'years', 'monthSel', 'yearSel', 'reports', 'optSel'));
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

        return view('accountant.report.salesprint', compact('dateToFormat', 'reports', 'option'));
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

        return view('accountant.report.customer', compact('reports'));
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

        return view('accountant.report.customersales', compact('reports', 'id', 'dateSel'));
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

        return view('accountant.report.customersalesprint', compact('reports', 'customer'));
    }

    public function payment(Request $request)
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

        return view('accountant.report.payment', compact('dateToFormat', 'reports', 'option', 'months', 'monthSel', 'yearSel', 'years'));
    }

    public function paymentPrint($option, $month, $year)
    {
        $dateToFormat = date('Y-m-d');

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

        return view('accountant.report.paymentprint', compact('dateToFormat', 'reports', 'option'));
    }

    public function delivery(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $option = (!is_null($request->option)) ? $request->option : 1;
        $monthDel = (!is_null($request->monthly)) ? $request->monthly : 1;
        if(strlen($monthDel) == 1)
        {
            $monthDel = '0'.$monthDel;
        }
        $dayDel = (!is_null($request->daily)) ? $request->daily : date('Y-m-d');

        $months = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $month = $request->monthly;

        if(!is_null($request->monthly))
        {
            $reportStart = date('Y-'.$monthDel.'-01').' 00:00:00';
            $reportEnd = date('Y-'.$monthDel.'-31').' 23:59:59';

            $reports = Delivery::wherebetween('deliverydate', [$reportStart, $reportEnd])->orderby('delivery_id', 'desc')->get();
        }
        else
        {
            $day = (strlen($request->daily) < 2) ? ('0'.$request->daily) : $request->daily;

            $reportStart = $dayDel.' 00:00:00';
            $reportEnd = $dayDel.' 23:59:59';

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

        return view('accountant.report.delivery', compact('dateToFormat', 'months', 'monthDel', 'dayDel', 'reports', 'option', 'totalCost'));
    }

    public function deliveryPrint($option, $day, $month)
    {
        $dateToFormat = date('Y-m-d');

        if($option == 2)
        {
            $reportStart = date('Y-'.$month.'-01').' 00:00:00';
            $reportEnd = date('Y-'.$month.'-31').' 23:59:59';

             $reports = Delivery::wherebetween('deliverydate', [$reportStart, $reportEnd])->orderby('delivery_id', 'desc')->get();
        }
        else
        {

            $reportStart = $day.' 00:00:00';
            $reportEnd = $day.' 23:59:59';

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

        return view('accountant.report.deliveryPrint', compact('dateToFormat', 'reports', 'reportStart', 'reportEnd', 'totalCost'));
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

            $reports = Product::select('product.product_id', 'product.productname', DB::raw('count(*) as count'))
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

            $reports = Product::select('product.product_id', 'product.productname', DB::raw('count(*) as count'))
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

        return view('accountant.report.stat', compact('monthSel', 'months', 'yearSel', 'years', 'dateToFormat', 'reports', 'overallCtr'));
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

            $reports = Product::select('product.product_id', 'product.productname', DB::raw('count(*) as count'))
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

            $reports = Product::select('product.product_id', 'product.productname', DB::raw('count(*) as count'))
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

        return view('accountant.report.printStat', compact('dateToFormat', 'reportStart', 'reportEnd', 'monthSel', 'yearSel', 'months', 'years', 'reports', 'overallCtr'));
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

/*
            $deliveries = Delivery::whereBetween('deliverydate', [$reportStart, $reportEnd])->get();

            $deliveryCost = 0;
            foreach($deliveries as $delivery)
            {
                $deliveryCost += $delivery->myDetails2()->sum('unitcost');
            }
            */
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

        return view('accountant.report.incomestatement', compact('dateToFormat', 'monthSel', 'yearSel', 'months', 'years', 'grossSales', 'deliveryCost'));
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

            /*$deliveries = Delivery::whereBetween('deliverydate', [$reportStart, $reportEnd])->get();

            $deliveryCost = 0;
            foreach($deliveries as $delivery)
            {
                $deliveryCost += $delivery->myDetails2()->sum('unitcost');
            }*/
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

        return view('accountant.report.printincomestatement', compact('dateToFormat', 'monthSel', 'yearSel', 'months', 'years', 'grossSales', 'deliveryCost'));
    }
}
