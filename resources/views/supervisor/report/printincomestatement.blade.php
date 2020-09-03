@extends('report')

@section('content')

    <div class="uk-container uk-container-center">
        <div class="uk-width-1-1" >
             <div style="text-align: center"><h2><strong><img src="/img/jc2.gif" alt="" width="50"> Joshua & Caleb Gen. Merchandise</strong></h2></div>
            <div style="text-align: center"> 2nd Floor Chua Bldg., M.V. Fariñas St., Laoag City</div>
            <div style="text-align: center"> Contact No. 09178153892 / Tel No. 676- 0025 </div>
            <div style="text-align: center"> {{ date_format(date_create($dateToFormat),'F d, Y') }}</div>
        </div>
    </div>

    <table width="100%" style="font-size: 15px; border-bottom: solid 2px #464646; margin-bottom: 5px;">
       <thead>
            <tr>
                <th style="margin-left: 390px;"><h2>Income Statement</h2></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;"><strong>{{ substr(date_format(date_create($reportStart),'F d, Y'), 0, 20) }} to {{ substr(date_format(date_create($reportEnd),'F d, Y'), 0, 20) }}</strong></td>
            </tr>
        </tbody>
        </table>

         <table width="100%" style="font-size: 15px; margin-bottom: 5px; text-align: left;">
        <thead>
            <tr>
                <th>Revenue</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gross Sales</td>
                <td width="210">{{ number_format($grossSales, 2) }}</td>   <!-- total sales for the month -->
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td  width="40">&nbsp;</td>
            </tr>
        </tbody>
        </table>

         <table width="100%" style="font-size: 15px; margin-bottom: 5px; text-align: left;  border-bottom: solid 2px #464646;">
        <thead>
            <tr>
                <th>Cost of Good Sold</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cost of Good Sold</td>
                <td width="200">{{ number_format($deliveryCost, 2) }}</td>   <!-- Total delivery cost for the month  -->
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="70">&nbsp;</td>
            </tr>
        </tbody>
        </table>

        <table>
        <thead><tr><th></th></tr><tr><th></th></tr></thead>
        <tbody><tr></tr></tbody>
        </table>

         <table width="100%" style="font-size: 15px; margin-bottom: 5px; text-align: left;">
        <thead>
            <tr>
                <th>Gross Income</th>
                <th width="195">{{ number_format($grossSales - $deliveryCost, 2) }}</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        </tbody>
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