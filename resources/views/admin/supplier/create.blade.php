@extends('admin')

@section('content')
<h2>New Supplier Record</h2>
<hr>
{!! Form::open(['route'=>'supplierStore', 'method'=>'post', 'class'=>'uk-form uk-form-stacked']) !!}
@include('admin.supplier._form', ['btnCaption'=>'Add New Record'])
{!! Form::close() !!}
@stop

@section('location') Supplier @stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/components/datepicker.gradient.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/components/form-select.gradient.min.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('/js/components/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/components/form-select.min.js') }}"></script>
@stop