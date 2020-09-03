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


class SalesController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        #$selDate = (is_null($request->salesdate) || $request->salesdate == '') ? null : $request->salesdate;
        $dateToFormat = date('Y-m-d');

        $selDate = (!is_null($request->salesdate)) ? $request->salesdate : $dateToFormat;

        #(new Dumper)->dump($selDate);


        $discount = ['0'=>'%', '5'=>'5%', '10'=>'10%', '15'=>'15%', '20'=>'20%', '25'=>'25%', '30'=>'30%', '35'=>'35%', '40'=>'40%', '45'=>'45%', '50'=>'50%', '55'=>'55%', '60'=>'60%', '65'=>'65%', '70'=>'70%', '75'=>'75%',]; 
        $paymentTerms = ['0'=>'none', '1'=>'1 month', '2'=>'2 months', '3'=>'3 months', '4'=>'4 month', '5'=>'5 month'];

        $orders = Orders::where('employee_id', Auth::user()->employee_id)->orderby('order_id','desc')->get();


        $vatSales = $orders->sum('orderprice') / 1.12;
        $vat = $orders->sum('orderprice')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        
        $dvalue = $grandTotal * $request->discount/100; 
        $dprice = $grandTotal - $dvalue;

        #dd($request->all());

        $markupStart = 5;
        $markUpArr = array();
        while($markupStart <= 50)
        {
            $markUpArr[$markupStart] = $markupStart . '%';
            $markupStart += 5;
        }

        $categories = ['0'=>'Category'] + Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();
        $customers = Customer::orderby('companyname', 'asc')->get()->lists('CustomerName', 'cust_id')->all();

        $products = Product::orderby('productname', 'asc')->groupby('productname')->lists('productname', 'product_id')->all();

        return view('admin.sales.index', compact('selDate', 'orders', 'categories', 'customers', 'products', 'vatSales', 'vat', 'grandTotal', 'discount', 'dvalue', 'dprice', 'markUpArr'));
    }

    public function paymentHistory($id)
    {
        $salesPayment = Payment::where('sales_id', $id)->get();

        return view('admin.sales.history', compact('salesPayment'));
    }

    public function credit(Request $request) 
    {
        $invoiceNumber = $request->invoicenumber;
        $sales = Sales::where('invoicenumber', $invoiceNumber)->where('status', 0)->first();

        if(is_null($sales))
        {
            return redirect()->back()->with(['invoiceCode'=>'0']);
        }

        $payment = Payment::where('sales_id', $sales->sales_id)->orderby('payment_id', 'desc')->first();

        if(is_null($payment))
        {
            return redirect()->back()->with(['invoiceCode'=>'0']);
        }



        $salesDetails = $sales->myDetails;
        $customer = $sales->myCustomer;

        $vatSales = $payment->balancedue / 1.12;
        $vat = $payment->balancedue/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('admin.sales.credit', compact('customer', 'invoiceNumber', 'payment', 'paymentTerms', 'sales', 'salesDetails', 'vatSales', 'vat', 'grandTotal'));
    }

    public function create(Request $request)
    {
        $dateToFormat = date('Y-m-d');
        $selDate = (!is_null($request->salesdate)) ? $request->salesdate : $dateToFormat;
        $discount = ['0'=>'%', '5'=>'5%', '10'=>'10%', '15'=>'15%', '20'=>'20%', '25'=>'25%', '30'=>'30%', '35'=>'35%', '40'=>'40%', '45'=>'45%', '50'=>'50%', '55'=>'55%', '60'=>'60%', '65'=>'65%', '70'=>'70%', '75'=>'75%',]; 
        $orders = Orders::where('employee_id', Auth::user()->employee_id)->get();

        $status = $request->sales_type == 1 ? 1 : 0;
        $sales = new Sales();
        $sales->cust_id = $request->cust_id;
        $sales->sales_type = $request->sales_type;

        if($request->discounted > 0)
        {
            $sales->totalsales = $request->discountedsales;
            $sales->discount = $request->discounted;  
        }
        else
        {
            $sales->totalsales = $orders->sum('orderprice');
            $sales->fixedAmtDiscount = $request->discountAmt; 
        } 
        $sales->status = $status;
        $sales->salesdate = $selDate;
        $sales->terms = $request->terms;
        $sales->save();

        #dd($request->all());

        if($request->sales_type == 1)
        {
            // Cash
            $payment = new Payment();
            $payment->sales_id = $sales->sales_id;
            $payment->amounttendered = $request->payment;

            if($request->discounted > 0)
            {
                $payment->amountpaid = $request->discountedsales;
            }
            else
            {
                $payment->amountpaid = $request->amtToPay;
            }

            $payment->balancedue = 0;
            $payment->paymentdate = date('Y-m-d');
            
            $payment->save();
        }
        else
        {
            // Credit
            $payment = new Payment();
            $payment->sales_id = $sales->sales_id;
            $payment->amounttendered = $request->payment;

            if($request->discounted > 0)
            {
                $payment->amountpaid = $request->discountedsales;
                $payment->balancedue = $request->discountedsales; - $request->payment;
                
            }
            else
            {
                $payment->amountpaid = $request->amtToPay;
                $payment->balancedue = $request->amtToPay - $request->payment;
            }

            #$payment->percentDiscount = $sales->discount;
            #$payment->fixedAmtDiscount = $sales->fixedAmtDiscount;
         
            #$payment->paymentmode = $request->paymentmode;
            $payment->paymentdate = date('Y-m-d');
            $payment->save();
        }

        // Update Sales Invoice Number
        switch (strlen($sales->sales_id))
        {
            case 1:
                $code = '000' . $sales->sales_id;
                break;
            case 2:
                $code = '00' . $sales->sales_id;
                break;
            case 3:
                $code = '0' . $sales->sales_id;
                break;
            default:
                $code = $sales->sales_id;
        }
        $sales->invoicenumber = $code;
        $sales->update();

        $vatSales = $payment->balancedue / 1.12;
        $vat = $payment->balancedue/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        $dvalue = $grandTotal * $request->discount/100;
        $dprice = $grandTotal - $dvalue;



        // Move Orders to Sales Details
        foreach($orders as $order)
        {
            $salesDetails = new SalesDetails();
            $salesDetails->sales_id = $sales->sales_id;
            $salesDetails->product_id = $order->product_id;
            $salesDetails->qty = $order->qty;
            $salesDetails->ordersalesprice = $order->salesprice;
            $salesDetails->sales_price = $order->orderprice;

            $salesDetails->save();

            $product = $order->myProduct;
            $product->stock = ($product->stock - $order->qty);
            $product->update();
        }

       
        Orders::truncate();

        #return redirect()->back()->with(['code'=>'1']);
        return redirect()->route('salesSummary', ['id'=>$sales->sales_id]);

    }

    public function summary($id)
    {
       
        $sales = Sales::find($id); #dd($sales);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

         if($sales->discount > 0)
        {
            $vatSales = $sales->totalsales / 1.12;
            $vat = $sales->totalsales/1.12 * .12;
        }
        else
        {
            $vatSales = $salesDetails->sum('sales_price') / 1.12;
            $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        }

        if($sales->fixedAmtDiscount > 0)
        {
            $vatSales = $sales->totalsales / 1.12;
            $vat = $sales->totalsales/1.12 * .12;
            $ds = $sales->totalsales - $sales->fixedAmtDiscount;
        }
        else
        {
            $vatSales = $salesDetails->sum('sales_price') / 1.12;
            $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        }

        
        $grandTotal = $vatSales + $vat;

        return view('admin.sales.summary', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }

    public function printSummary($id)
    {
       
        $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

         if($sales->discount > 0)
        {
            $vatSales = $sales->totalsales / 1.12;
            $vat = $sales->totalsales/1.12 * .12;
        }
        else
        {
            $vatSales = $salesDetails->sum('sales_price') / 1.12;
            $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        }

        if($sales->fixedAmtDiscount > 0)
        {
            $vatSales = $sales->totalsales / 1.12;
            $vat = $sales->totalsales/1.12 * .12;
        }
        else
        {
            $vatSales = $salesDetails->sum('sales_price') / 1.12;
            $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        }

        #$vatSales = $salesDetails->sum('sales_price') / 1.12;
        #$vat = $salesDetails->sum('sales_price')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('admin.sales.printsummary', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }

    public function printSummaryForm($id)
    {
        $dateToFormat = date('Y-m-d');

        $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $salesDetails->sum('sales_price') / 1.12;
        $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        $dvalue = $grandTotal * $request->discount/100;  # --->AWAN MAALA NA A VALUE.... NULL
        $dprice = $grandTotal - $dvalue;

        return view('admin.sales.printsummaryForm', compact('salesDetails', 'dateToFormat', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal', 'discount', 'dvalue', 'dprice'));
    }

    public function creditPaymentCreate(Request $request)
    {
        $sales = Sales::find($request->sid);

        $payment = new Payment();
        $payment->sales_id = $request->sid;

        if($sales->discount > 0)
        {
            $balance = ($request->discountedsales) - ($request->payment);

            if($balance <= 0)
            {
                //paid
                $payment->amountpaid = $request->amtToPay;
                $payment->amountpaid = $request->totalsales;
                $payment->paymentdate = date('Y-m-d H:m:s');
                $payment->save();

                $sales->status = 1;
                $sales->update();
            }
            else
            {
                $payment->amountpaid = $request->payment;
                $payment->balancedue = $balance;
                $payment->paymentdate = date('Y-m-d H:m:s');
                $payment->percentDiscount = $request->discount;
                $payment->fixedAmtDiscount = $request->fixedAmtDiscount;
                $payment->save();
            }
        }

        else if($sales->fixedAmtDiscount > 0)
        {
            $balance = ($request->discountedsales) - ($request->payment);

            if($balance <= 0)
            {
                //paid
                $payment->amountpaid = $request->amtToPay;
                $payment->amountpaid = $request->totalsales;
                $payment->paymentdate = date('Y-m-d H:m:s');

                $payment->save();

                $sales->status = 1;
                $sales->update();
            }
            else
            {
                $payment->amountpaid = $request->payment;
                $payment->balancedue = $balance;
                $payment->paymentdate = date('Y-m-d H:m:s');
                $payment->percentDiscount = $request->discount;
                $payment->fixedAmtDiscount = $request->fixedAmtDiscount;
                $payment->save();
            }
        }

        else
        {
            $balance = ($request->amtToPay) - ($request->payment);

            if($balance <= 0)
            {
                //paid
                $payment->amountpaid = $request->amtToPay;
                #$payment->amountpaid = $request->totalsales;
                $payment->paymentdate = date('Y-m-d H:m:s');
                $payment->save();

                $sales->status = 1;
                $sales->update();
            }
            else
            {
                $payment->amountpaid = $request->payment;
                $payment->balancedue = $balance;
                $payment->paymentdate = date('Y-m-d H:m:s');
                $payment->save();
            }

        }
            

        return redirect()->route('salesIndex')->with(['code'=>'1']);
        
    }

    public function editCustomer($id)
    {
        $sales = Sales::find($id);
        $customers = Customer::orderby('companyname', 'asc')->get()->lists('CustomerName', 'cust_id')->all();

        return view('admin.sales.edit', compact('sales', 'customers'));
    }

     public function updateCustomer(SalesRequest $request, $id)
    {
        #$sales = Sales::find($id);
        #$sales->update($request->all());

        Sales::find($id)->update($request->all());
         $customers = Customer::orderby('companyname', 'asc')->get()->lists('CustomerName', 'cust_id')->all();

        return redirect()->route('salesDetailsIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

        return view('admin.sales.summary', compact('salesDetails', 'customer', 'sales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
