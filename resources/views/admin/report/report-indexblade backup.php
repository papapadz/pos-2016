<div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['route'=>'reportIndex', 'method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::select('option', ['1'=>'Daily Report', '2'=>'Monthly Report'], $option, ['id'=>'report-option']) !!}
                            {!! Form::text('daystart', $daySelstart, ['id'=>'daystart', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                            {!! Form::text('dayend', $daySelend, ['id'=>'dayend', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                            {!! Form::select('monthly', $months, $monthSel, ['id'=>'monthly', 'disabled']) !!}
                            {!! Form::button('Generate', ['id'=>'btn-generate', 'type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                            <a href="{{ route('reportPrint', ['option'=>$option, 'day'=>$daySel, 'month'=>$monthSel]) }}" target="_blank" class="uk-button uk-button-success">Print Report</a>
                            {!! Form::close() !!}
                        </div>


public function index(Request $request)
    {
        $dateToFormat = date('Y-m-d');

        $option = (!is_null($request->option)) ? $request->option : 1;
        $monthSel = (!is_null($request->monthly)) ? $request->monthly : 1;
        if(strlen($monthSel) == 1)
        {
            $monthSel = '0'.$monthSel;
        }

        #$daySel = (!is_null($request->daily)) ? $request->daily : $dateToFormat;
        $daySelstart = (!is_null($request->daystart)) ? $request->daystart : $dateToFormat;
        $daySelend = (!is_null($request->dayend)) ? $request->dayend : $dateToFormat;

        $months = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $month = $request->monthly;

        #dd($request->all());

        if(!is_null($request->monthly))
        {
            $reportStart = date('Y-'.$monthSel.'-01').' 00:00:00';
            $reportEnd = date('Y-'.$monthSel.'-31').' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
        }
        else
        {
            #$day = (strlen($request->daily) < 2) ? ('0'.$request->daily) : $request->daily;

            #$reportStart = $daySel.' 00:00:00';
            #$reportEnd = $daySel.' 23:59:59';

            $day = (strlen($request->daystart) < 2) ? ('0'.$request->daystart) : $request->daystart;

            $reportStart = $daySelstart.' 00:00:00';
            $reportEnd = $daySelstart.' 23:59:59';

            $reports = Sales::wherebetween('salesdate', [$reportStart, $reportEnd])->orderby('sales_id', 'desc')->get();
        }

        $sumSales = 0;
        $sumCredit =0;


        foreach($reports as $report)
        {
             #$sumSales += $report->myPayments->sum('amountpaid');
             $sumSales += $report->totalsales;
             $sumCredit += $report->myPayment->where('sales_id', $report->sales_id)->latest('payment_id')->first()->balancedue;
        }

        $sumCash = $sumSales - $sumCredit;

        return view('admin.report.index', compact('dateToFormat', 'months', 'monthSel', 'daySelstart', 'daySelend', 'reports', 'sumSales', 'sumCredit', 'sumCash', 'option'));
    }