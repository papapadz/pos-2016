@extends('report')

@section('content')
    <div class="uk-container uk-container-center" width="100%">
        <div class="uk-width-1-1" >
            <div style="text-align: center"><h2><strong><img src="/img/jc2.gif" alt="" width="50"> Joshua & Caleb Gen. Merchandise</strong></h2></div>
            <div style="text-align: center"> 2nd Floor Chua Bldg., M.V. Fariñas St., Laoag City</div>
            <div style="text-align: center"> Contact No. 09178153892 / Tel No. 676- 0025 </div>
            <div style="text-align: center"> &nbsp;</div>
            <div style="text-align: center">
                @if($option == 0)
                    <h2 style="text-align: center"><strong>Monthly Sales Summary</strong></h2>
                @elseif($option == 1)
                    <h2 style="text-align: center"><strong>Monthly Sales Summary (Government Customers)</strong></h2>
                @else
                    <h2 style="text-align: center"><strong>Monthly Sales Summary (Non-Government Customers)</strong></h2>
                 @endif
            </div>
            <div style="text-align: center;"><strong> As of {{ date_format(date_create($reportStart),'F d, Y'), 0, 20 }} to {{ date_format(date_create($reportEnd),'F d, Y'), 0, 20 }}</strong></div>
        </div>       
    </div>

    <table width="100%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: right;"> &nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>

    <table style="font-size: 13px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff; text-align: left;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Date</th>
            <th style="background-color: #464646; color: #fff; text-align: center; width: 200px;">Invoice Number</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Customer</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">VATable Sales</th>
            <th style="background-color: #464646; color: #fff; text-align: left; width: 30px;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">VAT</th>
            @if($option < 2)
                <th style="background-color: #464646; color: #fff; text-align: right; width: 90px;">1%(CIT)</th>
                <th style="background-color: #464646; color: #fff; text-align: right; width: 90px;">5%(CVAT)</th> 
            @endif
            <th style="background-color: #464646; color: #fff; text-align: right;">Sales Amount</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>

         {{--*/ $vatable = 0; /*--}}
         {{--*/ $vat = 0; /*--}}
         {{--*/ $salesAmount = 0; /*--}}
         {{--*/ $one = 0; /*--}}
         {{--*/ $five = 0; /*--}}                       

        @if(count($reports) > 0)
            @foreach($reports as $report)
                <tr>
                    <td style="text-align: left;">&nbsp;</td>
                    <td style="text-align: left;">&nbsp;</td>
                    <td style="text-align: left;">{{ substr($report->salesdate, 0, 10) }}</td>
                    <td style="text-align: center;">{{ $report->invoicenumber }}</td>
                    <td style="text-align: left;">{{ $report->lastname }}, {{ $report->firstname }}</td>
                    <td style="text-align: right;">{{ number_format($report->totalsales / 1.12, 2) }}</td>
                    <td style="text-align: left;">&nbsp;</td>
                    <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .12, 2) }}</td>
                    @if($option == 0)
                        @if($report->cust_type == 1)
                            <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .01, 2) }}</td>
                            <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .05, 2) }}</td>
                        @else
                            <td style="text-align: right;">N/A</td>
                            <td style="text-align: right;">N/A</td>
                        @endif
                    @elseif($option == 1)
                        <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .01, 2) }}</td>
                        <td style="text-align: right;">{{ number_format(($report->totalsales / 1.12) * .05, 2) }}</td>
                    @endif
                        <td style="text-align: right;">{{ number_format($report->totalsales, 2) }}</td>
                        <td style="text-align: left;">&nbsp;</td>
                        <td style="text-align: left;">&nbsp;</td>
                </tr>

                {{--*/ $vatable += $report->totalsales / 1.12; /*--}}
                {{--*/ $vat += ($report->totalsales / 1.12) * .12; /*--}}
                {{--*/ $salesAmount += $report->totalsales; /*--}}
                {{--*/ $one += ($report->totalsales / 1.12) * .01; /*--}}
                {{--*/ $five += ($report->totalsales / 1.12) * .05; /*--}}

            @endforeach
        @endif
        </tbody>
    </table>
    
    <table width="100%" style="font-size: 15px;" cellspacing="0">
    @if($option == 0)
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total Vatable Sales:</strong></td>
            <td width="100" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;{{ number_format($vatable, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total VAT:</strong></td>
            <td width="100" style="text-align: right;"><strong>{{ number_format($vat, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total CIT:</strong></td>
            <td width="100" style="text-align: right;"><strong>{{ number_format($one, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total CVAT:</strong></td>
            <td width="100" style="text-align: right;"><strong>{{ number_format($five, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total Sales Amount:</strong></td>
            <td width="100" style="text-align: right;"><strong>{{ number_format($salesAmount, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
    @else
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total Vatable Sales:</strong></td>
            <td width="100" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;{{ number_format($vatable, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total VAT:</strong></td>
            <td width="100" style="text-align: right;"><strong>{{ number_format($vat, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="uk-text-large uk-text-right">
            <td colspan="3" style="text-align: right;"><strong>Total Sales Amount:</strong></td>
            <td width="100" style="text-align: right;"><strong>{{ number_format($salesAmount, 2) }}</strong></td>
            <td>&nbsp;</td>
        </tr>
    @endif
    </table>
    <table width="80%" style="font-size: 16px;" cellspacing="0">
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

<script type="text/javascript">
    window.print();
    window.close();
</script>