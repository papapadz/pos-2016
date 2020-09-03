@extends('report')

@section('content')
   <div class="uk-container uk-container-center" width="100%">
        <div class="uk-width-1-1" >
            <div style="text-align: center"><h2><strong><img src="/img/jc2.gif" alt="" width="50"> Joshua & Caleb Gen. Merchandise</strong></h2></div>
            <div style="text-align: center"> 2nd Floor Chua Bldg., M.V. Fariñas St., Laoag City</div>
            <div style="text-align: center"> Contact No. 09178153892 / Tel No. 676- 0025 </div>
            <div style="text-align: center"> &nbsp;</div>
            <div>
                @if($catSel == 0)
                    <h2 style="text-align: center"><strong>Inventory Report</strong></h2>
                @else
                    <h2 style="text-align: center"><strong>Inventory Report by Category</strong></h2>
                @endif
            </div>
        </div>
    </div>

    <table width="100%" style="font-size: 15px; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="100%" style="text-align: center;"><strong>As of {{ date_format(date_create($dateToFormat),'F d, Y') }}</strong></td>
        </tr>
    </table>

    <table width="100%" style="font-size: 13px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="280px;">Product Name</th>
            <th style="background-color: #464646; color: #fff; text-align: center;">Stock</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">Unit Price</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">Total Value</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        @if(count($reports) > 0)
            @foreach($reports as $report)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>{{ $report->productname }}</td>
                    <td style="text-align: center;">{{ $report->stock }}</td>
                    <td style="text-align: right;">{{ number_format($report->unitprice, 2) }}</td>
                    <td style="text-align: right;">{{ number_format((($report->stock * $report->unitprice) < 0) ? 0 : ($report->stock * $report->unitprice), 2) }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

        @endforeach
        @endif
    </table>
    <table width="100%" style="font-size: 15px;" cellspacing="0">
        <tr>
            <td colspan="3" width="80%" style="text-align: right;"><strong>Total Inventory:</strong></td>
            <td width="150" width="20%" style="text-align: right;"> {{ number_format($totalInventoryValue, 2) }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

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