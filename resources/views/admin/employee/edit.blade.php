@extends('admin')

@section('content')
{!! Form::model($employee, ['route'=>['employeeUpdate', 'id'=>$employee->employee_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}
                            @include('admin.employee._form', ['btnCaption'=>'Update Record'])
                            {!! Form::close() !!}
@stop

@section('location') Employee @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>
@stop