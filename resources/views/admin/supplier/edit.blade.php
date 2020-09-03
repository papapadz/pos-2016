@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Edit Supplier Details - {{ $supplier->companyname }}</h2>

                        <hr>

                        <div style="padding-left: 15px; padding-right: 15px; margin-bottom: 15px;">
                            {!! Form::model($supplier, ['route'=>['supplierUpdate', 'id'=>$supplier->supplier_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}
                            @include('admin.supplier._form', ['btnCaption'=>'Update Supplier Record'])
                            {!! Form::close() !!}
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

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