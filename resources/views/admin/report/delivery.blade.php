@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Delivery Report</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'reportDeliveryIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::select('month', $months, $monthSel, []) !!}
                            {!! Form::select('year', $years, $yearSel, []) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            <a href="{{ route('reportDeliveryPrint', ['month'=>$monthSel, 'year'=>$yearSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;" width="300px;">Delivery Date</th>
                                    <th style="background-color: #464646; color: #fff;">Supplier Name</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Delivery Cost</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($reports) > 0)
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><a href="{{ route('deliveryDetailsShow', $report->delivery_id) }}">{{ substr($report->deliverydate, 0, 10) }}</a></td>
                                            <!-- <td width="300">{{ substr($report->deliverydate, 0, 10) }}</td> -->
                                            <td>{{ $report->mySupplier->companyname }}</td>
                                            <td style="text-align: right;">
                                                {{ number_format($report->totalcost, 2) }}
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>

                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <table width="100%">
                                <tr class="uk-text-large">
                                    <td colspan="3" class="uk-text-right"><strong>Total Cost:</strong></td>
                                    <td width="145" style="text-align: right;"><strong>{{ number_format($reports->sum('totalcost'), 2) }}</strong></td>
                                    <td>&nbsp;</td>
                                </tr>
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
    <link rel="stylesheet" href="{{ asset('/css/components/datepicker.gradient.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/components/form-select.gradient.min.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('/js/components/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/components/form-select.min.js') }}"></script>

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