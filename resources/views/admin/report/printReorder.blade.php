@extends('report')

@section('content')
    <div class="uk-container uk-container-left" width="100%">
        <div class="uk-width-1-1" >
             <div style="text-align: left; margin-bottom: -15px; margin-left: 185px;"><h2><strong>C.A. Chabby Enterprises</strong></h2></div>
            <div style="text-align: left; margin-left: 165px"> Main Office: Brgy. 7-B 56 P. Gomez St., Laoag City</div>
            <div style="text-align: left; margin-left: 90px"> Contact Nos: +63 939-923-1048 / +63 917-628-3784 / +63 925-576-2377</div>
            <div style="text-align: left; margin-left: 215px"> Proprietor - Engr. Robert R. Alog</div>
            <div style="text-align: left; margin-left: 185px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div style="text-align: left; margin-left: 185px"><h2><strong> Product Reorder Report</strong></h2></div>
            <div style="text-align: left; margin-left: 235px"><strong> As of {{ date_format(date_create($dateToFormat),'F d, Y') }}</strong></div>
        </div>
    </div>

      <table width="70%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: center;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>

    <table width="70%" style="font-size: 14px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
         <thead>
            <tr style="background-color: #464646; color: #fff;">
                <th>&nbsp;</th>
                <th style="text-align: left;">Size</th>
                <th style="text-align: left;">Pattern</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th style="text-align: left;">Product Description</th>
                <th style="text-align: left;">Category</th>
                <th style="text-align: center;">Re-order Limit</th>
                <th style="text-align: center;">Stocks Left</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
               @foreach($reports as $report)
                    @if($report->stock <= $report->reorderlimit)
                        <tr>
                            <td>&nbsp;</td>
                            <td>{{ $report->productname }}</td>
                            <td>{{ $report->pattern }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>{{ $report->productcode }}</td>
                            <td>{{ $report->myCategory->categoryname }}</td>
                            <td style="text-align: center;">{{ $report->reorderlimit }}</td>
                            <td style="text-align: center;">{{ $report->stock }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        @endif
                @endforeach 
            </tbody>
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
