<div style="font-family: Arial,Helvetica Neue,Helvetica,sans-serif; width: 700px; font-size: 15px; text-align: center">

<div class="uk-container uk-container-center">
    <div class="uk-width-1-1" >
        <div style="text-align: center; margin-bottom: -10px;"><h2><strong><img src="/img/jp.gif" alt="" width="50">Jack's Place Variety Shop</strong></h2></div>
           <div style="text-align: center"> &nbsp;&nbsp;84 Washington St., Ablan, City of Batac, Ilocos Norte</div>
           <div style="text-align: center"> &nbsp;&nbsp;Jocel Tagatac - Proprietor  </div>
           <div style="text-align: center; margin-bottom: -10px;"> &nbsp;&nbsp;Contact No: 09293202718</div>
           <div style="text-align: center; margin-bottom: 3px;"><h2><strong>&nbsp;&nbsp;{{ ($sales->sales_type == 1 ? 'Customer Sales Invoice' : 'Customer Charge Invoice') }}</strong></h2></div>
        </div>          
</div>
    

    <table width="100%" style="font-size: 14px; border-bottom: solid 2px #464646; border-top: solid 2px #464646; margin-bottom: 10px;">
        <tr>
            <td >&nbsp;</td>
            <td ><strong>Customer</strong></td>
            <td >{{ $customer->firstname }} {{ $customer->lastname }}</td>
            <td ><strong>Date</strong></td> 
            <td >{{ substr($sales->salesdate, 0, 10) }}</td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top"><strong>Address</strong></td>
            <td valign="top">{{ $customer->city }}</td>
            <td valign="top"><strong>Invoice Number</strong></td>
            <td valign="top">{{ $sales->invoicenumber }}</td>
        </tr>
    </table>

    <table width="100%" style="font-size: 13px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
        <thead style="border-bottom: solid 1px #464646; margin-bottom: 8px;">
        <tr>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Product Name</th>
            <th style="background-color: #464646; color: #fff; text-align: left;">Quantity</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">Sales Price</th>
            <th style="background-color: #464646; color: #fff; text-align: right;">Total</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        @if(count($salesDetails) > 0)
            @foreach($salesDetails as $salesDetail)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td valign="top">{{ $salesDetail->myProduct->productname }}</td>
                    <td valign="top">{{ $salesDetail->qty }}</td>
                    <td style="text-align: right;" valign="top">{{ number_format($salesDetail->sales_price / $salesDetail->qty, 2) }}</td>
                    <td style="text-align: right;" valign="top">{{ number_format(($salesDetail->sales_price), 2) }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" valign="top"><i>No customer transaction record/s found.</i></td>
            </tr>
        @endif
        </tbody>
    </table>

   <table width="100%" style="font-size: 14px;" cellspacing="0">
        <tr><td></td></tr>
        <tr>
            <td colspan="3" width="88%" style="text-align: right;">VATable Sales:</td>
            <td style="text-align: right;" width="100">{{ number_format($vatSales, 2) }}</td>
            <td width="40">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">12% VAT:</td>
            <td style="text-align: right;">{{ number_format($vat, 2) }}</td>
            <td width="40">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total Amount:</strong></td>
            <td style="text-align: right;"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
            <td width="40">&nbsp;</td>
        </tr>

         {{--*/ $total = $grandTotal - ($grandTotal * ($sales->discount/100)) - $sales->fixedAmtDiscount; /*--}}

         <tr>
            <td colspan="3" style="text-align: right;"><strong>Discounted Amount:</strong></td>
            <td style="text-align: right;">{{ number_format($total, 2) }}</td>
            <td width="40">&nbsp;</td>
        </tr>     
         <tr>
            <td colspan="3" style="text-align: right;">Discount:</td>
            <td style="text-align: right;">{{ number_format($grandTotal - $total, 2) }}</td>
            <td width="40">&nbsp;</td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    window.print();
    window.close();
</script>