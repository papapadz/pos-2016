@extends('report')

@section('content')
    <div class="uk-container uk-container-center" width="70%">
        <div class="uk-width-1-1" >
            <div style="text-align: left; margin-bottom: -15px; margin-left: 185px;"><h2><strong>C.A. Chabby Enterprises</strong></h2></div>
            <div style="text-align: left; margin-left: 165px"> Main Office: Brgy. 7-B 56 P. Gomez St., Laoag City</div>
            <div style="text-align: left; margin-left: 90px"> Contact Nos: +63 939-923-1048 / +63 917-628-3784 / +63 925-576-2377</div>
            <div style="text-align: left; margin-left: 215px"> Proprietor - Engr. Robert R. Alog</div>
            <div style="text-align: left; margin-left: 185px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div style="text-align: left; margin-left: 220px"><h2><strong> Statistical Report</strong></h2></div>
            <div style="text-align: left; margin-left: 195px"><strong> {{ date_format(date_create($reportStart),'F d, Y'), 0, 20 }} to {{ date_format(date_create($reportEnd),'F d, Y'), 0, 20 }}</strong></div>
        </div>
    </div>

      <table width="70%" style="font-size: 15px; text-align: center; border-bottom: solid 2px #464646; margin-bottom: 5px;">
        <tr>
            <td valign="top" colspan="3" width="80%" style="text-align: right;"> Date: {{ date_format(date_create($dateToFormat),'d F Y') }}</td>
        </tr>
    </table>

    <table width="70%" style="font-size: 14px; border-bottom: solid 1px #464646; margin-bottom: 5px;" cellspacing="0">
         <thead>
            <tr style="background-color: #464646; color: #fff;">
                <th>&nbsp;</th>
                <th style="text-align: left;">Rank</th>
                <th style="text-align: left;">Size</th>
                <th style="text-align: left;">Pattern</th>
                <th style="text-align: left;">Category</th>
                <th style="text-align: center;">Purchase Times</th> <!-- frequently bought products -->
                <th style="text-align: right;">Percentage</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            {{--*/ $total = 0; /*--}}
            {{--*/ $hundred = 0; /*--}}
            {{--*/ $percentage = 0; /*--}}
            {{--*/ $rank = 0; /*--}}


            @if(count($reports) > 0)
                @foreach($reports as $report)
                    {{--*/ $rank += 1; /*--}}
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align: left;" width="70;">{{ $rank }}</td>
                        <td style="text-align: left;">{{ $report->productname }}</td>
                        <td style="text-align: left;">{{ $report->pattern }}</td>
                        <td style="text-align: left;">{{ $report->myCategory->categoryname }}</td>
                        <td style="text-align: center;">{{ $report->count }}</td>
                        <td style="text-align: right;">{{ number_format(($report->count/$overallCtr) * 100, 2) }}%</td>
                        <td>&nbsp;</td>
                    </tr>

                    {{--*/ $total +=  $report->count; /*--}}
                    {{--*/ $hundred +=  ($report->count/$overallCtr) * 100; /*--}}

                @endforeach
                     <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align: left;">&nbsp;</td>
                        <td style="text-align: center;">-----</td>
                        <td style="text-align: right;">----------</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align: center;"><strong>{{ $total }}</strong></td>
                        <td style="text-align: right;"><strong>{{ $hundred }}%</strong></td>
                        <td>&nbsp;</td>
                </tr>
            @endif
            </tbody>
            <tbody><tr><td></td></tr></tbody>
            <tbody>
             
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