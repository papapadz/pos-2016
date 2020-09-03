@extends('accountant')

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
                                        <!-- <a href="{{ route('accountantSalesEdit') }}"><i class="uk-text-left uk-icon-pencil"></i></a> -->
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
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">Product Name</th>
                                    <th style="background-color: #464646; color: #fff;">Quantity</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;">Sales Price</th>
                                    <th style="background-color: #464646; color: #fff; text-align: right;" width="150">Subtotal</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
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
                                <tr>
                                    <td colspan="3" class="uk-text-right"><strong>VATable Sales</strong></td>
                                    <td style="text-align: right;" width="150"><i>{{ number_format($vatSales, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="uk-text-right"><strong>12% VAT</strong></td>
                                    <td style="text-align: right;"><i>{{ number_format($vat, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="uk-text-right"><strong>Total Amount</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                            <hr>

                            <div class="uk-grid">
                                <div class="uk-width-1-1 uk-text-center">
                                    <a href="{{ route('accountantSalesSummaryPrint', ['id'=>$sales->sales_id]) }}" target="_blank" class="uk-button uk-button-success">Print Invoice</a>
                                    <a href="{{ route('accountantSalesIndex') }}" class="uk-button uk-button-primary">Done</a>
                                </div>
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
            });
        });
    </script>
@stop