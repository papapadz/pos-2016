@extends('accountant')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Credit List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                            <div class="uk-autocomplete uk-form" data-uk-autocomplete="{source:[{'qwerty'}]}">
                                {!! Form::text('skey', $skey, ['class'=>'uk-width-3-10', 'placeholder'=>'Search...']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr style="background-color: #464646; color: #fff;">
                                    <th>&nbsp;</th>
                                    <th>Invoice Number</th>
                                    <th>Sales Date</th>
                                    <th>Customer Name</th>
                                    <th style="text-align: right">Balance Due</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                @if(count($credits) > 0)
                                    <tbody>
                                    @foreach($credits as $credit)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><a href="{{ route('accountantSalesDetailsIndex', ['id'=>$credit->sales_id]) }}">{{ $credit->invoicenumber }}</a></td>
                                            <td>{{ substr($credit->salesdate, 0, 10) }}</td>
                                            <td>{{ $credit->firstname }} {{ $credit->lastname }}</td>
                                            <td class="uk-text-right">
                                                {{ (!is_null($credit->myPayment) ? number_format($credit->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) : '----') }}
                                            </td>
                                            <td class="uk-text-right">
                                                <a href="{{ route('accountantCreditCreatePayment', ['id'=>$credit->sales_id]) }}" class="uk-button uk-button-success">Enter Payment</a>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
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