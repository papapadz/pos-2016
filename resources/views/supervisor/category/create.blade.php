@extends('supervisor')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>New Category Details</h2>

                        <hr>

                        <div style="padding-left: 15px; padding-right: 15px; margin-bottom: 15px;">
                            {!! Form::open(['route'=>'supervisorCategoryStore', 'class'=>'uk-form uk-form-stacked']) !!}
                            @include('supervisor.category._form', ['btnCaption'=>'Create Category Details'])
                            {!! Form::close() !!}
                        </div>

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