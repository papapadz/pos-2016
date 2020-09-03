<?php

namespace App\Http\Controllers\Accountant;

use App\Category;
use App\Customer;
use App\Orders;
use App\Payment;
use App\Sales;
use App\SalesDetails;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


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
    public function index()
    {
       $orders = Orders::where('employee_id', Auth::user()->employee_id)->orderby('order_id','desc')->get();

        $vatSales = $orders->sum('orderprice') / 1.12;
        $vat = $orders->sum('orderprice')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        $markupStart = 5;
        $markUpArr = array();
        while($markupStart <= 50)
        {
            $markUpArr[$markupStart] = $markupStart . '%';
            $markupStart += 5;
        }

        $categories = ['0'=>'Category'] + Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();
        $customers = Customer::orderby('lastname', 'asc')->get()->lists('CustomerName', 'cust_id')->all();

        return view('accountant.sales.index', compact('orders', 'categories', 'customers', 'vatSales', 'vat', 'grandTotal', 'markUpArr'));
    }

    public function paymentHistory($id)
    {
        $salesPayment = Payment::where('sales_id', $id)->get();

        return view('accountant.sales.history', compact('salesPayment'));
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

        return view('accountant.sales.credit', compact('customer', 'invoiceNumber', 'payment', 'sales', 'salesDetails', 'vatSales', 'vat', 'grandTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {

        $orders = Orders::where('employee_id', Auth::user()->employee_id)->get();

        $status = $request->sales_type == 1 ? 1 : 0;

        $sales = new Sales();
        $sales->cust_id = $request->cust_id;
        $sales->sales_type = $request->sales_type;
        $sales->totalsales = $orders->sum('orderprice');
        $sales->status = $status;
        $sales->salesdate = date('Y-m-d');
        $sales->save();

        if($request->sales_type == 1)
        {
            // Cash
            $payment = new Payment();
            $payment->sales_id = $sales->sales_id;
            $payment->amounttendered = $request->payment;
            $payment->amountpaid = $request->amtToPay;
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
            $payment->amountpaid = $request->amtToPay;
            $payment->balancedue = $request->amtToPay - $request->payment;
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


        // Move Orders to Sales Details
        foreach($orders as $order)
        {
            $salesDetails = new SalesDetails();
            $salesDetails->sales_id = $sales->sales_id;
            $salesDetails->product_id = $order->product_id;
            $salesDetails->qty = $order->qty;
            $salesDetails->ordersalesprice = $order->salesprice;
            $salesDetails->sales_price = $order->orderprice;
            $salesDetails->markup = $order->markup;
            $salesDetails->save();

            $product = $order->myProduct;
            $product->stock = ($product->stock - $order->qty);
            $product->update();
        }

        Orders::truncate();

        #return redirect()->back()->with(['code'=>'1']);
        return redirect()->route('accountantSalesSummary', ['id'=>$sales->sales_id]);

    }

    public function summary($id)
    {
       $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $salesDetails->sum('sales_price') / 1.12;
        $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('accountant.sales.summary', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }

    public function printSummary($id)
    {
        $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $salesDetails->sum('sales_price') / 1.12;
        $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('accountant.sales.printsummary', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }

    public function creditPaymentCreate(Request $request)
    {

       $sales = Sales::find($request->sid);

        $payment = new Payment();
        $payment->sales_id = $request->sid;

        $balance = ($request->amtToPay) - ($request->payment);

        if($balance <= 0)
        {
            //paid
            $payment->amountpaid = $request->amtToPay;
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

        return redirect()->route('accountantSalesIndex')->with(['code'=>'1']);
    }

    public function editCustomer($id)
    {
        $sales = Sales::find($id);
        $customers = Customer::orderby('lastname', 'asc')->get()->lists('CustomerName', 'cust_id')->all();

        return view('accountant.sales.edit', compact('sales', 'customers'));
    }

     public function updateCustomer(SalesRequest $request, $id)
    {
        #$sales = Sales::find($id);
        #$sales->update($request->all());

        Sales::find($id)->update($request->all());
         $customers = Customer::orderby('lastname', 'asc')->get()->lists('CustomerName', 'cust_id')->all();

        return redirect()->route('accountantSalesDetailsIndex');
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

        return view('accountant.sales.summary', compact('salesDetails', 'customer', 'sales'));
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
