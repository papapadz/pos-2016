<!DOCTYPE html>
<html>
<head>
    <title>POS System for JC - @yield('location')</title>
    <link rel="stylesheet" href="/css/uikit.gradient.css" />
   <!-- {!! Html::style('/css/uikit.gradient.css')!!}-->
    <script src="/jquery.js"></script>
    <script src="/js/uikit.min.js"></script>
    <style>
        html{
            background-image: url('/img/bg.gif');
        }
    </style>
    @yield('css')
</head>
<body>

<nav class="uk-navbar uk-navbar-attached" style="display: none;">

    <a href="/" class="uk-navbar-brand">Point of Sale</a>

    <div class="uk-navbar-content uk-navbar-flip  uk-hidden-small">
        Welcome <strong>{{ Auth::user()->employeename }}</strong>!
        <a href="/auth/logout" class="uk-button uk-button-danger"><i class="uk-icon-sign-out"></i> Logout</a>
    </div>

</nav>

<div class="uk-container uk-container-center">

    <div style="padding: 8px; background-color: #4E5255; color: #fff1f0;">

        <div class="uk-grid">
            <div class="uk-width-1-2" style="display: inline;">
                <img src="/img/pos-icon.gif" alt="" width="50" style="margin-left: 30px;">
            </div>
            <div class="uk-width-1-2" style="padding-top: 4px;">
                <div style="color: #fff1f0; font-size: x-large;" class="uk-text-right" id="clock"></div>
                <div style="color: #fff1f0;" class="uk-text-right uk-text-small"><i>{{ strtoupper(date('d F Y')) }}</i></div>
            </div>
        </div>

    </div>

    <div style="border-top: solid 1px #c1c1c1; border-bottom: solid 1px #4e5255; background-color: #a9a9a9; color: #fff1f0; ">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div style="padding: 5px;">

                    <nav class="uk-navbar">

                        <ul class="uk-navbar-nav">
                            <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href=""><i class="uk-icon-exchange"></i> Transactions</a>

                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('secretarySalesIndex') }}"><i class="uk-icon-money"></i> Sales</a></li>
                                        <li><a href="{{ route('secretaryCreditIndex') }}"><i class="uk-icon-credit-card"></i> Credit</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href=""><i class="uk-icon-folder"></i> Files</a>

                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('secretaryCustomerIndex') }}"><i class="uk-icon-users"></i> Customers</a></li>
                                        <li><a href="{{ route('secretarySupplierIndex') }}"><i class="uk-icon-refresh"></i> Suppliers</a></li>
                                        <li><a href="{{ route('secretaryProductsIndex') }}"><i class="uk-icon-shopping-cart"></i> Products</a></li>
                                        <li><a href="{{ route('secretaryCategoryIndex') }}"><i class="uk-icon-list-alt"></i> Categories</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li data-uk-dropdown="" class="uk-parent" aria-haspopup="true" aria-expanded="false">
                                <a href="#"><i class="uk-icon-bars"></i> Reports</a>
                                <div class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom" style="top: 40px; left: 0px;">
                                    <ul class="uk-nav uk-nav-navbar">
                                        <li><a href="{{ route('supervisorReportSalesIndex') }}"><i class="uk-icon-list-alt"></i> Sales by Cust Type</a></li>
                                        <li><a href="{{ route('supervisorReportPaymentIndex') }}"><i class="uk-icon-list"></i> Report of Payments</a></li>
                                    </ul>
                                </div>
                            </li>      
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