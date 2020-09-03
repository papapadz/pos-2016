@extends('report')

@section('content')
    <div class="uk-container uk-container-center">
        <div class="uk-width-1-1" >
            <div style="text-align: center;"><h2><strong><img src="/img/jc2.gif" alt="" width="50"> Joshua & Caleb Gen. Merchandise</strong></h2></div>
            <div style="text-align: center;"> 2nd Floor Chua Bldg., M.V. Fariñas St., Laoag City</div>
            <div style="text-align: center;"> Contact No. 09178153892 / Tel No. 676- 0025 </div>
            <div style="text-align: center"> &nbsp;</div>
           <div>
                @if($option == 1)
                    <h2 style="text-align: center"><strong>Report of Payment(All Paid)</strong></h2>
                @else
                    <h2 style="text-align: center"><strong>Report of Payment(All Unpaid)</strong></h2>
                @endif
            </div>
            <div style="text-align: center;"><strong> As of {{ date_format(date_create($dateToFormat),'F d, Y') }}</strong></div>
        </div>
    </div>

      <table width="100%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: right;"> </td>
        </tr>
    </table>

    <table style="font-size: 14px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0" width="100%">
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
        <table width="100%" style="font-size: 16px;" cellspacing="0">
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