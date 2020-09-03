@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>{{ ($sales->sales_type == 1 ? 'Customer Sales Invoice' : 'Customer Charge Invoice') }}</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
                            <table width="100%">
                                <tr>
                                    <td><strong>Customer Name</strong></td>
                                    <td>{{ $customer->firstname }} {{ $customer->lastname }}</td>
                                        <a href="{{ route('salesEdit') }}"><i class="uk-text-left uk-icon-pencil"></i></a>
                                    <td><strong>Sales Date</strong></td>
                                    <td>{{ substr($sales->salesdate, 0, 10) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>{{ $customer->address }}</td>
                                    <td><strong>Invoice Number</strong></td>
                                    <td>{{ $sales->invoicenumber }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Contact Number</strong></td>
                                    <td>{{ $customer->contactno }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr style="background-color: #464646; color: #fff;">
                                    <th>&nbsp;</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th style="text-align: right;">Sales Price</th>
                                    <th style="text-align: right;" width="150">Subtotal</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($salesDetails) > 0)
                                    @foreach($salesDetails as $salesDetail)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $salesDetail->myProduct->productname }}</td>
                                            <td>{{ $salesDetail->qty }}</td>
                                            <td style="text-align: right;">{{ number_format($salesDetail->sales_price / $salesDetail->qty, 2) }}</td>
                                            <td style="text-align: right;">{{ number_format(($salesDetail->sales_price), 2) }}</td>
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

                    </div>

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                        <table width="100%">
                                <tr>
                                    <td colspan="3" class="uk-text-right">VATable Sales</td>
                                    <td style="text-align: right;" width="150"><i>{{ number_format($vatSales, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="uk-text-right">12% VAT</td>
                                    <td style="text-align: right;"><i>{{ number_format($vat, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr>
                                 <tr>
                                    <td colspan="3" class="uk-text-right"><strong>Total Amount</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
                                    <td>&nbsp;</td>
                                </tr>
                                
                                {{--*/ $total = $grandTotal - ($grandTotal * ($sales->discount/100)) - $sales->fixedAmtDiscount; /*--}}
                                
                                <tr>
                                    <td colspan="3" class="uk-text-right"><strong>Discounted Amount</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format($total, 2) }}</strong></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="uk-text-right">Discount</td>
                                    <td style="text-align: right;"><i>{{ number_format($grandTotal - $total, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>


                        <hr>

                        <div class="uk-grid">
                            <div class="uk-width-1-1 uk-text-center">
                                <a href="{{ route('salesDetailsPrint', ['id'=>$sales->sales_id]) }}" target="_blank" class="uk-button uk-button-success">Print Invoice</a>
                                <a href="{{ route('transactionsIndex', ['id'=>$customer->cust_id]) }}" class="uk-button uk-button-primary">Done</a>
                            </div>
                        </div>

                    </div>

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
                else
                {
                    var r = confirm('Other related records will also be deleted, proceed?');

                    if(!r){
                        return false;
                    }
                    else
                    {
                        var r = confirm('System will now delete this record together with other related data.');

                        if(!r){
                            return false;
                        }
                    }
                }
            });
        });
    </script>
@stop