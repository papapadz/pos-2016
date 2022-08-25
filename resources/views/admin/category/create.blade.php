@extends('admin')

@section('content')
<h2>New Category Details</h2>

                        <hr>
                        {!! Form::open(['route'=>'categoryStore', 'class'=>'uk-form uk-form-stacked']) !!}
                        @include('admin.category._form', ['btnCaption'=>'Add New Record'])
                        {!! Form::close() !!}
@stop

@section('location') Delivery @stop

@section('css')
@stop

@section('js')
@stop