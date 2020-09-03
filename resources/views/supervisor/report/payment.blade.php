@extends('supervisor')

@section('content')
    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Report of Payment</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'supervisorReportPaymentIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::select('option', ['1'=>'All Paid', '2'=>'All Unpaid[/w Balance]'], $option, ['placeholder'=>'Search...', 'class'=>'uk-width-1-4']) !!}
                            {!! Form::select('month', $months, $monthSel, []) !!}
                            {!! Form::select('year', $years, $yearSel, []) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            <a href="{{ route('supervisorReportPaymentPrint', ['option'=>$option, 'month'=>$monthSel, 'year'=>$yearSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">Date</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center; width: 250px;">Invoice Number</th>
                                    <th style="background-color: #464646; color: #fff;">Customer</th>
                                    @if($option == 1)
                                        <th style="background-color: #464646; color: #fff; text-align: right;">Total Sales Amount</th>
                                        <th style="background-color: #464646; color: #fff; text-align: right; width: 250px;">Total Payment</th>
                                        <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    @else
                                        <th style="background-color: #464646; color: #fff; text-align: right;">Total Sales Amount</th>
                                        <th style="background-color: #464646; color: #fff; text-align: right; width: 180px;">Total Payment</th>
                                        <th style="background-color: #464646; color: #fff; text-align: right;">Balance Due</th>
                                        <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($reports) > 0)
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ substr($report->salesdate, 0, 10) }}</td>
                                            <td style="text-align: center;">{{ $report->invoicenumber }}</td>
                                            <td>{{ $report->myCustomer->lastname }}, {{ $report->myCustomer->firstname }}</td>
                                            @if($option == 1)
                                                <td style="text-align: right;">{{ number_format($report->myPayment()->first()->amountpaid, 2) }}</td>
                                                <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                                                <td>&nbsp;</td>

                                            @else
                                                <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                                                <td style="text-align: right;">{{ number_format($report->totalsales - $report->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) }}</td>
                                                <td style="text-align: right;">{{ number_format($report->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) }}</td>
                                                <td>&nbsp;</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
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
            }
            else if(option == 2)
            {
                $('#monthly').prop('disabled', false);
                $('#daily').prop('disabled', true);
            }

            $('#report-option').change(function(){
                var option = $(this).val();
                if(option == 1)
                {
                    $('#daily').prop('disabled', false);
                    $('#monthly').prop('disabled', true);
                }
                else if(option == 2)
                {
                    $('#monthly').prop('disabled', false);
                    $('#daily').prop('disabled', true);
                }
            });
        })
    </script>
@stop