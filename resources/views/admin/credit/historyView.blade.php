@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Cheque Details</h2>

                        <table class="uk-table uk-table-hover uk-table-striped">
                            <thead>
                            <tr>
                                <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                <th style="background-color: #464646; color: #fff;">Cheque Number</th>
                                <th style="background-color: #464646; color: #fff;">Cheque Date</th>
                                <th style="background-color: #464646; color: #fff;">Due Date</th>
                                <th style="background-color: #464646; color: #fff; text-align: center;">Bank Branch</th>
                                <th style="background-color: #464646; color: #fff; text-align: center;">Amount Paid</th>
                                <th style="background-color: #464646; color: #fff; text-align: center;">Balance Due</th>
                                <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($salesPayment) > 0)
                                @foreach($salesPayment as $salesPay)
                                    <tr>
                                        @if($salesPay->paymentmode == 1 || $salesPay->paymentmode == 2 || $salesPay->paymentmode == 3 || $salesPay->paymentmode == 4 || $salesPay->paymentmode == 5 || $salesPay->paymentmode == 6 || $salesPay->paymentmode == 7)
                                        <td>&nbsp;</td>
                                        <td>{{ $salesPay->cheque_no }}</td>
                                        <td>{{ substr($salesPay->cheque_date, 0, 10) }}</td>
                                        <td>{{ substr($salesPay->due_date, 0, 10) }}</td>
                                        <td style="text-align: center;">
                                                    @if($salesPay->paymentmode == 1)
                                                        BDO
                                                    @elseif($salesPay->paymentmode == 2)
                                                        Metrobank
                                                    @elseif($salesPay->paymentmode == 3)
                                                        Landbank
                                                    @elseif($salesPay->paymentmode == 4)
                                                        BPI
                                                    @elseif($salesPay->paymentmode == 5)
                                                        PNB
                                                    @elseif($salesPay->paymentmode == 6)
                                                        RCBC
                                                    @elseif($salesPay->paymentmode == 7)
                                                        Others
                                                    @endif
                                        </td>
                                        <td style="text-align: center">{{ number_format($salesPay->amounttendered, 2) }}</td>
                                        <td style="text-align: center">{{ number_format($salesPay->balancedue, 2) }}</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    @endif
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

        </div>
    </div>

@stop

@section('location') Credit @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>
@stop