<?php

namespace App\Http\Controllers\Admin;

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
            $customers = Customer::where('companyname', 'like', '%'.$skey.'%')->orwhere('firstname', 'like', '%'.$skey.'%')->orderby('companyname', 'asc')->paginate(15);
            #$customers = Customer::where('lastname', 'like', '%'.$skey.'%')->orwhere('firstname', 'like', '%'.$skey.'%')->orderby('lastname', 'asc')->orderby('cust_type', 'asc')->paginate(15);
        }
           
        else
        {
            $customers = Customer::orderby('companyname', 'asc')->paginate(15);
            #$customers = Customer::orderby('lastname', 'asc')->orderby('cust_type', 'desc')->paginate(15);
        }

        $customerCity = ['0'=>'-Select Place', '1'=>'Laoag', '2'=>'San Nicolas', '3'=>'Bangui', '4'=>'Dumalneg', '5'=>'Dingras', '6'=>'Solsona', '7'=>'Piddig', '8'=>'Banna', '9'=>'Nueva Era', '10'=>'Pasuquin', '11'=>'Badoc', '12'=>'Pagudpud', '13'=>'Vintar', '14'=>'Burgos', '15'=>'Sarrat', '16'=>'Marcos', '17'=>'Bangui/Pagudpud', '18'=>'Claveria-Pamplona', '19'=>'Abulog-Aparri', '20'=>'Sta. Marcela', '21'=>'Flora', '22'=>'Pudtol', '23'=>'Luna', '24'=>'Batac-Currimao', '25'=>'Badoc-Pinili', '26'=>'Sinait-San Juan', '27'=>'Bantay-Vigan', '28'=>'Narvacan-La Union', '29'=>'Abra'];
        
        #$customerCity = ['0'=>'-Select Place', '1'=>'Laoag', '2'=>'San Nicolas', '3'=>'Bangui', '4'=>'Dumalneg', '5'=>'Dingras', '6'=>'Solsona', '7'=>'Piddig', '8'=>'Banna', '9'=>'Nueva Era', '10'=>'Pasuquin', '11'=>'Badoc', '12'=>'Pagudpud', '13'=>'Vintar', '14'=>'Burgos', '15'=>'Sarrat', '16'=>'Marcos'];

        return view('admin.customer.index', compact('customers', 'skey', 'customerCity'));
    }

    /*public function agentindex(Request $request)
    {  
        $customerType = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',];

        $custAgent = Customer::where('cust_type', $request)->get();

        return view('admin.customer.agentindex', compact('custAgent));
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        #$customerType = ['1'=>'Government', '2'=>'Non-Government'];
        $customerType = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];
        
        $customerCity = ['0'=>'-Select Place', '1'=>'Laoag', '2'=>'San Nicolas', '3'=>'Bangui', '4'=>'Dumalneg', '5'=>'Dingras', '6'=>'Solsona', '7'=>'Piddig', '8'=>'Banna', '9'=>'Nueva Era', '10'=>'Pasuquin', '11'=>'Badoc', '12'=>'Pagudpud', '13'=>'Vintar', '14'=>'Burgos', '15'=>'Sarrat', '16'=>'Marcos', '17'=>'Bangui/Pagudpud', '18'=>'Claveria-Pamplona', '19'=>'Abulog-Aparri', '20'=>'Sta. Marcela', '21'=>'Flora', '22'=>'Pudtol', '23'=>'Luna', '24'=>'Batac-Currimao', '25'=>'Badoc-Pinili', '26'=>'Sinait-San Juan', '27'=>'Bantay-Vigan', '28'=>'Narvacan-La Union', '29'=>'Abra'];
        
        return view('admin.customer.create', compact('customerType', 'customerCity'));
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

        return redirect()->route('customerIndex');
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

        $customerType = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];

        $customerCity = ['0'=>'-Select Place', '1'=>'Laoag', '2'=>'San Nicolas', '3'=>'Bangui', '4'=>'Dumalneg', '5'=>'Dingras', '6'=>'Solsona', '7'=>'Piddig', '8'=>'Banna', '9'=>'Nueva Era', '10'=>'Pasuquin', '11'=>'Badoc', '12'=>'Pagudpud', '13'=>'Vintar', '14'=>'Burgos', '15'=>'Sarrat', '16'=>'Marcos', '17'=>'Bangui/Pagudpud', '18'=>'Claveria-Pamplona', '19'=>'Abulog-Aparri', '20'=>'Sta. Marcela', '21'=>'Flora', '22'=>'Pudtol', '23'=>'Luna', '24'=>'Batac-Currimao', '25'=>'Badoc-Pinili', '26'=>'Sinait-San Juan', '27'=>'Bantay-Vigan', '28'=>'Narvacan-La Union', '29'=>'Abra'];
        
        return view('admin.customer.edit', compact('customer', 'customerType', 'customerCity'));
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

        return redirect()->route('customerIndex');
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
