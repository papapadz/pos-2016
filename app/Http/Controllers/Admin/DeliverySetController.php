<?php

namespace App\Http\Controllers\Admin;

use App\DeliverySet;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliverySetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
        $deliverySet = DeliverySet::where('employee_id', Auth::user()->employee_id)->where('product_id', $request->product_id)->first();

        if(!is_null($deliverySet)){
            $deliverySet->qty = $deliverySet->qty + $request->qty;
            $deliverySet->deliverycost = $deliverySet->deliverycost + $request->deliveryprice;
            $deliverySet->update();
        }
        else
        {
            $product = Product::where('product_id', $request->product_id)->first();

            $newDeliverySet = new DeliverySet();
            $newDeliverySet->employee_id = Auth::user()->employee_id;
            $newDeliverySet->product_id = $request->product_id;
            $newDeliverySet->qty = $request->qty;
            $newDeliverySet->unitcost = $product->unitcost;
            $newDeliverySet->deliverycost = $request->deliveryprice;
            $newDeliverySet->save();
        }

        return redirect()->back();
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
        DeliverySet::find($id)->delete();

        return redirect()->back();
    }
}
