@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Customer Transactions List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['class'=>'uk-form']) !!}
                            {!! Form::text('skey', null, ['class'=>'uk-width-1-4', 'placeholder'=>'Search Transactions']) !!}
                            {!! Form::button('Filter', ['class'=>'uk-button uk-button-primary']) !!}
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr style="background-color: #464646; color: #fff;">
                                    <th>Invoice Number</th>
                                    <th>Sales Date</th>
                                    <th>Sales Type</th>
                                    <th>Sales Amount</th>
                                    <th>Amount Paid</th>
                                    <th>Balance Due</th>
                                    <th>Payment Mode</th>
                                    <th>&nbsp;</th>
                                    <th width="15;">Status</th>
                                </tr>
                                </thead>

                                {{--*/ $subtotal = 0; /*--}}

                                @if(count($transactions) > 0)
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                            <tr>

                                                <td><a href="{{ route('salesSummary', ['id'=>$transaction->sales_id]) }}">{{ $transaction->invoicenumber }}</a></td>

                                                <!-- <td><a href="{{ route('salesDetailsIndex', ['id'=>$transaction->sales_id]) }}">{{ $transaction->invoicenumber }}</a></td> -->
                                                <td>{{ substr($transaction->salesdate, 0, 10) }}</td>
                                                <td>{{ ($transaction->sales_type == 1) ? 'Cash' : 'Credit' }}</td>
                                                <td class="uk-text-primary">{{ number_format($transaction->totalsales - $transaction->fixedAmtDiscount, 2) }}</td>
                                                <td class="uk-text-success">{{ (!is_null($transaction->myPayments())) ? number_format($transaction->myPayments()->sum('amounttendered'), 2) : '' }}</td>
                                                <td>
                                                    {{ (count($transaction->myPayments) > 0) ? number_format($transaction->myPayment->where('sales_id', $transaction->sales_id)->latest('payment_id')->first()->balancedue, 2) : '' }}
                                                </td>
                                                <td>
                                                    @if($transaction->myPayment->paymentmode == 1)
                                                        BDO
                                                    @elseif($transaction->myPayment->paymentmode == 2)
                                                        Metrobank
                                                    @elseif($transaction->myPayment->paymentmode == 3)
                                                        Landbank
                                                    @elseif($transaction->myPayment->paymentmode == 4)
                                                        BPI
                                                    @elseif($transaction->myPayment->paymentmode == 5)
                                                        PNB
                                                    @elseif($transaction->myPayment->paymentmode == 6)
                                                        RCBC
                                                    @elseif($transaction->myPayment->paymentmode == 7)
                                                        Others

                                                    @endif
                                                </td>
                                                <td>&nbsp;</td>
                                                <td width="15;">
                                                    @if($transaction->status == 0)
                                                        <span class="uk-text-danger">Unpaid</span>
                                                    @elseif($transaction->status == 1)
                                                        <span class="uk-text-success">Paid</span>
                                                    @elseif($transaction->status == 2)
                                                        <span class="uk-text-primary">Balance Due</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="9"><i>{{ count($transactions) }} - Customer transaction record/s found</i></td>
                                    </tfoot>
                                @else
                                    <tfoot>
                                        <tr>
                                            <td colspan="9"><i>No customer transaction record/s found.</i></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>

                            <div>
                                @include('paginator', ['paginator' => $transactions])
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