@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Delivery Details</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            <a href="{{ route('deliveryIndex') }}" class="uk-button uk-button-primary">Done</a>
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                    <tr style="background-color: #464646; color: #fff;">
                                        <th>&nbsp;</th>
                                        <th>Category</th>
                                        <th>Size</th>
                                        <th>Pattern</th>
                                        <th>Quantity</th>
                                        <th style="text-align: right">Unit Cost</th>
                                        <th style="text-align: right">Total Cost</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>

                                @if(count($deliveryDetails) > 0)
                                    <tbody>
                                        @foreach($deliveryDetails as $deliveryDetail)
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>{{ $deliveryDetail->myProduct->myCategory->categoryname }}</td>
                                                <td>{{ $deliveryDetail->myProduct->productname }}</td>
                                                <td>{{ $deliveryDetail->myProduct->pattern }}</td>
                                                <td>{{ $deliveryDetail->qty }}</td>
                                                <td style="text-align: right">{{ number_format($deliveryDetail->unitcost, 2) }}</td>
                                                <td style="text-align: right">{{ number_format($deliveryDetail->qty * $deliveryDetail->unitcost, 2) }}</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        @endforeach
                                    
                                            <tr>
                                                
                                                <td colspan="7" style="text-align: right"><strong> Total Amount: &nbsp;&nbsp;&nbsp;{{ number_format($delivery->totalcost, 2) }}</strong></td>
                                            </tr>
                                    
                                        @else
                                    
                                            <tr>
                                                <td colspan="4"><i>No products record found.</i></td>
                                            </tr>
                                   </tbody>
                                @endif

                            </table>

                            <div>
                                @include('paginator', ['paginator' => $deliveryDetails])
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('location') Delivery Details @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>

    <script type="text/javascript">
        $(function(){
            $('.del-rec').click(function(){
                var r = confirm('Are you sure you want to delete this record?');

                if(!r){
                    return false;
                }
            });

            $('.reorder-product').click(function(){
                var product = this.id;
                $('#reorder-product').val(product);
            });
        });
    </script>
@stop