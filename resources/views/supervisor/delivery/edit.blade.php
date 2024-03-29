@extends('supervisor')

@section('content')

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Edit Delivery Details - {{ $delivery->myDetails->myProduct->productname }}</h2>

                <hr>

                {!! Form::model($deliveryArr, ['route'=>['supervisorDeliveryUpdate', 'id'=>$delivery->delivery_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}

                    @include('supervisor.delivery._form', ['btnCaption'=>'Update Delivery Details'])

                {!! Form::close() !!}

            </div>

        </div>
    </div>

@stop

@section('location') Delivery @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>

    <script type="text/javascript">
        $(function(){
            $('#supplier').change(function(){
                var supplier = $(this).val();

                $.ajax({
                    url: '/ajax/fetch/products',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        supplier: supplier
                    }
                }).success(function(r){
                    $('#product').empty().html(r);
                });
            });
        })
    </script>
@stop