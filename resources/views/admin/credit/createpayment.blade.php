@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid uk-grid-collapse">

                <div class="uk-width-1-1">

                <div style="margin-top:15px;">

                    <h2>Credit Balance - <i>Inv.#{{ $sales->invoicenumber }}</i></h2>

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary" style="background-color: #e5e4e4;">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    @if (Session::has('code'))
                        @if(Session::get('code') == 1)
                            <div class="uk-alert uk-alert-success uk-animation-slide-top">Transaction Complete!</div>
                        @endif
                    @endif

                    @if(!is_null($sales))

                <div class="uk-width-6-10" style="padding-left: 5px;">

                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                                    {!! Form::open(['route'=>['creditPaymentStore', 'sid'=>$sales->sales_id], 'class'=>'uk-form']) !!}
                                    {!! Form::hidden('amtToPay', $payment->balancedue, ['id'=>'amt-to-pay', 'readonly']) !!}
                                    <table width="100%">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                    @if($sales->fixedAmtDiscount > 0)
                                        <tr>
                                            <td><strong>&nbsp;&nbsp;&nbsp;Balance</strong></td>
                                            <td>{{ number_format($payment->balancedue, 2) }}</td>
                                        </tr>
                                    @else
                                        <tr> 
                                            <td><strong>&nbsp;&nbsp;&nbsp;Balance</strong></td>
                                            <td>{{ number_format($payment->balancedue, 2) }}</td>
                                        </tr>
                                    @endif
                                        <tr>
                                            <td><strong>&nbsp;&nbsp;&nbsp;Payment Mode</strong></td>
                                            <td>CASH</td>
                                        </tr>
                                        <tr>
                                            <td><strong>&nbsp;&nbsp;&nbsp;Payment</strong></td>
                                            <td>
                                                {!! Form::text('payment', null, ['id'=>'payment', 'class'=>'uk-width-2-4', 'autofocus']) !!}
                                                <a href="#payment-modal" id="{{ $payment->payment_id }}" data-uk-modal class="uk-button uk-button-primary cheque-payment">Cheque</a>
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
                                        {!! Form::button('Process Payment', ['id'=>'btn-process', 'class'=>'uk-button uk-button-primary uk-button-medium uk-width-1-1', 'type'=>'submit']) !!}
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



    <!-- This is the modal -->
    <div id="payment-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <h2>Cheque Details</h2>
            <hr>

            {!! Form::open(['route'=>['paymentChequeStore', 'sid'=>$sales->sales_id], 'class'=>'uk-form']) !!}

            {!! Form::hidden('payment_id', null, ['id'=>'cheque-payment']) !!}
            {!! Form::hidden('amtToPay', $payment->balancedue, ['id'=>'amt-to-pay', 'readonly']) !!}

            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Cheque Number</label>
                <div class="uk-form-controls">
                    {!! Form::text('cheque_no', null) !!}
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Amount</label>
                <div class="uk-form-controls">
                    {!! Form::text('payment', null) !!}
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Cheque Date</label>
                <div class="uk-form-controls">
                    {!! Form::text('cheque_date', date('Y-m-d'), ["data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Due Date</label>
                <div class="uk-form-controls">
                    {!! Form::text('due_date', date('Y-m-d'), ["data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Bank Branch</label>
                <div class="uk-form-controls">
                    {!! Form::select('paymentmode', $mode, null) !!}
                </div>
            </div>

            <hr>

            <div class="uk-text-right">
                {!! Form::button('Confirm Cheque Details', ['type'=>'submit', 'class'=>'uk-button uk-button-primary', 'id'=>'payment-confirm']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop

@section('location') Sales @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>

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

