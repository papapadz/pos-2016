<?php

namespace App\Http\Controllers\Accountant;

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
       $skey = ($request->skey == '' || $request->skey == null) ? null : $request->skey;

        if(is_null($skey))
        {
            $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->paginate(10);
        }
        else
        {
            $credits = Customer::join('sales', 'customer.cust_id', '=', 'sales.cust_id')
                ->orwhere('customer.firstname', 'like', '%'.$skey.'%')
                ->orwhere('customer.firstname', 'like', '%'.$skey.'%')
                ->orwhere('sales.invoicenumber', 'like', '%'.$skey.'%')
                ->where('sales.sales_type', 2)
                ->where('sales.status', 0)
                ->paginate(15);
        }

        return view('accountant.credit.index', compact('credits', 'skey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createPayment($id)
    {
        $sales = Sales::where('sales_id', $id)->where('sales_type', 2)->where('status', 0)->first();

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

        return view('accountant.credit.createpayment', compact('customer', 'invoiceNumber', 'payment', 'sales', 'salesDetails', 'vatSales', 'vat', 'grandTotal'));
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

        $balance = $request->amtToPay - $request->payment;

        if($balance <= 0)
        {
            //paid
            $payment = new Payment();
            $payment->sales_id = $request->sid;
            $payment->amounttendered = $request->payment;
            $payment->amountpaid = $request->amtToPay;
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
            $payment->paymentdate = date('Y-m-d H:m:s');
            $payment->save();
        }

        return redirect()->route('accountantCreditIndex')->with(['code'=>'1']);
    }

    public function paymentHistory($id)
    {
        $salesPayment = Payment::where('sales_id', $id)->orderby('payment_id', 'desc')->get();

        return view('accountant.credit.history', compact('salesPayment'));
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
