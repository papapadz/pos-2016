@extends('admin')

@section('content')
<div uk-grid>
    <div class="uk-width-1-2"><h2>New Product Record</h2></div>
</div>
<hr>
{!! Form::open(['route'=>'productStore', 'method'=>'post', 'class'=>'uk-form uk-form-stacked']) !!}
@include('admin.products._form', ['btnCaption'=>'Add New Record'])
{!! Form::close() !!}
@stop

@section('location') Supplier @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>
@stop