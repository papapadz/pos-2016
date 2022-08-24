@extends('admin')

@section('content')

<div class="uk-grid">
    <div class="uk-width-1-1">

        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right uk-margin-small-top">
            {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
            Date
            {!! Form::text('deliverydate', $selDate, ['id' => 'datefilter']) !!}
            {!! Form::select('supplier_id', [''=>'--Suppliers--'] + $suppliers, $selSupplier) !!}
            {!! Form::button('Filter ', ['type'=>'submit', 'class'=>'uk-button uk-button-primary uk-button-small','uk-icon="icon: search"']) !!}
            |
            <a class="uk-button uk-button-small" style="background: limegreen; color: white;" href="{{ url('admin/delivery/create') }}" uk-icon="icon: plus-circle">New </a>
            {!! Form::close() !!}
        </div>

        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
            <table class="uk-table uk-table-hover uk-table-striped">
                <thead>
                    <tr style="background-color: #464646; color: #fff;">
                        <th width="50">&nbsp;</th>
                        <th width="200">Order Number</th>
                        <th>Date of Delivery</th>
                        <th>Supplier</th>
                        <th style="text-align: center">Total Cost</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                @if(count($deliveries) > 0)
                    <tbody>
                    @foreach($deliveries as $delivery)
                        <tr>
                            <td>&nbsp;</td>
                            <td><a href="{{ route('deliveryDetailsShow', $delivery->delivery_id) }}">{{ $delivery->order_number }}</a></td>
                            <td>{{ substr($delivery->deliverydate, 0, 10) }}</td>
                            <td>{{ $delivery->mySupplier->companyname }}</td>
                            <td style="text-align: right">{{ number_format($delivery->totalcost, 2) }}</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><i>{{ count($deliveries) }} - Entry found</i></td>
                        </tr>
                    </tfoot>
                @else
                    <tfoot>
                        <tr>
                            <td colspan="8"><i>No records found</i></td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>
        <div>
            @include('paginator', ['paginator' => $deliveries])
        </div>


    </div>
</div>

    <div class="uk-modal" id="supplier-modal">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header"><h2>Select Supplier</h2></div>
            <div>
                <table class="uk-form" width="100%">
                    <tr>
                        <td>{!! Form::text('search-supplier', null, ['id'=>'search-supplier', 'class'=>'uk-width-1-1', 'placeholder'=>'Search Supplier']) !!}</td>
                    </tr>
                    <tr>
                        <td>
                            {!! Form::select('suppliers-list', $suppliers, null, ['id'=>'suppliers-list', 'class'=>'uk-width-1-1', 'multiple', 'size'=>'10']) !!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <a href="#" class="uk-button uk-button-primary uk-modal-close" id="btn-update-supplier">Select Supplier</a>
                <a href="#" class="uk-button uk-button-danger uk-modal-close">Cancel</a>
            </div>
        </div>
    </div>

    <div class="uk-modal" id="update-cost-modal">
        <div class="uk-modal-dialog uk-width-1-2">
            <div class="uk-modal-header"><h2>Update Product Cost</h2></div>

            {!! Form::open(['class'=>'uk-form']) !!}
            <div class="uk-form-row">
                <div class="uk-form-controls">
                    {!! Form::select('updateCostOption', ['1'=>'Update', '2'=>'New'], 1, ['id'=>'update-cost-option']) !!}
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-form-controls uk-width-1-3" >
                    {!! Form::text('newUnitCost', null, ['id'=>'new-unit-cost', 'class'=>'uk-width-1-1']) !!}
                </div>
            </div>
            {!! Form::close() !!}


            <div class="uk-modal-footer uk-text-right">
                <a href="#" class="uk-button uk-button-primary uk-modal-close" id="btn-update-cost">Save Cost</a>
                <a href="#" class="uk-button uk-button-danger uk-modal-close">Cancel</a>
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
            var selectedSupplier = $('#supplier_id').val();
            $( "#datefilter" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $.ajax({
                url: '/ajax/fetch/key/supplier',
                method: 'get',
                async: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    supplier: selectedSupplier
                }
            }).success(function(r){
                $('#supplier-name').empty().html(r);
            });

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
                    if(r)
                    {
                        $('#products').empty().html(r).prop('disabled', false);
                    }
                });
            });

            $('#category').change(function(){
                var category = $(this).val();
                $.ajax({
                    url: '/ajax/fetch/category/products',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        category: category
                    }
                }).success(function(r){
                    if(r)
                    {
                        $('#products-list').empty().html(r).prop('disabled', false);
                    }
                    else
                    {
                        $('#products-list').empty().prop('disabled', true);
                    }
                });
            });

            $('#product').change(function(){
                var product = $('#product').val();

                $.ajax({
                    url: '/ajax/fetch/product/cost',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product: product
                    }
                }).success(function(r){
                    $('#deliveryprice').val(r);

                    $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', false);
                    $('#qty').val('1');
                });
            });

            $('#products-list').change(function(){
                $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', true);

                var productlist = $('#products-list option:selected').text();

                // get product list
                $.ajax({
                    url: '/ajax/fetch/delivery/products',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        productlist: productlist
                    }
                }).success(function(r){
                    $('#product').empty().html(r);

                    var product = $('#product').val();

                    $.ajax({
                        url: '/ajax/fetch/product/cost',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            product: product
                        }
                    }).success(function(r){
                        $('#deliveryprice').val(r);

                        $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', false);
                        $('#qty').val('1');
                    });
                });
            });

            $('#search-products').keyup(function(){
                var key = $(this).val();
               $.ajax({
                    url: '/ajax/fetch/key/products',
                   method: 'get',
                    asunc: false,
                   data: {
                       _token: '{{ csrf_token() }}',
                       key: key
                   }
               }).success(function(r){
                   if(r)
                   {
                       $('#products-list').empty().html(r);
                   }
               });
            });

            $('#btn-update-supplier').click(function(){
                var selectedSupplier = $('#suppliers-list').val();
                $('#supplier_id').val(selectedSupplier);

                $.ajax({
                    url: '/ajax/fetch/key/supplier',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        supplier: selectedSupplier
                    }
                }).success(function(r){
                    $('#supplier-name').empty().html(r);
                });
            });

            $('#btn-process-deliveries').click(function(){
                var supplier = $('#supplier_id').val();
                if(supplier == '' || supplier == null)
                {
                    alert('Please select supplier first!');
                    return false;
                }
                else
                {
                    $('#frm-process-deliveries').submit();
                }
            });

            $('#btn-update-cost').click(function(){
                var product = $('#product').val();
                var newUnitCost = $('#new-unit-cost').val();
                var option = $('#update-cost-option').val();

                if(option == 1)
                {
                    // update
                    $.ajax({
                        url: '/ajax/update/product/unitcost',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            product: product,
                            newUnitCost: newUnitCost
                        }
                    }).success(function(r){
                        if(r == 1)
                        {
                            $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', true);
                            $('#deliveryprice').val('');
                            $('#qty').val('');
                            $('#products-list').val('');
                            window.location.reload();
                        }
                        else
                        {
                            return false;
                        }
                    });
                }
                else
                {
                    // create new
                    $.ajax({
                        url: '/ajax/store/product/unitcost',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            product: product,
                            cost: newUnitCost

                        }
                    }).success(function(r){
                        if(r == 1)
                        {
                            $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', true);
                            $('#deliveryprice').val('');
                            $('#qty').val('');
                            $('#products-list').val('');
                            window.location.reload();
                        }
                        else
                        {
                            return false;
                        }
                    });
                }

            })

            $('#qty').keyup(function(){
                $('#qty, #deliveryprice, #btn-add, #btn-cost').prop('disabled', true);

                var newQty = $(this).val();
                var product = $('#product').val();

                $.ajax({
                    url: '/ajax/fetch/product/cost',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product: product
                    }
                }).success(function(r){
                    var price = r;
                    var newPrice = parseFloat(newQty) * parseFloat(price);

                    if(newPrice > 0)
                    {
                        $('#deliveryprice').val(newPrice);
                    }
                    else
                    {
                        $('#deliveryprice').val(0);
                    }

                    $('#qty, #deliveryprice, #btn-add, #btn-cost').prop('disabled', false);
                });
            });
        });
    </script>
@stop