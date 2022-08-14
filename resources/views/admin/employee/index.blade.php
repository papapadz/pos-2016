@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Employee List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            <a href="{{ route('employeeCreate') }}" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Create Employee</a>
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">Employee Name</th>
                                    <th style="background-color: #464646; color: #fff;">Position</th>
                                    <th style="background-color: #464646; color: #fff;">Address</th>
                                    <th style="background-color: #464646; color: #fff;">Contact Number</th>
                                    <th style="background-color: #464646; color: #fff;">Email Address</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                </tr>
                                </thead>

                                @if(count($employees) > 0)
                                    <tbody>
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ strtoupper($employee->employeename) }}</td>
                                            <td>
                                                @if($employee->position == 1)
                                                    Administrator
                                                @elseif($employee->position == 2)
                                                    Supervisor
                                                @elseif($employee->position == 3)
                                                    Accountant
                                                @elseif($employee->position == 4)
                                                    Secretary
                                                @endif
                                            </td>
                                            <td>{{ $employee->address }}</td>
                                            <td>{{ $employee->contactno }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>
                                                @if($employee->employee_id == Auth::user()->employee_id)
                                                    <a href="{{ route('employeeEdit', ['id'=>$employee->employee_id]) }}" class="uk-button uk-button-mini"><i class="uk-icon-pencil"></i></a>
                                                @else
                                                    <a href="{{ route('employeeEdit', ['id'=>$employee->employee_id]) }}" class="uk-button uk-button-mini"><i class="uk-icon-pencil"></i></a>
                                                    <a href="{{ route('employeeDestroy', ['id'=>$employee->employee_id]) }}" class="uk-button uk-button-mini uk-button-danger del-rec"><i class="uk-icon-times"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td colspan="6"><i>{{ count($employees) }} - Employee record found</i></td>
                                    </tr>
                                    </tfoot>
                                @endif

                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('location') Employee @stop

@section('js')
     <script type="text/javascript">
        $(function(){
            $('.del-rec').click(function(){
                var r = confirm('Are you sure you want to delete this record?');

                if(!r){
                    return false;
                }
                else
                {
                    var r = confirm('Other related records will also be deleted, proceed?');

                    if(!r){
                        return false;
                    }
                }
            });
        });
    </script>
@stop