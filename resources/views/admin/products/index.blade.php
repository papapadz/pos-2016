@extends('admin')

@section('content')

<div class="uk-grid">
    <div class="uk-width-1-1">

        <div style="margin-top:15px;">
            <div uk-grid>
                <div class="uk-width-1-2"><h2>Product List</h2></div>
                <div class="uk-width-1-2 uk-text-right">
                    {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                    {!! Form::label('Search') !!}
                    {!! Form::text('skey', $skey, ['placeholder' => 'Supplier']) !!}
                    {!! Form::select('status', ['0'=>'Active', '1'=>'Not Active'], $status, ['id'=>'status']) !!}
                    
                    {!! Form::button('Search ', ['type'=>'submit', 'class'=>'uk-button uk-button-primary uk-button-small', 'uk-icon="icon: search"']) !!}
                    
                    {!! Form::open(['class' => 'uk-form','method'=>'get', 'id'=>'prod-status']) !!}
                    |
                    <a class="uk-button uk-button-small" style="background: limegreen; color: white;" href="{{ route('productsCreate') }}" uk-icon="icon: plus-circle">New </a>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                    <tr>
                        <th style="background-color: #464646; color: #fff;">Category</th>
                        <th style="background-color: #464646; color: #fff;">Product Name</th>
                        <th style="background-color: #464646; color: #fff; text-align: center;">Price</th>
                        <th style="background-color: #464646; color: #fff; text-align: center;" width="150">Stock</th>
                        <th style="background-color: #464646; color: #fff;" width="130" class="uk-text-center">Action</th>
                    </tr>
                    </thead>

                    @if(count($products) > 0)
                        <tbody>

                        @foreach($products as $product)

                            <tr style="{{ ($product->stock <= $product->reorderlimit) ? 'background-color: #ffaaaa;' : '' }}">
                                <td>{{ $product->myCategory->categoryname }}</td>
                                <td>{{ $product->productname }}</td>
                                <td style="text-align: center;">{{ number_format($product->unitprice, 2) }}</td>
                                <td style="text-align: center;">{{ $product->stock }}</td>
                                <td class="uk-text-center">
                                {{-- @if($product->status == 0)
                                    <a href="{{ route('productStatus', ['id'=>$product->product_id]) }}" class="uk-button uk-button-mini"><i class="uk-icon-mail-forward"></i></a>
                                @else
                                     <a href="{{ route('productStatus', ['id'=>$product->product_id]) }}" class="uk-button uk-button-mini"><i class="uk-icon-mail-reply"></i></a>
                                @endif --}}
                                    {{-- <a href="#reorder-modal" id="{{ $product->product_id }}" data-uk-modal class="uk-button uk-button-primary uk-button-mini reorder-product"><i class="uk-icon-refresh"></i></a> --}}
                                    <a href="{{ route('productsEdit', ['id'=>$product->product_id]) }}" class="uk-button uk-button-primary uk-button-small" uk-icon="icon: pencil"></a>
                                    <button class="uk-button uk-button-danger uk-button-small del-rec" id="{{ $product->product_id }}" uk-icon="icon: close"></button>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="7"><i>{{ count($products) }} - Record found</i></td>
                        </tr>
                        </tfoot>
                    @else
                        <tfoot>
                        <tr>
                            <td colspan="7"><i>No record found.</i></td>
                        </tr>
                        </tfoot>
                    @endif

                </table>

                <div>
                    @include('paginator', ['paginator' => $products])
                </div>

            </div>
        </div>

    </div>
</div>


    <!-- This is the modal -->
    <div id="reorder-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <h2>Product Restock</h2>
            <hr>

            {!! Form::open(['url'=>'admin/delivery/restock', 'method'=>'get', 'class'=>'uk-form uk-form-horizontal']) !!}

            {!! Form::hidden('product_id', null, ['id'=>'reorder-product']) !!}

            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Restock Date</label>
                <div class="uk-form-controls">
                    {!! Form::text('deliverydate', date('Y-m-d'), ["data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-s-it" class="uk-form-label">Quantity</label>
                <div class="uk-form-controls">
                    {!! Form::text('qty', null) !!}
                </div>
            </div>

            <hr>

            <div class="uk-text-right">
                {!! Form::button('Confirm Stock Update', ['type'=>'submit', 'class'=>'uk-button uk-button-primary', 'id'=>'restock-confirm']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop

@section('location') Products @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>

  <script type="text/javascript">
        $(function(){
            $('.del-rec').click(function(){
                var r = confirm('Are you sure you want to delete this record?');
                var product = this.id;
                if(!r){
                    return false;
                }
                else
                {
                    var r = confirm('Other related records will also be deleted, proceed?');

                    if(!r){
                        return false;
                    }
                    else
                    {
                        $.ajax({
                            url: '/admin/products/destroy',
                            method: 'get',
                            async: false,
                            data: {
                                _token: '{{ csrf_token() }}',
                                product: product
                            }
                        }).success(function(r){
                            if(r == 0)
                            {
                                alert('Record can not be deleted!');
                            }
                            else
                            {
                                window.location.reload();
                            }
                        });
                    }
                }
            });

            $('.reorder-product').click(function(){
                var product = this.id;
                $('#reorder-product').val(product);
            });

            $('#status').change(function(){
                $('#prod-status').submit();
            });
        });
    </script>
@stop