@extends('report')

@section('content')
    <div class="uk-container uk-container-center" width="100%">
        <div class="uk-width-1-1" >
            <div style="text-align: center"><h2><strong><img src="/img/jc2.gif" alt="" width="50"> Joshua & Caleb Gen. Merchandise</strong></h2></div>
            <div style="text-align: center"> 2nd Floor Chua Bldg., M.V. Fariñas St., Laoag City</div>
            <div style="text-align: center"> Contact No. 09178153892 / Tel No. 676- 0025 </div>
            <div style="text-align: center"> &nbsp;</div>
            <div style="text-align: center"><h2><strong> Product Reorder Report</strong></h2></div>
        </div>
    </div>

      <table width="100%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: center;"> As of {{ date_format(date_create($dateToFormat),'F d, Y') }}</td>
        </tr>
    </table>

    <table width="100%" style="font-size: 14px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
         <thead>
            <tr style="background-color: #464646; color: #fff;">
                <th>&nbsp;</th>
                <th style="text-align: left;">Product Name</th>
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
                            <td>{{ $report->myCategory->categoryname }}</td>
                            <td style="text-align: center;">{{ $report->reorderlimit }}</td>
                            <td style="text-align: center;">{{ $report->stock }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        @endif
                @endforeach 
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
                <td colspan="3" style="text-align: left;">Printed by:&nbsp;&nbsp;<strong>{{ Auth::user()->employeename }}</strong></td>
            </tr>
        </table>
@endsection

<script type="text/javascript">
    window.print();
    window.close();
</script>
