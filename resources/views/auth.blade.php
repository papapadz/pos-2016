<!DOCTYPE html>
<html class="uk-height-1-1 uk-notouch">
<head>
    <title>E-Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/uikit.gradient.css') }}" />
    <script src="{{ asset('jquery.js') }}"></script>
    <script src="{{ asset('js/uikit.min.js') }}"></script>
</head>
<body class="uk-height-1-1">

<div class="uk-vertical-align uk-text-center uk-height-1-1">
    @yield('content')
</div>

@yield('js')

</body>
</html>