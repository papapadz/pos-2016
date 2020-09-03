@extends('report')

@section('content')
    <div class="uk-container uk-container-left">
        <div class="uk-width-1-1" >
            <div style="text-align: left; margin-bottom: -15px; margin-left: 185px;"><h2><strong>C.A. Chabby Enterprises</strong></h2></div>
            <div style="text-align: left; margin-left: 165px"> Main Office: Brgy. 7-B 56 P. Gomez St., Laoag City</div>
            <div style="text-align: left; margin-left: 90px"> Contact Nos: +63 939-923-1048 / +63 917-628-3784 / +63 925-576-2377</div>
            <div style="text-align: left; margin-left: 215px"> Proprietor - Engr. Robert R. Alog</div>
            <div style="text-align: left; margin-left: 185px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div>
                @if($option == 1)
                    <h2 style="text-align: left; margin-left: 155px"><strong> &nbsp;&nbsp;Report of Payment(All Paid)</strong></h2>
                @else
                    <h2 style="text-align: left; margin-left: 135px"><strong> &nbsp;&nbsp;Report of Payment(All Unpaid)</strong></h2>
                @endif
            </div>
            <div style="text-align: left; margin-left: 230px"><strong> As of {{ date_format(date_create($dateToFormat),'F d, Y') }}</strong></div>
        </div>
    </div>

      <table width="70%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: right;"> </td>
        </tr>
    </table>

    <table style="font-size: 14px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0" width="70%">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Date</th>
            <th style="background-color: #464646; color: #fff; text-align: center;">Invoice Number</th>
            <th style="background-color: #464646; color: #fff; width: 50px;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left; ">Customer</th>
            @if($option == 1)
                <th style="background-color: #464646; color: #fff; text-align: right;">Sales Amount</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Payment</th>
                <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            @else
                <th style="background-color: #464646; color: #fff; text-align: right;">Sales Amount</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Payment</th>
                <th style="background-color: #464646; color: #fff; text-align: right;">Balance Due</th>
                <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @if(count($reports) > 0)
            @foreach($reports as $report)
                <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: left;">{{ substr($report->salesdate, 0, 10) }}</td>
                    <td style="text-align: center;">{{ $report->invoicenumber }}</td>
                    <td>&nbsp;</td>
                    <td style="text-align: left;">{{ $report->myCustomer->lastname }}, {{ $report->myCustomer->firstname }}</td>
                    @if($option == 1)
                        <td style="text-align: right;">{{ number_format($report->myPayment()->first()->amountpaid, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                        <td>&nbsp;</td>
                    @else
                        <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($report->totalsales - $report->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($report->myPayments()->orderby('payment_id', 'desc')->first()->balancedue, 2) }}</td>
                        <td>&nbsp;</td>
                    @endif
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
     </table>
        <table width="70%" style="font-size: 16px;" cellspacing="0">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align: left;">Printed by:&nbsp;&nbsp;<strong>{{ Auth::user()->employeename }}</strong></td>
            </tr>
        </table>
@endsection


<script type="text/javascript">
    window.print();
    window.close();
</script>