<?php

namespace App\Http\Controllers\Supervisor;

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

        $products = Product::where('status', $status)->orderby('productname', 'asc')->paginate(15);
        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();

        $skey = ($request->skey == '') ? null : $request->skey;

        if(!is_null($skey))
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->where('productname', 'like', '%'.$skey.'%')->orderby('productname', 'asc')->orderby('product_id', 'asc')->paginate(15);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }
        else
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->paginate(15);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }
        
        return view('supervisor.products.index', compact('products', 'suppliers', 'status', 'skey'));

        #return view('supervisor.products.index', compact('products', 'suppliers', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $reorderlimit = ['0'=>'Limit', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50', '100'=>'100', '200'=>'200',];
        $markup = ['0'=>'markup', '5'=>'5%', '10'=>'10%', '15'=>'15%', '20'=>'20%', '25'=>'25%', '30'=>'30%', '35'=>'35%', '40'=>'40%',];
        $categories = Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();
        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();

        return view('supervisor.products.create', compact('categories', 'reorderlimit', 'markup', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {

        $unitprice = ($request->unitcost * ($request->markup/100)) + $request->unitcost;

        $product = new Product();
        $product->productname = $request->productname;
        $product->unitprice = $unitprice;
        $product->reorderlimit = $request->reorderlimit;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->unitcost = $request->unitcost;
        $product->status = $request->status;
        $product->save();
        
        //return redirect()->route('supervisorProductsIndex');
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

        $reorderlimit = ['0'=>'Limit', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50', '100'=>'100', '200'=>'200',];
        $markup = ['0'=>'markup', '5'=>'5%', '10'=>'10%', '15'=>'15%', '20'=>'20%', '25'=>'25%', '30'=>'30%', '35'=>'35%', '40'=>'40%',];
        $categories = Category::orderby('categoryname', 'asc')->lists('categoryname', 'category_id')->all();
        $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();

        return view('supervisor.products.edit', compact('product', 'reorderlimit', 'markup', 'categories', 'suppliers'));
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

        $unitprice = ($request->unitcost * ($request->markup/100)) + $request->unitcost;

        Product::find($id)->update($request->all());

        //$product = new Product();
        $product->productname = $request->productname;
        $product->unitprice = $unitprice;
        $product->reorderlimit = $request->reorderlimit;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->unitcost = $request->unitcost;
        $product->update();

        return redirect()->route('supervisorProductsIndex');
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
            $products = Product::where('status', $status)->orderby('productname', 'asc')->where('productname', 'like', '%'.$skey.'%')->orderby('productname', 'asc')->orderby('product_id', 'asc')->paginate(15);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }
        else
        {
            $products = Product::where('status', $status)->orderby('productname', 'asc')->paginate(15);
            $suppliers = Supplier::orderby('companyname', 'asc')->lists('companyname', 'supplier_id')->all();
        }

        return view('supervisor.products.index', compact('products', 'suppliers', 'status', 'skey'));
    }
}

