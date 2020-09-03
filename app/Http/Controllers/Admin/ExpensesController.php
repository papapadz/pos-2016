<?php

namespace App\Http\Controllers\Admin;

use App\Expenses;
use App\Customer;
use App\Product;
use App\Payment;
use App\Sales;
use App\SalesDetails;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ExpensesRequest;
use App\Http\Controllers\Controller;


class ExpensesController extends Controller
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

        $dateToFormat = date('Y-m-d');

        ##edit starts here
        $monthSel = (!is_null($request->monthly)) ? $request->monthly : 1;
        if(strlen($monthSel) == 1)
        {
            $monthSel = '0'.$monthSel;
        }

        $months = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $month = $request->monthly;
        $agentExpense = ($request->expenses == 0) ? null : $request->expenses;

        if(!is_null($request->monthly))
        {
            
            if(is_null($agentExpense))
            {
                $reportStart = date('Y-'.$monthSel.'-01').' 00:00:00';
                $reportEnd = date('Y-'.$monthSel.'-31').' 23:59:59';
                #$reports = Expenses::orderby('expensedate', 'desc')->get();
                $reports = Expenses::wherebetween('expensedate', [$reportStart, $reportEnd])->orderby('expensedate', 'desc')->get();
            
            }
            else
            {
                $reportStart = date('Y-'.$monthSel.'-01').' 00:00:00';
                $reportEnd = date('Y-'.$monthSel.'-31').' 23:59:59';
                #$reports = Expenses::where('agent', $agentExpense)->orderby('expensedate', 'desc')->get();
                $reports = Expenses::where('agent', $agentExpense)->wherebetween('expensedate', [$reportStart, $reportEnd])->orderby('expensedate', 'desc')->get();
            }

        }
        else
        {
            $reportStart = date('Y-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date('Y-'.$monthSel.'-31').' 23:59:59';

            $reports = Expenses::where('agent', $agentExpense)->wherebetween('expensedate', [$reportStart, $reportEnd])->orderby('expensedate', 'desc')->get();
        }

        $agents = ['0'=>'--Select Agent--', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];
        $customerType = ['0'=>'--Select Agent--', '1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael',]; #+ Customer::orderby('cust_type', 'asc')->lists('cust_type', 'cust_id')->all();
        
        $custSel = ($request->customer == 0) ? null : $request->customer;

        $expensesAgent = Expenses::where('agent', $agents)->orderby('expensedate', 'desc')->get();
        $customers = Customer::where('cust_type', $custSel)->orderby('lastname', 'asc')->get();


        $totalExpenses = 0;

        foreach($reports as $report)
        {
            $totalExpenses += (($report->food) + ($report->home_stay) + ($report->diesel) + ($report->load) + ($report->others));
        }

        return view('admin.expenses.index', compact('expenses', 'reports', 'months', 'monthSel', 'reportStart', 'reportEnd', 'agents', 'customerType', 'custSel', 'agentExpense', 'expensesAgent', 'totalExpenses'));
    }

    public function create()
    {
        $agents = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];

        return view('admin.expenses.create', compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

    public function store(ExpensesRequest $request)
    {
        $expenses = new Expenses();
        $expenses->create($request->all());

        return redirect()->route('expensesIndex');
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
        $expenses = Expenses::find($id);
        $agents = ['1'=>'Chabby', '2'=>'Darren', '3'=>'Gerry', '4'=>'Michael'];

        return view('admin.expenses.edit', compact('expenses', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ExpensesRequest $request, $id)
    {
        $expenses = Expenses::find($id);
        $expenses->update($request->all());

        return redirect()->route('expensesIndex');
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
            Expenses::find($id)->delete();
            return redirect()->back();
            #return 1;
        }
        catch(\Exception $e){
            return ("This expenses record cannot be deleted!");
        }
        
    }
}
