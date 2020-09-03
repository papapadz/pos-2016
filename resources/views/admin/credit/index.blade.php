@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Credit List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'creditIndex', 'method'=>'get', 'class'=>'uk-form']) !!} 
                            {!! Form::select('customer', $customerType, $custSel) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr style="background-color: #464646; color: #fff;">
                                    <th>&nbsp;</th>
                                    <th>Sales Date</th>
                                    <th>Customer Name</th>
                                    <th style="text-align: right">Sales Amount</th>
                                    <th style="text-align: right">Weekly Payment</th>
                                    <th style="text-align: right">Balance Due</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>

                                {{--*/ $total = 0; /*--}}

                                @if(count($credits) > 0)
                                    <tbody>
                                    @foreach($credits as $credit)
                                        <tr>
                                        @if(($credit->cust_id != 1) && ($credit->sales_type == 2))
                                                <td>&nbsp;</td>
                                                <td><a href="{{ route('salesSummary', ['id'=>$credit->sales_id]) }}">{{ substr($credit->salesdate, 0, 10) }}</a></td>    
                                                <td><a href="{{ route('transactionsIndex', ['id'=>$credit->cust_id]) }}">{{ $credit->companyname  }} -- {{ $credit->lastname }}</a></td>
                                                <td class="uk-text-right">{{ number_format($credit->totalsales, 2) }}</td>
                                                <td class="uk-text-right">
                                                @if($credit->terms == 1)
                                                    {{ number_format(($credit->totalsales / 4), 2) }}
                                                @elseif($credit->terms == 2)
                                                    {{ number_format(($credit->totalsales / 8), 2) }}
                                                @elseif($credit->terms == 3)
                                                    {{ number_format(($credit->totalsales / 12), 2) }}
                                                @elseif($credit->terms == 4)
                                                    {{ number_format(($credit->totalsales / 16), 2) }}
                                                @elseif($credit->terms == 5)
                                                    {{ number_format(($credit->totalsales / 20), 2) }}
                                                @endif
                                                </td>
                                                <td class="uk-text-right">
                                                    {{ (!is_null($credit->myPayment) ? number_format($credit->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) : '----') }}</td>
                                                <td class="uk-text-right">
                                                    <a href="{{ route('creditCreatePayment', ['id'=>$credit->sales_id]) }}" class="uk-button uk-button-success">Enter Payment</a>
                                                </td>
                                                <td class="uk-text-right">
                                                    <a href="{{ route('creditPaymentHistory', ['id'=>$credit->sales_id]) }}" class="uk-button uk-button-success">Payment History</a>
                                                </td>
                                        @endif   
                                        </tr>

                                        {{--*/ $total += $credit->myPayment->balancedue; /*--}}

                                    @endforeach
                                    </tbody>

                            


                                    <tfoot>
                                        <tr>
                                            <td colspan="8"><i>{{ count($credits) }} - Customer record/s found</i></td>
                                        </tr>
                                    </tfoot>
                                @else
                                    <tfoot>
                                        <tr>
                                            <td colspan="8"><i>No credit record/s found.</i></td>
                                        </tr>
                                    </tfoot>
                                @endif

                            </table>

                            <div>
                                @include('paginator', ['paginator' => $credits])
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
    <script src="/js/components/autocomplete.js"></script>
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
                }
            });
        });
    </script>
@stop