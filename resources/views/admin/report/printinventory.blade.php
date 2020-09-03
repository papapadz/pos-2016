@extends('report')

@section('content')
   <div class="uk-container uk-container-left" width="70%">
        <div class="uk-width-1-1" >
            <div style="text-align: left; margin-bottom: -15px; margin-left: 185px;"><h2><strong>C.A. Chabby Enterprises</strong></h2></div>
            <div style="text-align: left; margin-left: 165px"> Main Office: Brgy. 7-B 56 P. Gomez St., Laoag City</div>
            <div style="text-align: left; margin-left: 90px"> Contact Nos: +63 939-923-1048 / +63 917-628-3784 / +63 925-576-2377</div>
            <div style="text-align: left; margin-left: 215px"> Proprietor - Engr. Robert R. Alog</div>
            <div style="text-align: left; margin-left: 185px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div>
                @if($catSel == 0)
                    <h2 style="text-align: left; margin-left: 222px"><strong> Inventory Report</strong></h2>
                @else
                    <h2 style="text-align: left; margin-left: 170px"><strong> Inventory Report by Category</strong></h2>
                @endif
            </div>
            <div style="text-align: left; margin-left: 242px"><strong> As of {{ date_format(date_create($dateToFormat),'F d, Y') }}</strong></div>
        </div>
    </div>

    <table width="70%" style="font-size: 15px; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="70%" style="text-align: left; margin-left: 185px"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
        </tr>
    </table>

    <table width="70%" style="font-size: 13px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="280px;">Size</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="280px;">Pattern</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Product Description</th>
            <th style="background-color: #464646; color: #fff; text-align: center;">Stock</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">Unit Price</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
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
                    <td>{{ $report->productname }}</td>
                    <td>{{ $report->pattern }}</td>
                    <td>{{ $report->productcode }}</td>
                    <td style="text-align: center;">{{ $report->stock }}</td>
                    <td>&nbsp;</td>
                    <td style="text-align: right;">{{ number_format($report->unitprice, 2) }}</td>
                    <td>&nbsp;</td>
                    <td style="text-align: right;">{{ number_format((($report->stock * $report->unitprice) < 0) ? 0 : ($report->stock * $report->unitprice), 2) }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

        @endforeach
        @endif
    </table>
    <table width="70%" style="font-size: 15px;" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" width="80%" style="text-align: right;"><strong>Total Inventory:</strong></td>
            <td width="150" width="20%" style="text-align: right;"> {{ number_format($totalInventoryValue, 2) }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

        </tr>
    </table>
    <table width="70%" style="font-size: 15px;" cellspacing="0">
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