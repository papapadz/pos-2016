  public function agent(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $custSel = ($request->customer == 0) ? null : $request->customer;

        if(is_null($custSel))
        {
            $reports = Customer::orderby('lastname', 'asc')->get();
            $expenses =
        }
        else
        {
            $reports = Customer::where('cust_type', $custSel)->orderby('lastname', 'asc')->get();
        }

       

        $customerType = ['0'=>'--Select Agent--', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',]; #+ Customer::orderby('cust_type', 'asc')->lists('cust_type', 'cust_id')->all();

        return view('admin.report.agent', compact('dateToFormat', 'custSel', 'reports', 'customerType'));
    }

    public function printAgentReport($customer)
    {
        $dateToFormat = date('Y-m-d');

        $custSel = ($cust_type == 0 || is_null($cust_type) || $cust_type == '') ? null : $cust_type;

        if(is_null($custSel))
        {
            $reports = Customer::orderby('lastname', 'asc')->get();
        }
        else
        {
            $reports = Customer::where('cust_id', $custSel)->orderby('lastname', 'asc')->get();
        }

        return view('admin.report.printagent', compact('dateToFormat', 'reports', 'custSel'));
    }