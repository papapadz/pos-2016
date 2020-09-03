@extends('admin')

@section('content')

<script>UIkit.modal.alert('Welcome Maehem!');</script> 

<div class="uk-slidenav-position" data-uk-slider>
    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">
           <div class="uk-panel uk-panel-box" style="padding: 20px; margin-top: 15px; margin-bottom: 15px;">
                <img src="/img/t_auto_logo.jpg"></li>
            </div>
                <div data-uk-slider>
                    <div class="uk-slider-container">
                        <ul class="uk-slider uk-grid uk-grid-collapse uk-grid-width-medium-1-4">
                            <li><img src="/img/tires1.jpg"></li>
                            <li><img src="/img/tires2.jpg"></li>
                            <li><img src="/img/tires3.jpg"></li>
                            <li><img src="/img/tires4.jpg"></li>
                            <li><img src="/img/tires6.jpg"></li>
                            <li><img src="/img/tires7.jpg"></li>
                            <li><img src="/img/tires9.jpg"></li>
                        </ul>
                    </div>
                </div>
                <a href="#" style="color: #645d5d;" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                <a href="#" style="color: #645d5d;" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
            
        </div>
    </div>
</div>


@stop

@section('location') Home @stop

@section('js')

        <!-- Javascript-->
        <script src="/js/components/slider.js"></script>
        <script src="/js/components/slider.min.js"></script>
        <script src="/js/uikit.js"></script>
        <script src="/js/uikit.min.js"></script>        
@stop

@section('css')

<link rel="stylesheet" type="text/css" href="/css/components/slidenav.almost-flat.css">
<link rel="stylesheet" type="text/css" href="/css/components/slidenav.almost-flat.min.css">
<link rel="stylesheet" type="text/css" href="/css/components/slidenav.css">
<link rel="stylesheet" type="text/css" href="/css/components/slidenav.gradient.css">
<link rel="stylesheet" type="text/css" href="/css/components/slidenav.gradient.min.css">
<link rel="stylesheet" type="text/css" href="/css/components/slidenav.min.css">

<link rel="stylesheet" type="text/css" href="/css/components/slider.almost-flat.css">
<link rel="stylesheet" type="text/css" href="/css/components/slider.almost-flat.min.css">
<link rel="stylesheet" type="text/css" href="/css/components/slider.css">
<link rel="stylesheet" type="text/css" href="/css/components/slider.gradient.css">
<link rel="stylesheet" type="text/css" href="/css/components/slider.gradient.min.css">
<link rel="stylesheet" type="text/css" href="/css/components/slider.min.css">

@stop

@section('location') Home @stop