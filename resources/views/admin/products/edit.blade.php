@extends('admin')

@section('content')
<div uk-grid>
    <div class="uk-width-1-2"><h2>Update Product Record</h2></div>
</div>
<hr>
{!! Form::model($product, ['route'=>['productsUpdate', 'id'=>$product->product_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}
                            @include('admin.products._form', ['btnCaption'=>'Update'])
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