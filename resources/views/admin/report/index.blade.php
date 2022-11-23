@extends('admin')

@section('content')
<div uk-grid>
    <div class="uk-width-1-2"><h2>Sales Report</h2></div>
    <div class="uk-width-1-2 uk-text-right">
        {!! Form::open(['route'=>'reportIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
        {!! Form::select('option', ['1'=>'Daily Report', '2'=>'Monthly Report'], $option, ['id'=>'report-option']) !!}
        {{-- {!! Form::text('daily', $daySel, ['id'=>'daily']) !!} --}}
        <input name="daily" id="daily" value="{{ Carbon\Carbon::now()->toDateString() }}">
        {!! Form::select('monthly', $months, $monthSel, ['id'=>'monthly', 'disabled']) !!}
        {!! Form::select('year', $years, $yearSel, ['id'=>'year', 'disabled']) !!}
        {!! Form::button('Search ', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary uk-button-small', 'uk-icon' => 'icon: search']) !!}
        {{-- <a href="{{ route('reportPrint', ['option'=>$option, 'day'=>$daySel, 'month'=>$monthSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a> --}}
        {!! Form::close() !!}
    </div>
</div>


                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">ID</th>
                                    <th style="background-color: #464646; color: #fff;">Date</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Gross Amount</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Discount</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Net Amount</th>
                                </tr>
                                </thead>
                                <tbody>

                                {{--*/ $total = 0; /*--}}
                                {{--*/ $cash = 0; /*--}}
                                <div style="display: none">{{ $discount = 0 }}</div>
                                    @foreach($reports as $report)
                                    <div style="display: none">{{ $discount += $report->fixedAmtDiscount }}</div>
                                        <tr>
                                            <td><a href="{{ route('salesSummary', $report->sales_id) }}">{{ $report->invoicenumber }}</td>
                                            <td>{{ Carbon\Carbon::parse($report->salesdate)->toDateString() }}</td>
                                            <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                                            <td style="text-align: right;">{{ number_format($report->fixedAmtDiscount, 2) }}</td>
                                            <td style="text-align: right;">{{ number_format($report->totalsales-$report->fixedAmtDiscount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                                <table width="100%">
                                    <tr class="uk-text">
                                        <td colspan="3" class="uk-text-right"><strong>Gross Sales:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($sumSales, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text">
                                        <td colspan="3" class="uk-text-right"><strong>Discounts:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($discount, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr class="uk-text-large">
                                        <td colspan="3" class="uk-text-right"><strong>Net Sales:</strong></td>
                                        <td width="135" style="text-align: right;"><strong>{{ number_format($sumSales-$discount, 2) }}</strong></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>

                        </div>

                    
@stop

@section('location') Reports @stop

@section('css')
@stop

@section('js')
<script>
    $('table.uk-table').DataTable()
</script>
    <script>
        $(function(){
            var option = $('#report-option').val();
            $( "#daily" ).datepicker({ dateFormat: 'yy-mm-dd' });
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