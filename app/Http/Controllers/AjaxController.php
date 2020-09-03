<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Orders;
use App\Product;
use App\Sales;
use App\Payment;
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
        $products = Product::where('category_id', $request->category)->groupby('productname')->where('status', 0)->get();

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
        $products = Product::where('productname', 'like', '%'.$request->key.'%')->orwhere('productcode', 'like', '%'.$request->key.'%')->where('status', 0)->get();

        #$products = Product::where('productname', 'like', '%'.$request->key.'%')->where('status', 0)->get();

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
        $product = Product::where('product_id', $request->product)->first();

        return $product->unitprice;
    }

    public function updateOrderQty(Request $request)
    {
        $order = Orders::where('order_id', $request->order)->first();
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

        $customers = Customer::where('companyname', 'like', '%'.$key.'%')->orwhere('firstname', 'like', '%'.$key.'%')->orderby('companyname', 'asc')->get();

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
        $customer = Customer::where('cust_id', $request->customer)->first();

        return $customer->companyname . ' -- ' . $customer->lastname;
    }

    public function getIdSupplierName(Request $request)
    {
        $supplier = Supplier::where('supplier_id', $request->supplier)->first();

        return $supplier->companyname;
    }

    public function checkProductStock(Request $request)
    {
        $product = Product::where('product_id', $request->product)->first();

        return ($product->stock - $request->qty);
    }

    public function getCustomersJson()
    {
        $customers = Customer::orderby('companyname', 'asc')->get();

        $customerArr = [];
        foreach($customers as $customer)
        {
            $name = $customer->companyname . " --- " . $customer->lastname;
            array_push($customerArr, $name);
        }

        return response()->json($customers);
    }

    public function checkProductOnHand(Request $request)
    {
        $product = Product::where('product_id', $request->product)->first();

        return $product->stock;
    }

    public function updateProductUnitCost(Request $request)
    {
        $product = Product::where('product_id', $request->product)->first();
        $product->unitcost = $request->newUnitCost;
        $product->unitprice = ($request->newUnitCost * ($product->markup / 100)) + $request->newUnitCost;
        $product->update();

        return 1;
    }

    public function storeProductUnitCost(Request $request)
    {
        $productOld = Product::where('product_id', $request->product)->first();
        $productName = $productOld->productname;
        $unitCost = $request->cost;
        $unitPrice = ($request->cost * ($productOld->markup / 100)) + $request->cost;

        $productNew = new Product();
        $productNew->productname = $productName;
        $productNew->unitprice = $unitPrice;
        $productNew->unitcost = $unitCost;
        $productNew->markup = $productOld->markup;
        $productNew->reorderlimit = $productOld->reorderlimit;
        $productNew->category_id = $productOld->category_id;
        $productNew->supplier_id = $productOld->supplier_id;
        $productNew->save();

        return 1;
    }

    public function getProductCost(Request $request)
    {
        $product = Product::where('product_id', $request->product)->first();

        return $product->unitcost;
    }

    public function getDeliveryProducts(Request $request)
    {
        $products = Product::where('productname', $request->productlist)->orderby('product_id', 'desc')->get();

        $productList = '';
        foreach($products as $product)
        {
            $productList .= "<option value=$product->product_id>$product->productname - ".number_format($product->unitcost, 2)."</option>";
        }

        return $productList;
    }

    public function getSalesProducts(Request $request)
    {
        $products = Product::where('productname', $request->productlist)->orderby('product_id', 'desc')->where('status', 0)->get();

        $productList = '';
        foreach($products as $product)
        {
            $productList .= "<option value=$product->product_id>$product->productname - ".number_format($product->unitprice, 2)."</option>";
        }

        return $productList;
    }

    public function checkCustomerCredit(Request $request)
    {
        $credit = Sales::where('cust_id', $request->customer)->where('sales_type', 2)->where('status', 0)->get();

        #$balance = Sales::where('status', 0)->where('cust_id', $request->customer)

        if(count($credit) > 0)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    public function getCustomerCreditAmt(Request $request)
    {
        $credits = Sales::where('cust_id', $request->customer)->where('sales_type', 2)->where('status', 0)->orderby('sales_id', 'desc')->get();

        $totalBalance = 0;
        foreach ($credits as $credit) {
            $payment = $credit->myPayments()->orderby('payment_id', 'desc')->first();
            $totalBalance += $payment->balancedue;
        }

        return number_format($totalBalance, 2);
    }
}
