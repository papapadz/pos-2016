<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeEditRequest;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
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
    public function index()
    {
        $employees = Employee::orderby('position', 'asc')->get();

        return view('admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //$admin = Employee::where('position', 1)->first();

        // if(!is_null($admin))
        // {
        //     $employeeType = ['2'=>'Supervisor', '3'=>'Accountant', '4'=>'Secretary'];
        // }
        // else
        // {
        //     $employeeType = ['1'=>'Administrator', '2'=>'Supervisor', '3'=>'Accountant', '4'=>'Secretary'];
        // }
        if(Auth::User()->position==1)
            $employeeType = ['1'=>'Administrator', '2'=> 'Manager', '3'=>'Helper'];
        else
            $employeeType = ['2'=> 'Manager', '3'=>'Helper'];
            
        return view('admin.employee.create', compact('employeeType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(EmployeeRequest $request)
    {
        $employee = new Employee();
        $employee->employeename = $request->employeename;
        $employee->position = $request->position;
        $employee->username = $request->username;
        $employee->password = $request->password;
        $employee->address = $request->address;
        $employee->contactno = $request->contactno;
        $employee->email = $request->email;
        $employee->save();

        return redirect()->route('employeeIndex');
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
        $employee = Employee::find($id);
        $admin = Employee::where('position', 1)->first();

        if(!is_null($admin))
        {
            $employeeType = ['2'=>'Supervisor', '3'=>'Accountant', '4'=>'Secretary'];
        }
        else
        {
            $employeeType = ['1'=>'Administrator', '2'=>'Supervisor', '3'=>'Accountant', '4'=>'Secretary'];
        }

        return view('admin.employee.edit', compact('employee', 'employeeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EmployeeEditRequest $request, $id)
    {
        if(!is_null($request->password) || $request->password != '')
        {
            Employee::find($id)->update($request->all());
        }
        return redirect()->route('employeeIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Employee::find($id)->delete();

        return redirect()->back();
    }
}
