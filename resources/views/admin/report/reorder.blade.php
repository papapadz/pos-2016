@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Product Reorder Report</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'reportReorderIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            <a href="{{ route('reportReorderPrint') }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr style="background-color: #464646; color: #fff;">
                                    <th>&nbsp;</th>
                                    <th style="text-align: left;">Size</th>
                                    <th style="text-align: left;">Pattern</th>
                                    <th style="text-align: left;">Product Description</th>
                                    <th style="text-align: left;">Category</th>
                                    <th style="text-align: center;">Re-order Limit</th>
                                    <th style="text-align: center;">Stocks Left</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                        @if($report->stock <= $report->reorderlimit)
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>{{ $report->productname }}</td>
                                                <td>{{ $report->pattern }}</td>
                                                <td>{{ $report->productcode }}</td>
                                                <td>{{ $report->myCategory->categoryname }}</td>
                                                <td style="text-align: center;">{{ $report->reorderlimit }}</td>
                                                <td style="text-align: center;">{{ $report->stock }}</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                         @endif
                                    @endforeach 
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