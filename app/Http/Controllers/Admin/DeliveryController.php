<?php

namespace App\Http\Controllers\Admin;

use App\Delivery;
use App\DeliveryDetails;
use App\DeliverySet;
use App\Product;
use App\Category;
use App\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
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
        
        $selSupplier = (is_null($request->supplier_id) || $request->supplier_id == '') ? null : $request->supplier_id;
        $selDate = (is_null($request->deliverydate) || $request->deliverydate == '') ? null : $request->deliverydate;

        if(!is_null($selSupplier) && !is_null($selDate))
        {
            $deliveries = Delivery::where('supplier_id', $selSupplier)->where('deliverydate', $selDate)->orderby('deliverydate', 'desc')->paginate(15);
        }
        elseif(!is_null($selSupplier) && is_null($selDate))
        {
            $deliveries = Delivery::where('supplier_id', $selSupplier)->orderby('deliverydate', 'desc')->paginate(20);
        }
        elseif(is_null($selSupplier) && !is_null($selDate))
        {
            $deliveries = Delivery::where('deliverydate', $selDate)->orderby('deliverydate', 'desc')->paginate(20);
        }
        else
        {
            $deliveries = Delivery::orderby('deliverydate', 'desc')->paginate(15);
        }

        $deliverysets = DeliverySet::where('employee_id', Auth::user()->employee_id)->get();

        $totDeliveryCost = $deliverysets->sum('deliverycost');

        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        $products = Product::orderby('productname', 'asc')->groupby('productname')->lists('productname', 'product_id')->all();
        $categories = ['0'=>'Category'] + Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();

        return view('admin.delivery.index', compact('deliveries', 'deliverysets', 'suppliers', 'categories', 'totDeliveryCost', 'products', 'selSupplier', 'selDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $suppliers = ['0'=>'Select Supplier'] + Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        $products = ['0'=>'Select Product'];

        return view('admin.delivery.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $deliverySet = DeliverySet::where('employee_id', Auth::user()->employee_id)->get();

        $deliveryRecord = new Delivery();
        $deliveryRecord->supplier_id = $request->supplier_id;
        $deliveryRecord->order_number = $request->order_number;
        $deliveryRecord->totalcost = $deliverySet->sum('deliverycost');
        $deliveryRecord->deliverydate = $request->deliverydate;
        $deliveryRecord->date_received = $request->date_received;
        $deliveryRecord->save();

        foreach($deliverySet as $delivery)
        {
            $deliveryDetails = new DeliveryDetails();
            $deliveryDetails->delivery_id = $deliveryRecord->delivery_id;
            $deliveryDetails->product_id = $delivery->product_id;
            $deliveryDetails->qty = $delivery->qty;
            $deliveryDetails->unitcost = $delivery->unitcost;
            $deliveryDetails->deliverycost = $delivery->deliverycost;
            $deliveryDetails->save();

            $product = Product::where('product_id', $delivery->product_id)->first();
            $product->stock = $product->stock + $delivery->qty;
            $product->update();
        }

        DeliverySet::truncate();

        /*
        $delivery = new Delivery();
        $delivery->supplier_id = $request->supplier_id;
        $delivery->deliverydate = $request->deliverydate;
        $delivery->save();

        $deliveryDetails = new DeliveryDetails();
        $deliveryDetails->delivery_id = $delivery->delivery_id;
        $deliveryDetails->product_id = $request->product_id;
        $deliveryDetails->qty = $request->qty;
        $deliveryDetails->unitcost = $request->unitcost;
        $deliveryDetails->save();
        */

        return redirect()->back()->with(['code'=>'1']);
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
        $delivery = Delivery::find($id);
        $deliveryDetails = $delivery->myDetails->first();

        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        $products = Product::where('supplier_id', $delivery->supplier_id)->orderby('productname', 'asc')->lists('productname', 'product_id')->all();

        $deliveryArr = ['deliverydate'=>substr($delivery->deliverydate, 0, 10), 'supplier_id'=>$delivery->supplier_id, 'product_id'=>$deliveryDetails->product_id, 'qty'=>$deliveryDetails->qty, 'unitcost'=>$deliveryDetails->unitcost];

        return view('admin.delivery.edit', compact('delivery', 'deliveryArr', 'suppliers', 'products'));
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
        $delivery = Delivery::find($id);
        $deliveryDetails = $delivery->myDetails->first();// dd($deliveryDetails);

        $delivery->update($request->all());
        $deliveryDetails->update($request->all());

        return redirect()->route('deliveryIndex');
    }

    public function restock(Request $request)
    {
        $product = Product::where('product_id', $request->product_id)->first();

        $delivery = new Delivery();
        $delivery->supplier_id = $product->supplier_id;
        $delivery->order_number = $request->order_number;
        $delivery->totalcost = $product->unitcost * $request->qty;
        $delivery->deliverydate = $request->deliverydate;
        $delivery->deliverydate = $request->date_received;
        $delivery->save();

        $deliveryDetails = new DeliveryDetails();
        $deliveryDetails->delivery_id = $delivery->delivery_id;
        $deliveryDetails->product_id = $request->product_id;
        $deliveryDetails->qty = $request->qty;
        $deliveryDetails->unitcost = $product->unitcost;
        $deliveryDetails->deliverycost = $product->unitcost * $request->qty;
        $deliveryDetails->save();

        $product->stock = $product->stock + $request->qty;
        $product->update();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Delivery::where('delivery_id', $id)->first()->delete();
        $deliveryDetails = DeliveryDetails::where('delivery_id', $id)->get();
        foreach($deliveryDetails as $deliveryDetail)
        {
            $product = Product::where('product_id', $deliveryDetail->product_id)->first();
            $product->stock = $product->stock - $deliveryDetail->qty;
            $product->update();

            $deliveryDetail->delete();
        }

        return redirect()->back();
    }
}
