@extends('admin')

@section('content')

{!! Form::open(['route'=>'employeeStore', 'method'=>'post', 'class'=>'uk-form uk-form-stacked']) !!}
                @include('admin.employee._form', ['btnCaption'=>'Add New Record '])
                {!! Form::close() !!}
@stop

@section('location') Employee @stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/components/datepicker.gradient.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/components/form-select.gradient.min.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('/js/components/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/components/form-select.min.js') }}"></script>
@stop