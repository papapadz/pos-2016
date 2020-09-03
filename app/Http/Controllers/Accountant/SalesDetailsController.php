<?php

namespace App\Http\Controllers\Accountant;

use App\Customer;
use App\Sales;
use App\SalesDetails;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $salesDetails->sum('sales_price') / 1.12;
        $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        /*$grandTotal += ($salesDetails->qty * $salesDetails->myProduct->unitprice);
        $vatSales = $salesDetails->qty * $salesDetails->myProduct->unitprice / 1.12;
        $vat = $grandTotal - $vatSales ;*/

        return view('accountant.salesdetails.index', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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

    public function printInvoice($id)
    {
        $sales = Sales::find($id);
        $salesDetails = SalesDetails::where('sales_id', $id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $salesDetails->sum('sales_price') / 1.12;
        $vat = $salesDetails->sum('sales_price')/1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('accountant.salesdetails.print', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }
}
