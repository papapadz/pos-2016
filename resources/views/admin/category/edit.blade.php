@extends('admin')

@section('content')
<h2>Edit Category Details - {{ $category->categoryname }}</h2>
<hr>
{!! Form::model($category, ['route'=>['categoryUpdate', 'id'=>$category->category_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}
                            @include('admin.category._form', ['btnCaption'=>'Update Record'])
                            {!! Form::close() !!}
@stop

@section('location') Delivery @stop

@section('css')

@stop

@section('js')

@stop