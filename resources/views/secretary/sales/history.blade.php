@extends('secretary')

@section('content')

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Payment History</h2>

                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                    <tr>
                        <th style="background-color: #464646; color: #fff;">Date</th>
                        <th style="background-color: #464646; color: #fff;">Amount Paid</th>
                        <th style="background-color: #464646; color: #fff;">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($salesPayment) > 0)
                        @foreach($salesPayment as $salesPay)
                            <tr>
                                <td>{{ substr($salesPay->paymentdate, 0, 10) }}</td>
                                <td>{{ number_format($salesPay->amountpaid, 2) }}</td>
                                <td>{{ number_format($salesPay->balancedue, 2) }}</td>

                            </tr>
                        @endforeach
                    @else

                        <tr>
                            <td colspan="7"><i>No products record found.</i></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@stop

@section('location') Products @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>
@stop