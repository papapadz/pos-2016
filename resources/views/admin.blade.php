<!DOCTYPE html>
<html>
<head>
    <title>POS System - @yield('location')</title>
    <link rel="stylesheet" href="{{ asset('css/uikit.gradient.css') }}" />
   <!-- {!! Html::style('/css/uikit.gradient.css')!!}-->
    <script src="{{ asset('jquery.js') }}"></script>
    <script src="{{ asset('js/uikit.min.js') }}"></script>
    <style>
        html{
            background-image: url('https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.dreamstime.com%2Fstock-illustration-bee-hive-background-yellow-texture-image95147943&psig=AOvVaw2Q75ym3E4optsi5E1Hwj6B&ust=1599125784123000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCKDzovSVyusCFQAAAAAdAAAAABAT');
        }
    </style>
    @yield('css')
</head>
<body>

<nav class="uk-navbar uk-navbar-attached" style="display: none;">

    <a href="/" class="uk-navbar-brand">Point of Sale</a>

    <div class="uk-navbar-content uk-navbar-flip  uk-hidden-small">
        Welcome <strong>{{ Auth::user()->employeename }}</strong>!
        <a href="/auth/logout" class="uk-button uk-button-primary"><i class="uk-icon-sign-out"></i> Logout</a>
    </div>

</nav>

<div class="uk-container uk-container-center">

    <div style="padding: 8px; background-color: ffa200; color: #fff1f0;">

        <div class="uk-grid">
            <div class="uk-width-1-2" style="display: inline;">
                <img src="/img/green-icon.png" alt="" width="50" style="margin-left: 30px;">
            </div>
            <div class="uk-width-1-2" style="padding-top: 4px;">
                <div style="color: #fff1f0; font-size: x-large;" class="uk-text-right" id="clock"></div>
                <div style="color: #fff1f0;" class="uk-text-right uk-text-small"><i>{{ strtoupper(date('d F Y')) }}</i></div>
            </div>
        </div>

    </div>

    <div style="border-top: solid 1px #c1c1c1; border-bottom: solid 1px ffa200; background-color: #a9a9a9; color: #fff1f0; ">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div style="padding: 5px;">

                    <nav class="uk-navbar">

                        <ul class="uk-navbar-nav">
                            <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href=""><i class="uk-icon-exchange"></i> Transactions</a>

                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('salesIndex') }}"><i class="uk-icon-money"></i> Sales</a></li>
                                        
                                        
                                        <li><a href="{{ route('expensesIndex') }}"><i class="uk-icon-list"></i> Expenses</a></li>
                                        <li><a href="{{ route('deliveryIndex') }}"><i class="uk-icon-car"></i> Deliveries</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href=""><i class="uk-icon-folder"></i> Files</a>

                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('customerIndex') }}"><i class="uk-icon-users"></i> Customers</a></li>
                                        <li><a href="{{ route('supplierIndex') }}"><i class="uk-icon-refresh"></i> Suppliers</a></li>
                                        <li><a href="{{ route('productsIndex') }}"><i class="uk-icon-shopping-cart"></i> Products</a></li>
                                        <li><a href="{{ route('categoryIndex') }}"><i class="uk-icon-list-alt"></i> Categories</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href="#"><i class="uk-icon-bars"></i> Reports</a>
                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('reportIndex') }}"><i class="uk-icon-line-chart"></i> Sales Reports</a></li>
                                        <li><a href="{{ route('reportInventory') }}"><i class="uk-icon-cubes"></i> Inventory Reports</a></li>
                                        <li><a href="{{ route('reportReorderIndex') }}"><i class="uk-icon-history"></i> Reorder Report</a></li>
                                        <li><a href="{{ route('reportDeliveryIndex') }}"><i class="uk-icon-truck"></i> Delivery Reports</a></li>
                                        <li><a href="{{ route('reportStatIndex') }}"><i class="uk-icon-bar-chart"></i> Statistical Reports</a></li>
                                        <li><a href="{{ route('reportPaymentIndex') }}"><i class="uk-icon-money"></i> Report of Payments</a></li>
                                        <li><a href="{{ route('reportIncomeStatementIndex') }}"><i class="uk-icon-list"></i> Income Statement</a></li>  
                                    </ul>
                                </div>
                            </li> 

                           <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href="#"><i class="uk-icon-credit-card"></i> Credits</a>
                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('creditIndex') }}"><i class="uk-icon-credit-card"></i> Agents</a></li>
                                        <li><a href="{{ route('reportAgentIndex') }}"><i class="uk-icon-history"></i> Main Office</a></li>
                                        <li><a href="{{ route('reportWeeklyPaymentIndex') }}"><i class="uk-icon-history"></i> Ilocos Sur</a></li>
                                        <li><a href="{{ route('reportCustAgentIndex') }}"><i class="uk-icon-money"></i> Cagayan</a></li> 
                                    </ul>
                                </div>
                            </li>


                           <li><a href="{{ route('employeeIndex') }}"><i class="uk-icon-user"></i> Employees</a></li>
                        </ul>
                        <div class="uk-navbar-content uk-navbar-flip  uk-hidden-small">
                            <div class="uk-button-group">
                                <a href="#" class="uk-button uk-button-success">{{ Auth::user()->employeename }}</a>
                                <a class="uk-button uk-button-danger" href="/auth/logout">Logout <i class="uk-icon-sign-out"></i></a>
                            </div>
                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div style="border-top: solid 1px #c1c1c1;">
        @yield('content')
    </div>

    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-bottom uk-margin-small-top" style="background-color: transparent;">
        <div class="uk-text-bold">Point Of Sale System</div>
        {{-- <div class="uk-text-small">for C.A. Chabby Enterprises</div>
        <div class="uk-text-small">Designed & developed by maehem</div> --}}
        <div class="uk-text-small">All Rights Reserved. &copy; Copyright {{ date('Y') }} Binary Bee IT Solutions and Services</div>
    </div>
</div>

@yield('js')

<script>

    function updateClock ( )
    {
        var currentTime = new Date ( );
        var currentHours = currentTime.getHours ( );
        var currentMinutes = currentTime.getMinutes ( );
        var currentSeconds = currentTime.getSeconds ( );

        // Pad the minutes and seconds with leading zeros, if required
        currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
        currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

        // Choose either "AM" or "PM" as appropriate
        var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

        // Convert the hours component to 12-hour format if needed
        currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

        // Convert an hours component of "0" to "12"
        currentHours = ( currentHours == 0 ) ? 12 : currentHours;

        // Compose the string for display
        var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;


        $("#clock").html(currentTimeString);

    }

    updateClock();

    $(function(){
        setInterval('updateClock()', 1000);
    })
</script>

</body>
</html>