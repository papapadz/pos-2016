<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Orders;
use App\Product;
use App\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AjaxController extends Controller
{
    public function getSupplierProducts(Request $request)
    {
        $products = Product::where('supplier_id', $request->supplier)->get();

        if(!is_null($products))
        {
            $productsList = "";

            foreach($products as $product)
            {
                $productsList .= "<option value='$product->product_id'>$product->productname</option>";
            }
            return $productsList;
        }
    }

    public function getCategoryProducts(Request $request)
    {
        $products = Product::where('category_id', $request->category)->get();

        if(!is_null($products))
        {
            $productsList = "";

            foreach($products as $product)
            {
                $productsList .= "<option value='$product->product_id'>$product->productname</option>";
            }
            return $productsList;
        }
    }

    public function getKeyProducts(Request $request)
    {
        $products = Product::where('productname', 'like', '%'.$request->key.'%')->get();

        if(!is_null($products))
        {
            $productsList = "";

            foreach($products as $product)
            {
                $productsList .= "<option value='$product->product_id'>$product->productname</option>";
            }
            return $productsList;
        }
    }

    public function getProductPrice(Request $request)
    {
        $product = Product::find($request->product)->first();

        return $product->unitprice;
    }

    public function updateOrderQty(Request $request)
    {
        $order = Orders::find($request->order);
        $product = $order->myProduct;

        if(!is_null($order))
        {
            if($request->qty <= 0)
            {
                $order->delete();
            }
            else
            {
                $order->qty = $request->qty;
                $order->orderprice = ($product->unitprice * $request->qty);
                $order->update();
            }
        }

        return 1;
    }

    public function getCustomerNames(Request $request)
    {
        $key = $request->key;

        $customers = Customer::where('lastname', 'like', '%'.$key.'%')->orwhere('firstname', 'like', '%'.$key.'%')->orderby('lastname', 'asc')->get();

        if(!is_null($customers))
        {
            $customersList = "";

            foreach($customers as $customer)
            {
                $customersList .= "<option value='$customer->cust_id'>$customer->CustomerName</option>";
            }
            return $customersList;
        }
    }

    public function getCustomerName(Request $request)
    {
        $customer = Customer::find($request->customer);

        return $customer->lastname . ', ' . $customer->firstname;
    }

    public function getIdSupplierName(Request $request)
    {
        $supplier = Supplier::find($request->supplier)->first();

        return $supplier->companyname;
    }

    public function checkProductStock(Request $request)
    {
        $product = Product::find($request->product)->first();

        return ($product->stock - $request->qty);
    }

    public function getCustomersJson()
    {
        $customers = Customer::orderby('lastname', 'asc')->geT();

        $customerArr = [];
        foreach($customers as $customer)
        {
            $name = $customer->firstname . " " . $customer->lastname;
            array_push($customerArr, $name);
        }

        return response()->json($customers);
    }
}
