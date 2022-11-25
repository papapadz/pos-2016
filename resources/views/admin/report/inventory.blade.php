@extends('admin')

@section('content')
<div uk-grid>
    <div class="uk-width-1-2"><h2>Inventory Report</h2></div>
    <div class="uk-width-1-2 uk-text-right">
        {!! Form::open(['route'=>'reportInventory', 'method'=>'get', 'class'=>'uk-form']) !!}
        {!! Form::select('category', $categories, $catSel) !!}
        {!! Form::button('Search ', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary uk-button-small', 'uk-icon' => 'icon: search']) !!}
        {{-- <a href="{{ route('reportInventoryPrint', ['category'=>is_null($catSel) || $catSel == '' ? 0 : $catSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a> --}}
        {!! Form::close() !!}
    </div>
</div>

    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
        <table class="uk-table uk-table-hover uk-table-striped">
            <thead>
            <tr>
                <th style="background-color: #464646; color: #fff;">Category</th>
                <th style="background-color: #464646; color: #fff;">Item</th>
                <th style="background-color: #464646; color: #fff;">Code</th>
                <th style="background-color: #464646; color: #fff; text-align: center;">Stock on Hand</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Unit Cost</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Unit Price</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Total Cost</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Total Price</th>
            </tr>
            </thead>
            <tbody>

            @if(count($reports) > 0)
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->myCategory->categoryname }}</td>
                        <td>{{ $report->productname }}</td>
                        <td>{{ $report->productcode }}</td>
                        <td style="text-align: center;">{{ $report->stock }}</td>
                        <td style="text-align: right;">{{ number_format($report->unitcost, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($report->unitprice, 2) }}</td>
                        <td style="text-align: right;"><b>{{ number_format((($report->stock * $report->unitcost) < 0) ? 0 : ($report->stock * $report->unitcost), 2) }}</b></td>
                        <td style="text-align: right;"><b>{{ number_format((($report->stock * $report->unitprice) < 0) ? 0 : ($report->stock * $report->unitprice), 2) }}</b></td>
                    </tr>

                @endforeach
            @endif
            </tbody>
        </table>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
            <table width="100%">
                <tr class="uk-text-large">
                    <td colspan="3" class="uk-text-right"><strong>Total Inventory Count:</strong></td>
                    <td width="150" style="text-align: right;"><strong>{{ number_format($totalInventoryCount) }}</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="uk-text-large">
                    <td colspan="3" class="uk-text-right"><strong>Total Inventory Cost:</strong></td>
                    <td width="150" style="text-align: right;"><strong>{{ number_format($totalInventoryValueCost, 2) }}</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="uk-text-large">
                    <td colspan="3" class="uk-text-right"><strong>Total Inventory Price:</strong></td>
                    <td width="150" style="text-align: right;"><strong>{{ number_format($totalInventoryValuePrice, 2) }}</strong></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
@stop

@section('location') Reports @stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/components/datepicker.gradient.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/components/form-select.gradient.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/datatable/button/css/buttons.dataTables.min.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('/js/components/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/components/form-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/datatable/button/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/datatable/button/js/buttons.print.min.js') }}"></script>
    <script>
        var ukTable = $('table.uk-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
        })
        
    </script>

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