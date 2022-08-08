@extends('admin')

@section('content')

<div class="uk-slidenav-position" data-uk-slider>
    <div style="background-color: #e2e2e2; padding: 8px;">
        <img style="max-width: 100%" src="{{ asset('img/banner.png') }}"></li>
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