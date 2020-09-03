<?php

namespace App\Http\Controllers\Secretary;

use App\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CustomerRequest;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
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
            $customers = Customer::where('lastname', 'like', '%'.$skey.'%')->orwhere('firstname', 'like', '%'.$skey.'%')->orderby('lastname', 'asc')->orderby('cust_type', 'asc')->paginate(15);
        }
        else
        {
            $customers = Customer::orderby('lastname', 'asc')->orderby('cust_type', 'desc')->paginate(15);
        }

        return view('secretary.customer.index', compact('customers', 'skey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $customerType = ['1'=>'Government', '2'=>'Non-Government'];

        return view('secretary.customer.create', compact('customerType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $customer->create($request->all());

        return redirect()->route('secretaryCustomerIndex');
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
        $customer = Customer::find($id);
        $customerType = ['1'=>'Government', '2'=>'Non-Government'];

        return view('secretary.customer.edit', compact('customer', 'customerType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CustomerRequest $request, $id)
    {
        Customer::find($id)->update($request->all());

        return redirect()->route('secretaryCustomerIndex');
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
            Customer::find($id)->delete();
            return redirect()->back();
            #return 1;
        }
        catch(\Exception $e){
            return ("This customer record cannot be deleted!");
        }  
    }

    /*public function destroy(Request $request)
    {
        $id = $request->customer;
        try{
            Customer::find($id)->delete();
            return 1;
        }
        catch(\Exception $e){
            return 0;
        }
    }*/
}
