<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Payment;
use App\Sales;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dateToFormat = date('Y-m-d');
    
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
                ->orwhere('customer.cust_type', $custSel)
                ->paginate(25);
         }
                 

        foreach($credits as $credit)
        {
            $discounted = $credit->totalsales - ($credit->totalsales * ($credit->discount/100)) - $credit->fixedAmtDiscount;
            $paid = $credit->myPayments()->sum('amounttendered');        
        }

        $customerType = ['0'=>'-Select Agent', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',];
  
        return view('admin.credit.index', compact('credits', 'custSel', 'dateToFormat', 'customerType', 'discounted', 'paid', 'mode', 'skey', 'payments', 'fourTerms', 'eightTerms', 'twelveTerms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createPayment($id)
    {
        $dateToFormat = date('Y-m-d');

        $sales = Sales::where('sales_id', $id)->where('sales_type', 2)->where('status', 0)->first();

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

        $type = ['1'=>'Cash'];

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

        $discounted = $sales->totalsales - ($sales->totalsales * ($sales->discount/100)) - $sales->fixedAmtDiscount;

        return view('admin.credit.createpayment', compact('customer', 'type', 'dateToFormat', 'invoiceNumber', 'payment', 'mode', 'sales', 'salesDetails', 'vatSales', 'vat', 'grandTotal', 'discounted'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storePayment(Request $request)
    {

        $sales = Sales::find($request->sid);

        $payment = Payment::where('sales_id', $sales->sales_id)->orderby('payment_id', 'desc')->first();

        $balance = $request->amtToPay - $request->payment;
        
        if($balance <= 0)
        {
            //paid
            $payment = new Payment();
            $payment->sales_id = $request->sid;
            $payment->amounttendered = $request->payment;
            $payment->amountpaid = $request->amtToPay;
            #$payment->paymentmode = $request->paymentmode;
            #$payment->fixedAmtDiscount = $ $request->fixedAmtDiscount;
            $payment->paymentdate = date('Y-m-d H:m:s');
            $payment->save();

            $sales->status = 1;
            $sales->update();
        }
        else
        {
            $payment = new Payment();
            $payment->sales_id = $request->sid;
            $payment->amounttendered = $request->payment;
            $payment->amountpaid = $request->amtToPay;
            $payment->balancedue = $balance;
            #$payment->paymentmode = $request->paymentmode;
            $payment->paymentdate = date('Y-m-d H:m:s');
            $payment->save();
        }

        $discounted = $sales->totalsales - ($sales->totalsales * ($sales->discount/100)) - $sales->fixedAmtDiscount;
        #$paid = $sales->myPayments()->sum('amounttendered');
        
        return redirect()->route('creditIndex')->with(['code'=>'1']);
    }


    public function storePaymentCheque(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $sales = Sales::find($request->sid);

        $payment = Payment::where('sales_id', $sales->sales_id)->orderby('payment_id', 'desc')->first();

        $mode = ['1'=>'BDO', '2'=>'Metrobank', '3'=>'Landbank', '4'=>'BPI', '5'=>'PNB', '6'=>'RCBC', '7'=>'Others'];

        $balance = $request->amtToPay - $request->payment;
        
        if($balance <= 0)
        {  
            $payment = new Payment();
            $payment->sales_id = $request->sid;
            $payment->amounttendered = $request->payment;
            $payment->amountpaid = $request->amtToPay;
            $payment->balancedue = $balance;
            $payment->paymentmode = $request->paymentmode;
            $payment->paymentdate = date('Y-m-d H:m:s');
            $payment->cheque_no = $request->cheque_no;
            $payment->cheque_date = $request->cheque_date;
            $payment->due_date = $request->due_date;
            $payment->save();

            $sales->status = 1;
            $sales->update();
        }
        else
        {
            $payment = new Payment();
            $payment->sales_id = $request->sid;
            $payment->amounttendered = $request->payment;
            $payment->amountpaid = $request->amtToPay;
            $payment->balancedue = $balance;
            $payment->paymentmode = $request->paymentmode;
            $payment->paymentdate = date('Y-m-d H:m:s');
            $payment->cheque_no = $request->cheque_no;
            $payment->cheque_date = $request->cheque_date;
            $payment->due_date = $request->due_date;
            $payment->save();
        }

        $discounted = $sales->totalsales - ($sales->totalsales * ($sales->discount/100)) - $sales->fixedAmtDiscount;
       
        
        return redirect()->route('creditIndex')->with(['code'=>'1']);
    }




    public function paymentHistory($id)
    {
        $salesPayment = Payment::where('sales_id', $id)->orderby('payment_id', 'asc')->get();

        $paymentType = ['1'=>'Cash', '2'=>'Cheque'];

        return view('admin.credit.history', compact('salesPayment', 'paymentType'));
    }

    public function paymentHistoryView($id)
    {

        $salesPayment = Payment::where('payment_id', $id)->get();
        
        $paymentType = ['1'=>'Cash', '2'=>'Cheque'];

        return view('admin.credit.historyView', compact('salesPayment', 'paymentType'));
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
        //
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
