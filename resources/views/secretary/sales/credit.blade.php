@extends('secretary')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid uk-grid-collapse">

                <div class="uk-width-1-1">

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                {!! Form::open(['route'=>'secretarySalesCreditPayment', 'method'=>'post', 'class'=>'uk-form']) !!}
                                @if (Session::has('invoiceCode'))
                                    @if(Session::get('invoiceCode') == 0)
                                        {!! Form::text('invoicenumber', $invoiceNumber, ['placeholder'=>'Invoice Number', 'class'=>'uk-width-1-1 uk-form-danger']) !!}
                                    @endif
                                @else
                                    {!! Form::text('invoicenumber', $invoiceNumber, ['placeholder'=>'Invoice Number', 'class'=>'uk-width-1-1']) !!}
                                @endif
                                {!! Form::close() !!}
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-text-success uk-text-bold uk-text-right">
                                    <a href="#customer-modal" data-uk-modal class="uk-button"><span id="customer-name">{{ ($customer->lastname) }}, {{ ($customer->firstname) }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                        {!! Form::open(['route'=>['secretarySalesCreditPaymentCreate', 'sid'=>$sales->sales_id], 'class'=>'uk-form']) !!}
                        <div>
                            <strong>OR NUMBER:</strong> <span>{{ $sales->invoicenumber }}</span>
                            <a href="{{ route('secretarySalesPaymentHistory', ['id'=>$sales->sales_id]) }}" class="uk-text-small">Payment History</a>
                        </div>

                        @if (Session::has('code'))
                            @if(Session::get('code') == 1)
                                <div class="uk-alert uk-alert-success uk-animation-slide-top">Transaction Complete!</div>
                            @endif
                        @endif

                        @if(!is_null($sales))
                            <table class="uk-table">
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">Product</th>
                                    <th style="background-color: #464646; color: #fff;">Qty</th>
                                    <th style="background-color: #464646; color: #fff;" width="150">Price</th>
                                </tr>
                                @if(count($salesDetails) > 0)
                                    @foreach($salesDetails as $salesDetail)
                                        <tr>
                                            <td><strong>{{ $salesDetail->myProduct->productname }}</strong></td>
                                            <td>{{ $salesDetail->qty }}</td>
                                            <td>{{ number_format($salesDetail->sales_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr style="background-color: #F0F0F0;">
                                    <td colspan="2" class="uk-text-right">VATable Sales</td>
                                    <td>{{ number_format($vatSales, 2) }}</td>
                                </tr>
                                <tr style="background-color: #F0F0F0;">
                                    <td colspan="2" class="uk-text-right">VAT</td>
                                    <td>{{ number_format($vat, 2) }}</td>
                                </tr>
                                <tr style="background-color: #F0F0F0;">
                                    <td colspan="2" class="uk-text-right">Total</td>
                                    <td>{{ number_format($grandTotal, 2) }}</td>
                                </tr>
                            </table>

                            @if($grandTotal > 0)
                                <div class="uk-grid">
                                    <div class="uk-width-3-4"></div>
                                    <div class="uk-width-1-4">
                                        <table>
                                            @if($sales->status == 0 || $sales->status == 2)
                                                <tr>
                                                    <td><strong>Balance</strong></td>
                                                    <td>
                                                        {{ number_format($payment->balancedue, 2) }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td><strong>Payment</strong></td>
                                                <td>
                                                    {!! Form::hidden('amtToPay', $grandTotal, ['id'=>'amt-to-pay', 'readonly']) !!}
                                                    {!! Form::text('payment', null, ['id'=>'payment', 'class'=>'uk-width-1-1']) !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Change</strong></td>
                                                <td id="change">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <br>
                                                    {!! Form::button('Process Payment', ['id'=>'btn-process', 'class'=>'uk-button uk-button-primary uk-width-1-1', 'disabled', 'type'=>'submit']) !!}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif

                        {!! Form::close() !!}

                        @if (Session::has('code'))
                            @if(Session::get('code') == 1)
                                <div class="uk-alert uk-alert-success uk-animation-slide-top">Transaction Complete!</div>
                            @endif
                        @endif

                    </div>

                    <div class="uk-margin-top uk-text-right">

                    </div>

                </div>

            </div>

        </div>
    </div>

@stop

@section('location') Sales @stop

@section('js')
    <script type="text/javascript">
        $(function(){
            var amtToPay = parseFloat($('#amt-to-pay').val());
            var tendered = parseFloat($('#payment').val());
            var change = (tendered - amtToPay);

            if(change >= 0)
            {
                $('#sales-change').html(change);
            }
            else
            {
                $('#sales-change').html(0);
            }

            $('#payment').keyup(function(){
                var amtToPay = parseFloat($('#amt-to-pay').val());
                var tendered = parseFloat($('#payment').val());
                var change = (tendered) - (amtToPay);

                if(tendered <= 0)
                {
                    alert('Wrong amount value!');
                    $(this).val('');
                    return false;
                }

                if(tendered == 0 || tendered == '')
                {
                    $('#btn-process').prop('disabled', true);
                }
                else
                {
                    $('#btn-process').prop('disabled', false);
                }

                if(change >= 0)
                {
                    $('#change').html(change);
                }
                else
                {
                    $('#change').html(0);
                }
            });
        })
    </script>
@stop