@extends('admin')

@section('content')

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Report Generation</h2>

                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                    {!! Form::open(['route'=>['reportCustomerSalesIndex', 'id'=>$id], 'method'=>'get', 'class'=>'uk-form']) !!}
                    {!! Form::text('date', $dateSel, ['placeholder'=>'YYYY-MM-DD', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                    {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                    <a href="{{ route('reportCustomerSalesPrint', ['date'=>($dateSel == null || $dateSel == '') ? 0 : $dateSel, 'id'=>$id]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                    {!! Form::close() !!}
                </div>

                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                    <tr>
                        <th style="background-color: #464646; color: #fff;">Invoice #</th>
                        <th style="background-color: #464646; color: #fff;">Sales Date</th>
                        <th style="background-color: #464646; color: #fff;">VATable Sales</th>
                        <th style="background-color: #464646; color: #fff;">12% VAT</th>
                        <th style="background-color: #464646; color: #fff;">Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($reports) > 0)
                        @foreach($reports as $report)
                            <tr>
                                {{--*/
                                $vatSales = $report->myDetails->sum('sales_price') / 1.12;
                                $vat = $vatSales * .12;
                                $salesAmt = $report->myDetails->sum('sales_price');
                                /*--}}
                                <td>{{ $report->invoicenumber }}</td>
                                <td>{{ substr($report->salesdate, 0, 10) }}</td>
                                <td>{{ number_format($vatSales, 2) }}</td>
                                <td>{{ number_format($vat, 2) }}</td>
                                <td>{{ number_format($salesAmt, 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
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