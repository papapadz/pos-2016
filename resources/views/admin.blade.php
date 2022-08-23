<!DOCTYPE html>
<html>
<head>
    <title>E-Inventory System - @yield('location')</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.3/dist/css/uikit.min.css" />

    <script src="{{ asset('jquery.js') }}"></script>
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.3/dist/js/uikit-icons.min.js"></script>
    <style>
        #banner {
            background-image: url("{{asset('img/banner-sales.jpg')}}");
            padding: 8px;
            height: 100px;
        }
    </style>
    @yield('css')
</head>
<body>

<div class="uk-container uk-container-center">
    <div id="banner">
        <div class="uk-grid">
            <div class="uk-width-1-2" style="display: inline;">
                <img src="{{ asset('img/logo.png') }}" alt="" width="80" style="margin-left: 30px;"><span style="font-style: strong; font-size:32px">My E-Inventory</span>
            </div>
            <div class="uk-width-1-2" style="padding-top: 4px;">
                <div style="font-size: x-large;" class="uk-text-right" id="clock"></div>
                <div class="uk-text-right uk-text-small"><i>{{ strtoupper(date('d F Y')) }}</i></div>
            </div>
        </div>

    </div>
    <div class="uk-container" style="margin-left:30px; margin-right: 30px">
        <nav class="uk-navbar-container uk-margin" uk-navbar style="background-color: transparent;">
            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li><a href="{{ route('salesIndex') }}" uk-icon="icon: tag"> Sales</a></li>
                    <li><a href="{{ route('deliveryIndex') }}" uk-icon="icon: bag"> Deliveries</a></li>
                    <li>
                        <a href="#" uk-icon="icon: list"></i> Items</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="{{ route('categoryIndex') }}"><i class="uk-icon-list-alt"></i> Categories</a></li>
                                <li><a href="{{ route('supplierIndex') }}"><i class="uk-icon-refresh"></i> Suppliers</a></li>
                                <li><a href="{{ route('productsIndex') }}"><i class="uk-icon-shopping-cart"></i> Products</a></li>
                                <li><a href="{{ route('employeeIndex') }}"><i class="uk-icon-user"></i> Employees</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" uk-icon="icon: copy"></i> Reports</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
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
                </ul>

            </div>
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="#">Hi, {{ Auth::user()->employeename }}</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="{{ route('employeeIndex') }}"><i class="uk-icon-user"></i> My Profile</a></li>
                                <li><a href="/auth/logout" class="uk-text-danger">Logout <i class="uk-icon-sign-out"></i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="uk-card uk-card-default uk-card-body">
        @yield('content')
    </div>


    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-bottom uk-margin-small-top" style="background-color: transparent;">
        <div class="uk-text-bold">Point Of Sale System</div>
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