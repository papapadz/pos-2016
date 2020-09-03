<?php

namespace App\Http\Controllers\Admin;

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
        $sales = Sales::where('sales_id', $id)->first();
        $salesDetails = SalesDetails::where('sales_id', $sales->sales_id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $sales->totalsales / 1.12;
        $vat = $sales->totalsales / 1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('admin.salesdetails.index', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
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
        $sales = Sales::where('sales_id', $id)->first();
        $salesDetails = SalesDetails::where('sales_id', $sales->sales_id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $sales->totalsales / 1.12;
        $vat = $sales->totalsales / 1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('admin.salesdetails.print', compact('salesDetails', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }

    public function printInvoiceForm($id)
    {
        $dateToFormat = date('Y-m-d');

        $sales = Sales::where('sales_id', $id)->first();
        $salesDetails = SalesDetails::where('sales_id', $sales->sales_id)->get();
        $customer = $sales->myCustomer;

        $vatSales = $sales->totalsales / 1.12;
        $vat = $sales->totalsales / 1.12 * .12;
        $grandTotal = $vatSales + $vat;

        return view('admin.salesdetails.printForm', compact('salesDetails', 'dateToFormat', 'customer', 'sales', 'vatSales', 'vat', 'grandTotal'));
    }
}
