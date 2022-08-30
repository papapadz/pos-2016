@extends('admin')

@section('content')
<div style="margin-top:15px;">
    <div uk-grid>
        <div class="uk-width-1-2"><h3>ID #{{ $sales->invoicenumber }}</h3></div>
        <div class="uk-width-1-2 uk-text-right">
            <h3>Date: {{ substr($sales->salesdate, 0, 10) }}</h3>
        </div>
    </div>

    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
        <table class="uk-table uk-table-hover uk-table-striped">
            <thead>
            <tr>
                <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                <th style="background-color: #464646; color: #fff;">Category</th>
                <th style="background-color: #464646; color: #fff;">Item</th>
                <th style="background-color: #464646; color: #fff; text-align: center;">Qty</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Unit Price</th>
                <th style="background-color: #464646; color: #fff; text-align: right;" width="150">Total</th>
                <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @if(count($salesDetails) > 0)
                @foreach($salesDetails as $salesDetail)
                    <tr>
                        <td>&nbsp;</td>
                        <td>{{ $salesDetail->myProduct->myCategory->categoryname }}</td>
                        <td>{{ $salesDetail->myProduct->productname }}</td>
                        <td style="text-align: center;">{{ $salesDetail->qty }}</td>
                        <td style="text-align: right;">{{ number_format($salesDetail->sales_price / $salesDetail->qty, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($salesDetail->sales_price, 2) }}</td>
                        <td>&nbsp;</td>
                    </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="8"><i>No customer transaction record/s found.</i></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
        <table width="100%">
            {{-- <tr>
                <td colspan="3" class="uk-text-right">VATable Sales</td>
                <td style="text-align: right;" width="150"><i>{{ number_format($vatSales, 2) }}</i></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" class="uk-text-right">12% VAT</td>
                <td style="text-align: right;"><i>{{ number_format($vat, 2) }}</i></td>
                <td>&nbsp;</td>
            </tr> --}}
             <tr>
                <td colspan="3" class="uk-text-right"><strong>Gross Amount</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
                <td>&nbsp;</td>
            </tr>
            
            {{--*/ $total = $grandTotal - ($grandTotal * ($sales->discount/100)) - $sales->fixedAmtDiscount; /*--}}
            
            
            <tr>
                <td colspan="3" class="uk-text-right">Discount</td>
                <td style="text-align: right;"><i>{{ number_format($grandTotal - $total, 2) }}</i></td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td colspan="3" class="uk-text-right"><strong>Net Amount</strong></td>
                <td style="text-align: right;"><strong><u>{{ number_format($total, 2) }}</u></strong></td>
                <td>&nbsp;</td>
            </tr>
        </table>

        <hr>

        <div class="uk-grid">
            <div class="uk-width-1-1 uk-text-center">
                {{-- <a href="{{ route('salesSummaryPrint', ['id'=>$sales->sales_id]) }}" target="_blank" class="uk-button uk-button-success">Print Invoice</a> --}}
                <a href="{{ route('reportIndex') }}" class="uk-button uk-button-primary">Back</a>
            </div>
        </div>
    </div>

</div>
@stop

@section('location') Customer @stop

@section('js')
    <script type="text/javascript">
        $(function(){
            $('.del-rec').click(function(){
                var r = confirm('Are you sure you want to delete this record?');

                if(!r){
                    return false;
                }
            });
        });
    </script>
@stop