@extends('accountant')

@section('content')
    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Sales by Customer Type</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'accountantReportSalesIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::select('option', ['0'=>'--All--', '1'=>'Government', '2'=>'Non-Government'], $optSel) !!}
                            {!! Form::select('monthly', $months, $monthSel, ['id'=>'monthly']) !!}
                            {!! Form::select('yearly', $years, $yearSel, ['id'=>'monthly']) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            <a href="{{ route('accountantReportSalesPrint', ['option'=>$optSel, 'year'=>$yearSel, 'month'=>$monthSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff; text-align: left;">Date</th>
                                    <th style="background-color: #464646; color: #fff; text-align: center;">Invoice Number</th>
                                    <th style="background-color: #464646; color: #fff; text-align: left;">Customer</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">VATable Sales</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">VAT</th>
                                    @if($optSel < 2)
                                        <th style="background-color: #464646; color: #fff; text-align: right;">1%(CIT)</th>
                                        <th style="background-color: #464646; color: #fff; text-align: right;">5%(CVAT)</th>
                                    @endif
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Sales Amount</th>
                                </tr>
                                </thead>
                                <tbody>

                                {{--*/ $vatable = 0; /*--}}
                                {{--*/ $vat = 0; /*--}}
                                {{--*/ $salesAmount = 0; /*--}}
                                {{--*/ $one = 0; /*--}}
                                {{--*/ $five = 0; /*--}}

                                @if(count($reports) > 0)
                                    @foreach($reports as $report)
                                        <tr>
                                            <td style="text-align: left;">{{ substr($report->salesdate, 0, 10) }}</td>
                                            <td style="text-align: center;">{{ $report->invoicenumber }}</td>
                                            <td style="text-align: left;">{{ $report->lastname }}, {{ $report->firstname }}</td>
                                            <td style="text-align: right;">{{ number_format($report->totalsales / 1.12, 2) }}</td>
                                            <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .12, 2) }}</td>
                                            @if($optSel == 0)
                                                @if($report->cust_type == 1)
                                                    <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .01, 2) }}</td>
                                                    <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .05, 2) }}</td>
                                                    
                                                @else
                                                    <td style="text-align: right;">N/A</td>
                                                    <td style="text-align: right;">N/A</td>
                                                @endif
                                            @elseif($optSel == 1)
                                                <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .01, 2) }}</td>
                                                <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .05, 2) }}</td>
                                            @endif
                                            <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                                        </tr>

                                        {{--*/ $vatable += $report->totalsales / 1.12; /*--}}
                                        {{--*/ $vat += ($report->totalsales / 1.12) * .12; /*--}}
                                        {{--*/ $salesAmount += $report->totalsales; /*--}}
                                        {{--*/ $one += ($report->totalsales / 1.12) * .01; /*--}}
                                        {{--*/ $five += ($report->totalsales / 1.12) * .05; /*--}}

                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                                <table width="100%">
                                @if($report->cust_type == 1)
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Vatable Sales:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($vatable, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total VAT:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($vat, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total CIT:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($one, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total CVAT:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($five, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Sales Amount:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($salesAmount, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @else
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Vatable Sales:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($vatable, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total VAT:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($vat, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Total Sales Amount:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($salesAmount, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif
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