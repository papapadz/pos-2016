@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:20px;">

                        <h2>Expenses List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                            {!! Form::open(['route'=>'expensesIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::select('expenses', $agents, $agentExpense) !!}
                            {!! Form::select('monthly', $months, $monthSel, ['id'=>'monthly']) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            
                            <a href="{{ route('expensesCreate') }}" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> New Record</a>
                            {!! Form::close() !!}
                        </div>

                        

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">Date</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Food</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Home Stay</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Diesel</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Load</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Others</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Total</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                </tr>
                                </thead>

                                @if(count($reports) > 0)
                                    <tbody>
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ substr($report->expensedate, 0, 10) }}</td>
                                            <td style="text-align: center;">{{ number_format($report->food, 2) }}</td>
                                            <td style="text-align: center;">{{ number_format($report->home_stay, 2) }}</td>
                                            <td style="text-align: center;">{{ number_format($report->diesel, 2) }}</td>
                                            <td style="text-align: center;">{{ number_format($report->load, 2) }}</td>
                                            <td style="text-align: center;">{{ number_format($report->others, 2) }}</td>
                                            <td style="text-align: center;">{{ number_format(($report->food) + ($report->home_stay) + ($report->diesel) + ($report->load) + ($report->others), 2) }}</td>
                                            <td>&nbsp;</td>
                                            <td class="uk-text-right">
                                            <a href="{{ route('expensesEdit', ['id'=>$report->id]) }}" title="Edit"><i class="uk-icon-pencil"></i></a>
                                            <a href="{{ route('expensesDestroy', ['id'=>$report->id]) }}" class="uk-text-danger del-rec"  title="Delete"><i class="uk-icon-times"></i></a>
                                            <td>&nbsp;</td>
                                        </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td colspan="6"><i>{{ count($reports) }} - Expenses record found</i></td>
                                    </tr>
                                    </tfoot>
                                @endif

                            </table>
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                                <table width="100%">
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Expenses:</strong></td>
                                        <td width="150" style="text-align: right;"><strong>{{ number_format($totalExpenses, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('location') Expenses @stop

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