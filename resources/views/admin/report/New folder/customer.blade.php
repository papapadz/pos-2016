@extends('admin')

@section('content')

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Sales by Customer</h2>

                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                    {!! Form::open(['route'=>'reportCustomerIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                    {!! Form::text('key', null, ['placeholder'=>'Search...', 'class'=>'uk-width-1-4']) !!}
                    {!! Form::close() !!}
                </div>

                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                    <tr>
                        <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                        <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                        <th style="background-color: #464646; color: #fff;">Customer Name</th>
                        <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                        <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($reports) > 0)
                        @foreach($reports as $report)
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>{{ strtoupper($report->lastname) }}, {{ strtoupper($report->firstname) }}</td>
                                <td class="uk-text-right">
                                    <a href="{{ route('reportCustomerSalesIndex', ['id'=>$report->cust_id]) }}" class="uk-button uk-button-success">View Invoices</a>
                                </td>
                                <td>&nbsp;</td>
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