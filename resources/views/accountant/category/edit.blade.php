@extends('accountant')

@section('content')

 <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Edit Category Details - {{ $category->categoryname }}</h2>

                <hr>

                {!! Form::model($category, ['route'=>['accountantCategoryUpdate', 'id'=>$category->category_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}

                    @include('accountant.category._form', ['btnCaption'=>'Update Category Details'])

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
</div>

@stop

@section('location') Delivery @stop

@section('css')

@stop

@section('js')

@stop