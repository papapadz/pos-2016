<div style="font-family: Arial,Helvetica Neue,Helvetica,sans-serif; width: 700px; font-size: 15px; text-align: center" >

   <div class="uk-container uk-container-center">
        <div class="uk-width-1-1" >
            
           <div style="text-align: center; margin-bottom: -10px;"><h2><strong>C.A. Chabby Enterprises</strong></h2></div>
           <div style="text-align: center"> &nbsp;&nbsp;Brgy. 7-B 56 p. Gomez St., Laoag City</div>
           <div style="text-align: center; margin-bottom: -5px;"> &nbsp;&nbsp;Contact Nos: 09399231048 / 09176283784 / 09255762377</div>
           <div style="text-align: center; margin-bottom: -5px;"> Proprietor - Engr. Robert R. Alog</div>
           <div style="text-align: center; margin-bottom: 13px;"><h2><strong>&nbsp;&nbsp;{{ ($sales->sales_type == 1 ? 'Customer Sales Invoice' : 'Customer Charge Invoice') }}</strong></h2></div>
        </div>      
    </div>

    
     <table width="100%" style="font-size: 14px; border-bottom: solid 2px #464646; border-top: solid 2px #464646; margin-bottom: 10px;">
        <tr>
            <td valign="top"><strong>Customer</strong></td>
            <td valign="top">{{ $customer->companyname }} -- {{ $customer->lastname }}</td>
            <td valign="top"><strong>Date</strong></td>
            <td valign="top">{{ substr($sales->salesdate, 0, 10) }}</td>
        </tr>
        <tr>
            <td valign="top"><strong>Address</strong></td>
            <td valign="top">{{ $customer->address }}</td>
            <td valign="top"><strong>Invoice No.</strong></td>
            <td valign="top">{{ $sales->invoicenumber }}</td>
        </tr>
        <tr>
            <td valign="top"><strong>Contact No.</strong></td>
            <td valign="top">{{ $customer->contactno }}</td>
        </tr>
    </table>

    <table width="100%" style="font-size: 14px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="40%">Category</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="40%">Size</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="40%">Pattern</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="20%">Quantity</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="20%">&nbsp;&nbsp;&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: right;" width="20%">SalesPrice</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="20%">&nbsp;&nbsp;&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: left;" width="20%">&nbsp;&nbsp;&nbsp;</th>
            <th style="background-color: #464646; color: #fff; text-align: right;" width="20%">Total</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
            <th style="background-color: #464646; color: #fff;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        {{--*/ $total = 0; /*--}}

        @if(count($salesDetails) > 0)
            @foreach($salesDetails as $salesDetail)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td valign="top">{{ $salesDetail->myProduct->myCategory->categoryname }}</td>
                    <td valign="top">{{ $salesDetail->myProduct->productname }}</td>
                    <td valign="top">{{ $salesDetail->qty }}</td>
                    <td valign="top" style="text-align: right;">{{ number_format(($salesDetail->sales_price/$salesDetail->qty), 2) }}</td>
                    <td valign="top" style="text-align: right;">&nbsp;&nbsp;&nbsp;</td>
                    <td valign="top" style="text-align: right;">{{ number_format($salesDetail->sales_price, 2) }}</td>
                    <td valign="top" style="text-align: right;">&nbsp;&nbsp;&nbsp;</td>
                    <td valign="top" style="text-align: right;">&nbsp;&nbsp;&nbsp;</td>
                    <td valign="top" style="text-align: right;">{{ number_format(($salesDetail->sales_price * $salesDetail->qty), 2) }}</td>
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