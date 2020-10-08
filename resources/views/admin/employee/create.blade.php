@extends('admin')

@section('content')

    <div style="background-color: #ffa200; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>New Employee Details</h2>

                        <hr>

                        <div style="padding-left: 15px; padding-right: 15px; margin-bottom: 15px;">
                            {!! Form::open(['route'=>'employeeStore', 'method'=>'post', 'class'=>'uk-form uk-form-stacked']) !!}
                            @include('admin.employee._form', ['btnCaption'=>'Create Employee Record'])
                            {!! Form::close() !!}
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

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