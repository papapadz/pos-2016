<?php

namespace App\Http\Controllers\Accountant;

use App\Orders;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
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
       $product = Product::find($request->product_id);

        $order = Orders::where('employee_id', Auth::user()->employee_id)->where('product_id', $product->product_id)->first();

        if(!is_null($order))
        {
            $order->qty = $order->qty + $request->qty;
            $order->salesprice = $order->unitprice;
            $order->orderprice = $order->orderprice + $request->orderprice;
            #$order->stock = $request->stock + $order->stock;
            $order->update();
        }
        else
        {
            $order = new Orders();
            $order->product_id = $product->product_id;
            $order->employee_id = Auth::user()->employee_id;
            #$order->stock = $request->stock;
            $order->qty = $request->qty;
            $order->salesprice = $request->unitprice;
            $order->orderprice = $request->orderprice;
            $order->save();
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
        Orders::find($id)->delete();

        return redirect()->back();
    }
}
