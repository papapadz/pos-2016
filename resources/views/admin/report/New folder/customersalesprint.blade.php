<div style="font-family: Arial,Helvetica Neue,Helvetica,sans-serif; width: 1000px; font-size: 12px;">

    <div style="text-align: center; margin-bottom: 5px;">
        <strong>Sales Report per Customer</strong>
    </div>

    <table style="font-size: 12px;" width="100%">
        <tr>
            <td>Customer</td>
            <td>{{ $customer->lastname }}, {{ $customer->firstname }}</td>
            <td>Date</td>
            <td>{{ date('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $customer->address }}</td>
        </tr>
    </table>

    <table style="font-size: 10px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="background-color: #464646; color: #fff;">Invoice #</th>
            <th style="background-color: #464646; color: #fff;">Sales Date</th>
            <th style="background-color: #464646; color: #fff;">VATable Sales</th>
            <th style="background-color: #464646; color: #fff;">12% VAT</th>
            <th style="background-color: #464646; color: #fff;">Total Amount</th>
        </tr>
        </thead>
        <tbody>
        @if(count($reports) > 0)
            @foreach($reports as $report)
                <tr>
                    {{--*/
                    $vatSales = $report->myDetails->sum('sales_price') / 1.12;
                    $vat = $vatSales * .12;
                    $salesAmt = $report->myDetails->sum('sales_price');
                    /*--}}
                    <td>{{ $report->invoicenumber }}</td>
                    <td>{{ substr($report->salesdate, 0, 10) }}</td>
                    <td>{{ number_format($vatSales, 2) }}</td>
                    <td>{{ number_format($vat, 2) }}</td>
                    <td>{{ number_format($salesAmt, 2) }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<script type="text/javascript">
    window.print();
    window.close();
</script>