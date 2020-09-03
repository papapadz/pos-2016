@extends('report')

@section('content')
   <div class="uk-container uk-container-center" width="100%">
        <div class="uk-width-1-1" >
            <div style="text-align: center"><h2><strong><img src="/img/jc2.gif" alt="" width="50"> Joshua & Caleb Gen. Merchandise</strong></h2></div>
            <div style="text-align: center"> 2nd Floor Chua Bldg., M.V. Fariñas St., Laoag City</div>
            <div style="text-align: center"> Contact No. 09178153892 / Tel No. 676- 0025 </div>
            <div style="text-align: center"> &nbsp;</div>
            <div style="text-align: center"><h2><strong> Delivery Report</strong></h2></div>
            <div style="text-align: center"><strong> As of {{ substr(date_format(date_create($reportStart),'F d, Y'), 0, 20) }} to {{ substr(date_format(date_create($reportEnd),'F d, Y'), 0, 20) }}</strong></div>
        </div>
    </div>

     <table width="100%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: right;"> Date: {{ date_format(date_create($dateToFormat),'F d, Y') }}</td>
        </tr>
    </table>

    <table style="font-size: 15px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Delivery Date</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Supplier Name</th>
            <th style="background-color: #464646; color: #fff; text-align: right">Delivery Cost</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        @if(count($reports) > 0)
            @foreach($reports as $report)
                <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: left;">{{ substr($report->deliverydate, 0, 10) }}</td>
                    <td style="text-align: left;">{{ $report->mySupplier->companyname }}</td>
                    <td style="text-align: right;">{{ number_format($report->totalcost, 2) }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <table width="100%" style="font-size: 15px;" cellspacing="0">
        <tr>
            <td colspan="3" width="85%" style="text-align: right;"><strong>Total Delivery Cost:&nbsp;&nbsp;</strong></td>
            <td width="150" width="15%" style="text-align: right;"><strong>{{ number_format($reports->sum('totalcost'), 2) }}</strong></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%" style="font-size: 15px;" cellspacing="0">
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