<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use App\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
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

        if(is_null($request->status))
        {
            $status = 0;
        }
        else
        {
            $status = $request->status;
        }

        $products = Product::where('status', $status)->orderby('productname', 'asc')->paginate(50);
        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();

        $skey = ($request->skey == '') ? null : $request->skey;

        if(!is_null($skey))
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->where('productname', 'like', '%'.$skey.'%')->orwhere('productcode', 'like', '%'.$skey.'%')->orderby('productname', 'asc')->orderby('product_id', 'asc')->paginate(50);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }
        else
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->paginate(50);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }
        
        return view('admin.products.index', compact('products', 'suppliers', 'status', 'skey'));

        #return view('admin.products.index', compact('products', 'suppliers', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $reorderlimit = ['0'=>'Limit', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50', '100'=>'100', '200'=>'200', '250'=>'250', '300'=>'300', '500'=>'500', '750'=>'750',];
        #$markup = ['0'=>'markup', '2'=>'2', '4'=>'4', '5'=>'5', '8'=>'8', '10'=>'10', '12'=>'12', '15'=>'15', '18'=>'18', '20'=>'20', '22'=>'22', '24'=>'24', '25'=>'25', '28'=>'28', '30'=>'30', '35'=>'35','40'=>'40','50'=>'50','60'=>'60','80'=>'80',];
        $percentage = ['0'=>'%', '5'=>'5%', '10'=>'10%', '15'=>'15%', '20'=>'20%', '25'=>'25%', '30'=>'30%', '35'=>'35%', '40'=>'40%', '45'=>'45%', '50'=>'50%',];


        $categories = Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();
        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();

        return view('admin.products.create', compact('categories', 'reorderlimit', 'percentage', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {

        #$unitprice = ($request->unitcost * ($request->percentage/100)) + $request->unitcost;
        #$unitprice = (($request->unitcost * ($request->percentage/100)) + $request->unitcost) + $request->markup;

        $product = new Product();
        $product->productcode = $request->productcode;
        $product->productname = $request->productname;
        $product->pattern = $request->pattern;  //new
        $product->unitprice = $request->unitprice;  // $product->unitprice = $unitprice;
        $product->reorderlimit = 100;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->unitcost = $request->unitcost;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('productsIndex');
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
        $product = Product::find($id);

        $reorderlimit = ['0'=>'Limit', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50', '100'=>'100', '200'=>'200', '250'=>'250', '300'=>'300', '500'=>'500', '750'=>'750',];
        #$markup = ['0'=>'markup', '2'=>'2', '4'=>'4', '5'=>'5', '8'=>'8', '10'=>'10', '12'=>'12', '15'=>'15', '18'=>'18', '20'=>'20', '22'=>'22', '24'=>'24', '25'=>'25', '28'=>'28', '30'=>'30', '35'=>'35','40'=>'40','50'=>'50','60'=>'60','80'=>'80',];
        $percentage = ['0'=>'%', '5'=>'5%', '10'=>'10%', '15'=>'15%', '20'=>'20%', '25'=>'25%', '30'=>'30%', '35'=>'35%', '40'=>'40%', '45'=>'45%', '50'=>'50%',];

        $categories = Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();
        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();

        return view('admin.products.edit', compact('product', 'reorderlimit', 'percentage', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        #$unitprice = ($request->unitcost * ($request->percentage/100)) + $request->unitcost;
        #$unitprice = (($request->unitcost * ($request->percentage/100)) + $request->unitcost) + $request->markup;

        Product::find($id)->update($request->all());

        //$product = new Product();
        $product->productcode = $request->productcode;
        $product->productname = $request->productname;
        $product->pattern = $request->pattern;  //new
        $product->unitprice = $request->unitprice;  // $product->unitprice = $unitprice;
        //$product->reorderlimit = 10;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->unitcost = $request->unitcost;
        $product->update();

        return redirect()->route('productsIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->product;
        try{
            Product::find($id)->delete();
            return 1;
        }
        catch(\Exception $e){
            return 0;
        }
    }

    public function setStatus($id)
    {
        $product = Product::where('product_id', $id)->first();
        if($product->status == 0)
        {
            $product->status = 1;
        }
        else
        {
            $product->status = 0;
        }

        $product->update();

        return redirect()->back();
    }

    public function searchProduct(Request $request)
    {
        $skey = ($request->skey == '') ? null : $request->skey;

        if(!is_null($skey))
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->where('productname', 'like', '%'.$skey.'%')->orderby('productname', 'asc')->orderby('product_id', 'asc')->paginate(50);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }
        else
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->paginate(50);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }

        return view('admin.products.index', compact('products', 'suppliers', 'status', 'skey'));
    }
}

