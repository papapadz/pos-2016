@extends('admin')

@section('content')

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Edit Delivery Details - {{ $delivery->myDetails->myProduct->productname }}</h2>

                <hr>

                {!! Form::model($deliveryArr, ['route'=>['deliveryUpdate', 'id'=>$delivery->delivery_id], 'method'=>'patch', 'class'=>'uk-form uk-form-stacked']) !!}

                    @include('admin.delivery._form', ['btnCaption'=>'Update'])

                {!! Form::close() !!}

            </div>

        </div>
    </div>

@stop

@section('location') Delivery @stop

@section('css')
@stop

@section('js')

    <script type="text/javascript">
        $(function(){
            $( "#datefilter" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $('#supplier').change(function(){
                var supplier = $(this).val();

                $.ajax({
                    url: '{{ url("/ajax/fetch/products") }}',
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