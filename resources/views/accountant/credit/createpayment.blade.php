@extends('accountant')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid uk-grid-collapse">

                <div class="uk-width-1-1">

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary" style="background-color: #e5e4e4;">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                &nbsp;
                            </div>
                            <div class="uk-width-1-2 uk-text-right">
                                <a href="{{ route('accountantCreditPaymentHistory', ['id'=>$sales->sales_id]) }}" class="uk-button uk-button-success">Payment History</a>
                            </div>
                        </div>
                    </div>

                    @if (Session::has('code'))
                        @if(Session::get('code') == 1)
                            <div class="uk-alert uk-alert-success uk-animation-slide-top">Transaction Complete!</div>
                        @endif
                    @endif

                    @if(!is_null($sales))

                        <div class="uk-grid uk-grid-collapse">
                            <div class="uk-width-6-10">

                                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                                    <h3>Credit Sales Details</h3>

                                    <table class="uk-table uk-table-hover">
                                        <tr>
                                            <th style="background-color: #464646; color: #fff;">Product Name</th>
                                            <th style="background-color: #464646; color: #fff;">Quantity</th>
                                            <th style="background-color: #464646; color: #fff; text-align: right;">Sales Price</th>
                                            <th style="background-color: #464646; color: #fff; text-align: right;" width="150">Subtotal</th>
                                            <th style="background-color: #464646; color: #fff; text-align: right;" width="50">&nbsp;</th>
                                        </tr>

                                        {{--*/ $total = 0; /*--}}

                                        @if(count($salesDetails) > 0)
                                            @foreach($salesDetails as $salesDetail)
                                                <tr>
                                                    <td>{{ $salesDetail->myProduct->productname }}</td>
                                                    <td>{{ $salesDetail->qty }}</td>
                                                    <td style="text-align: right;">{{ number_format($salesDetail->myProduct->unitprice, 2) }}</td>
                                                    <td style="text-align: right;">{{ number_format($salesDetail->qty * $salesDetail->myProduct->unitprice, 2) }}</td>
                                                    <td>&nbsp;</td>
                                                </tr>

                                                {{--*/ $total += $salesDetail->qty * $salesDetail->myProduct->unitprice /*--}}

                                            @endforeach
                                        @endif
                                        <tr style="background-color: #F0F0F0;">
                                            <td colspan="4" style="text-align: right;"><strong>Total: &nbsp;&nbsp;&nbsp;{{ number_format($total, 2) }}</strong></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                            <div class="uk-width-4-10" style="padding-left: 5px;">

                                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                                    <h3>Credit Balance - <i>Inv.#{{ $sales->invoicenumber }}</i></h3>

                                    {!! Form::open(['route'=>['accountantCreditPaymentStore', 'sid'=>$sales->sales_id], 'class'=>'uk-form']) !!}
                                    {!! Form::hidden('amtToPay', $payment->balancedue, ['id'=>'amt-to-pay', 'readonly']) !!}
                                    <table width="100%">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><strong>&nbsp;&nbsp;&nbsp;Balance</strong></td>
                                            <td>{{ number_format($payment->balancedue, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>&nbsp;&nbsp;&nbsp;Payment</strong></td>
                                            <td>
                                                {!! Form::text('payment', null, ['id'=>'payment', 'class'=>'uk-width-2-4', 'autofocus']) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>&nbsp;&nbsp;&nbsp;Change <i class="uk-text-small">(Php)</i></strong></td>
                                            <td id="change" class="uk-text-bold" style="margin-left:200px;">{{ number_format(0, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>

                                    <hr>

                                    <div class="uk-text-center uk-width-1-2" style="margin-left:100px;">
                                        {!! Form::button('Process Payment', ['id'=>'btn-process', 'class'=>'uk-button uk-button-primary uk-button-large uk-width-1-1', 'type'=>'submit']) !!}
                                    </div>

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>

                    @endif

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