<div style="font-family: Arial,Helvetica Neue,Helvetica,sans-serif; width: 600px; font-size: 14px; margin-top: 20px; text-align: center" >
 <div class="uk-container uk-container-center">
        <div class="uk-width-1-1" >
            <div style="text-align: center;"> &nbsp;&nbsp;</div>
            <div style="text-align: center"> &nbsp;&nbsp;</div>
            <div style="text-align: center"> &nbsp;&nbsp; </div>
        </div>      
    </div>

    <table width="80%" style="font-size: 14px; margin-bottom: 10px;">
        <tr>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. {{ $sales->invoicenumber }}</strong></td>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top" style="text-align: right;"><strong>{{ substr(date_format(date_create($sales->salesdate), 'F d, Y'), 0, 20) }}</strong></td>
        </tr>
        <tr>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top" style="text-align: right;"><strong>{{ ($sales->sales_type == 1 ? 'Cash Sale' : 'Credit Sale') }}</strong></td>
        </tr>
        <tr>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"><strong>{{ $customer->firstname }} {{ $customer->lastname }}</strong></td>
        </tr>
         <tr>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"><strong>{{ $customer->tin_no }}</strong></td>
        </tr>
        <tr>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"><strong>{{ $customer->address }} , {{ $customer->city }} </strong></td>
        </tr>
         <tr>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>

    <table width="85%" style="font-size: 12px; margin-bottom: 5px;" cellspacing="0">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        {{--*/ $total = 0; /*--}}

        @if(count($salesDetails) > 0)
            @foreach($salesDetails as $salesDetail)
                <tr>
                    <td>&nbsp;</td>
                    <td valign="top" style="text-align: left;"><strong>{{ $salesDetail->qty }}</strong></td>
                    <td width="80px">&nbsp;</td>
                    <td valign="top"><strong>{{ $salesDetail->myProduct->productname }}</strong></td>
                     <td width="40px">&nbsp;</td>
                    <td valign="top" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;{{ number_format(($salesDetail->sales_price/$salesDetail->qty), 2) }}</strong></td>
                    <td valign="top" style="text-align: right;"><strong>{{ number_format($salesDetail->sales_price, 2) }}</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                {{--*/ $total += $salesDetail->qty * $salesDetail->myProduct->unitprice /*--}}

            @endforeach
        @else
            <tr>
                <td colspan="8" valign="top"><i>No customer transaction record/s found.</i></td>
            </tr>
        @endif
        </tbody>
    </table>

    <table width="85%" style="font-size: 14px;" cellspacing="0">
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
    </table>
      <table width="85%" style="font-size: 14px;" cellspacing="0">
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
    </table>
    <table width="85%" style="font-size: 14px;" cellspacing="0">
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
         <tr>
            <td colspan="3" style="text-align: right;">&nbsp;&nbsp;&nbsp;</td>
            <td style="text-align: right;"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>
         <tr>
            <td colspan="3" style="text-align: right;">&nbsp;&nbsp;&nbsp;</td>
            <td style="text-align: right;"><strong>{{ number_format($vat, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" width="88%" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;</strong></td>
            <td style="text-align: right;" width="100"><strong>{{ number_format($vatSales, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>
         <tr>
            <td colspan="3" width="88%" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;</strong></td>
            <td style="text-align: right;" width="100"><strong>{{ number_format($vatSales, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;</strong></td>
            <td style="text-align: right;"><strong>{{ number_format($vat, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>&nbsp;&nbsp;&nbsp;</strong></td>
            <td style="text-align: right;"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    window.print();
    window.close();
</script>