<?php

namespace App\Http\Controllers\Admin;

use App\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SupplierRequest;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
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
        $skey = ($request->skey == '') ? null : $request->skey;

        if(!is_null($skey))
        {
            $suppliers = Supplier::where('lastname', 'like', '%'.$skey.'%')->orwhere('firstname', 'like', '%'.$skey.'%')->orderby('companyname', 'asc')->paginate(10);
        }
        else
        {
            $suppliers = Supplier::orderby('companyname', 'asc')->paginate(10);
        }

        return view('admin.supplier.index', compact('suppliers', 'skey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(SupplierRequest $request)
    {
        $supplier = new Supplier();
        $supplier->create($request->all());

        return redirect()->route('supplierIndex');
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
        $supplier = Supplier::find($id);

        return view('admin.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->update($request->all());

        return redirect()->route('supplierIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        try{
            Supplier::find($id)->delete();
            return redirect()->back();
            #return 1;
        }
        catch(\Exception $e){
            return ("This supplier record cannot be deleted!");
        }  
    }

    /*public function destroy($id)
    {
        Supplier::find($id)->delete();

        return redirect()->back();
    }*/
}
