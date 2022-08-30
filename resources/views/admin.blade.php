<!DOCTYPE html>
<html>
<head>
    <title>E-Inventory System - @yield('location')</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.3/dist/css/uikit.min.css" />
    <!-- datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <script src="{{ asset('jquery.js') }}"></script>
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.3/dist/js/uikit-icons.min.js"></script>
    <!-- Date Picker -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <style>
        #banner {
            background-image: url("{{asset('img/banner-sales.jpg')}}");
            padding: 8px;
            height: 100px;
        },
        .lime {
            background: limegreen; 
            color: white;
        },
    </style>
    @yield('css')
</head>
<body>
<div class="uk-container uk-container-center">
    <div id="banner" class="uk-card uk-card-default uk-card-body">
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
    <div class="uk-container">
        <div>
            <nav class="uk-navbar-container" uk-navbar style="background-color:rgb(196, 248, 232); padding-left: 3rem; padding-right: 3rem; box-shadow: 0 3px 10px rgb(0 0 0 / 0.1)">
                <div class="uk-navbar-left">
                    <ul class="uk-navbar-nav">
                        <li @if(Request::is('*/sales')) class="uk-active" @endif><a href="{{ route('salesIndex') }}" uk-icon="icon: tag"> Sales</a></li>
                        @if(Auth::User()->position==1 || Auth::User()->position==2)
                            <li @if(Request::is('*/delivery') || Request::is('*/delivery-details/show/*')) class="uk-active" @endif><a href="{{ route('deliveryIndex') }}" uk-icon="icon: bag"> Deliveries</a></li>
                        @endif
                        @if(Auth::User()->position==1 || Auth::User()->position==2)
                        <li @if(Request::is('*/category') || Request::is('*/supplier') || Request::is('*/products') || Request::is('*/employee')) class="uk-active" @endif>
                            <a href="#"></i>Items <span uk-navbar-parent-icon></span></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{ route('categoryIndex') }}" uk-icon="icon: thumbnails">CATEGORIES </a></li>
                                    <li><a href="{{ route('supplierIndex') }}" uk-icon="icon: cart">SUPPLIERS </a></li>
                                    <li><a href="{{ route('productsIndex') }}" uk-icon="icon: bag">PRODUCTS </a></li>
                                    @if(Auth::User()->position==1)
                                    <li><a href="{{ route('employeeIndex') }}" uk-icon="icon: users">EMPLOYEES </a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li @if(Request::is('*/report') || Request::is('*/inventory/report')) class="uk-active" @endif>
                            <a href="#"></i>Reports <span uk-navbar-parent-icon></span></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{ route('reportIndex') }}" uk-icon="icon: hashtag">SALES </a></li>
                                    <li><a href="{{ route('reportInventory') }}" uk-icon="icon: album">INVENTORY </a></li>
                                    {{-- <li><a href="{{ route('reportReorderIndex') }}"><i class="uk-icon-history"></i> Reorder Report</a></li>
                                    <li><a href="{{ route('reportDeliveryIndex') }}"><i class="uk-icon-truck"></i> Delivery Reports</a></li>
                                    <li><a href="{{ route('reportStatIndex') }}"><i class="uk-icon-bar-chart"></i> Statistical Reports</a></li>
                                    <li><a href="{{ route('reportPaymentIndex') }}"><i class="uk-icon-money"></i> Report of Payments</a></li>
                                    <li><a href="{{ route('reportIncomeStatementIndex') }}"><i class="uk-icon-list"></i> Income Statement</a></li> --}}
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>

                </div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        <li>
                            <a href="#">Hi, {{ Auth::user()->employeename }} <span uk-navbar-parent-icon></span></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{ route('employeeEdit',['id' => Auth::user()->employee_id]) }}" uk-icon="icon: user">My Profile </a></li>
                                    <li><a href="/auth/logout" class="uk-text-danger" uk-icon="icon: sign-out">Logout </a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="uk-card uk-card-default uk-card-body">
        @if(Session::has('success'))
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ Session::get('success')}}</p>
        </div>
        @endif
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