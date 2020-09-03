@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Sales Report</h2>

                       <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'reportIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::select('option', ['1'=>'Daily Report', '2'=>'Monthly Report'], $option, ['id'=>'report-option']) !!}
                            {!! Form::text('daily', $daySel, ['id'=>'daily', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                            {!! Form::select('monthly', $months, $monthSel, ['id'=>'monthly', 'disabled']) !!}
                            {!! Form::select('year', $years, $yearSel, ['id'=>'year', 'disabled']) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            <a href="{{ route('reportPrint', ['option'=>$option, 'day'=>$daySel, 'month'=>$monthSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">Invoice Number</th>
                                    <th style="background-color: #464646; color: #fff;">Customer Name</th>
                                    <th style="background-color: #464646; color: #fff;">Agent</th>
                                    <th style="background-color: #464646; color: #fff;">Sales Type</th>
                                    <th style="background-color: #464646; color: #fff;">Sales Status</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Sales Amount</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Balance Due</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>

                                {{--*/ $total = 0; /*--}}
                                {{--*/ $cash = 0; /*--}}

                                @if(count($reports) > 0)
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><a href="{{ route('salesSummary', $report->sales_id) }}">{{ $report->invoicenumber }}</td>
                                            <td>{{ $report->myCustomer->lastname }}, {{ $report->myCustomer->firstname }}</td>
                                            <td>
                                                @if($report->myCustomer->cust_type == 1)
                                                    Chabby
                                                @elseif($report->myCustomer->cust_type == 2)
                                                    Darren
                                                @elseif($report->myCustomer->cust_type == 3)
                                                    Gerry
                                                @elseif($report->myCustomer->cust_type == 4)
                                                    Michael
                                                @endif
                                            </td>
                                            <td>{{ $report->sales_type == 1 ? 'Cash' : 'Credit'}}</td>
                                            <td>{{ $report->status == 0 ? 'Unpaid' : 'Paid'}}</td>
                                            <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                                            <td style="text-align: right;">{{ number_format($report->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) }}</td>
                                            <td>&nbsp;</td>

                                        </tr>

                                        @if($report->status == 1)
                                            {{--*/ $cash += $report->totalsales; /*--}}
                                        @endif

                                        {{--*/ $total += $report->totalsales; /*--}}

                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                                <table width="100%">
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Sales:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($sumSales, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Accounts Receivables:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($sumCredit, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Cash:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($sumSales - $sumCredit, 2) }}</strong></td>
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

@section('location') Reports @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>

    <script>
        $(function(){
            var option = $('#report-option').val();
            if(option == 1)
            {
                $('#daily').prop('disabled', false);
                $('#monthly').prop('disabled', true);
                $('#year').prop('disabled', true);
            }
            else if(option == 2)
            {
                $('#monthly').prop('disabled', false);
                $('#year').prop('disabled', false);
                $('#daily').prop('disabled', true);
            }

            $('#report-option').change(function(){
                var option = $(this).val();
                if(option == 1)
                {
                    $('#daily').prop('disabled', false);
                    $('#monthly').prop('disabled', true);
                    $('#year').prop('disabled', true);
                }
                else if(option == 2)
                {
                    $('#monthly').prop('disabled', false);
                    $('#year').prop('disabled', false);
                    $('#daily').prop('disabled', true);
                }
            });
        })
    </script>
@stop