@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid uk-grid-collapse">

                <div class="uk-width-4-10" style="padding-left: 5px;">

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary" style="background-color: #4E5255; color: #fff;">
                        <div class="uk-text-bold">Delivery Management</div>
                        <hr>
                        <div>

                            {!! Form::open(['route'=>'deliverySetStore', 'class'=>'uk-form']) !!}
                            <div class="uk-form-row">
                                <div class="uk-form-controls uk-text-right">
                                    {!! Form::text('searchProducts', null, ['id'=>'search-products', 'class'=>'uk-width-1-1', 'placeholder'=>'Searh key']) !!}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::select('category_id', $categories, null, ['id'=>'category', 'class'=>'uk-width-1-1']) !!}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::select('products-list', $products, null, ['id'=>'products-list', 'class'=>'uk-width-1-1', 'multiple', 'size'=>'10']) !!}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::select('product_id', ['0'=>'----'], null, ['id'=>'product', 'class'=>'uk-width-1-1', 'disabled']) !!}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    <div class="uk-grid">
                                        <div class="uk-width-1-4" style="padding-top: 5px;">Quantity</div>
                                        <div class="uk-width-3-4" style="padding-top: 5px;">
                                            {!! Form::text('qty', null, ['id'=>'qty', 'class'=>'uk-width-1-2', 'placeholder'=>'Quantity', 'disabled']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    <div class="uk-grid">
                                        <div class="uk-width-1-4" style="padding-top: 5px;">Unit Cost</div>
                                        <div class="uk-width-3-4" style="padding-top: 5px;">
                                            {!! Form::text('deliveryprice', null, ['id'=>'deliveryprice', 'class'=>'uk-width-1-2', 'placeholder'=>'Unit Cost', 'disabled']) !!}
                                            {!! Form::button('Update Cost', ['data-uk-modal'=>"{target:'#update-cost-modal'}", 'id'=>'btn-cost', 'class'=>'uk-button uk-button-primary', 'disabled']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::button('Add Item Delivery', ['type'=>'submit', 'id'=>'btn-add', 'class'=>'uk-button uk-button-primary uk-width-1-1 uk-button-large uk-text-bold', 'disabled']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>

                </div>

                <div class="uk-width-6-10">

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                        <div class="uk-grid">
                            <div class="uk-width-3-4">
                                <div class="uk-text-success uk-text-bold uk-text-left" style="margin-left: 20px;">
                                    
                                    {!! Form::open(['route'=>'deliveryStore', 'id'=>'frm-process-deliveries', 'class'=>'uk-form']) !!}
                                    {!! Form::text('deliverydate', date('Y-m-d'), ['class'=>'uk-width-1-4', 'id'=>'deliverydate', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                                    {!! Form::text('order_number', null, ['placeholder'=>'Order Number', 'class'=>'uk-width-1-3']) !!}
                                    
                                </div>
                                <div class="uk-text-success uk-text-bold uk-text-left" style="margin-left: 20px;">
                                    <a href="#supplier-modal" data-uk-modal class="uk-button"><span id="supplier-name">Supplier</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (Session::has('code'))
                        @if(Session::get('code') == 1)
                            <div class="uk-alert uk-alert-success uk-animation-slide-top">Delivery Transaction Complete!</div>
                        @endif
                    @endif

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top uk-margin-small-bottom" style="min-height: 250px; background-color: #fafafa;">
                        <table class="uk-table uk-table-hover uk-table-condensed">
                            <thead>
                            <tr style="background-color: #4E5255; color: #fff;">
                                <th>&nbsp;</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th style="text-align: right">Unitcost</th>
                                <th style="text-align: right" width="70">Subtotal <i class="uk-icon-rub uk-text-small"></i></th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>


                                @if(count($deliverysets) > 0)
                                    <tbody>
                                        @foreach($deliverysets as $deliveryset)
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>{{ $deliveryset->myProduct->myCategory->categoryname }}</td>
                                                <td>{{ $deliveryset->myProduct->productname }}</td>
                                                <td>{{ $deliveryset->qty }}</td>
                                                <td style="text-align: right">{{ number_format($deliveryset->unitcost, 2) }}</td>
                                                <td style="text-align: right">{{ number_format($deliveryset->deliverycost, 2) }}</td>
                                                <td>&nbsp;</td>
                                                <td width="10">
                                                    <a href="{{ route('destroyDelivery-set', ['id'=>$deliveryset->deliveryset_id]) }}" class="uk-button uk-button-danger uk-button-mini del-rec"><i class="uk-icon-times"></i></a>
                                                </td>
                                            </tr>

                                        @endforeach
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr style="background-color: #F0F0F0;">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td colspan="2" class="uk-text-right"><strong>Total Amount</strong></td>
                                                <td style="text-align: right">{{ number_format($totDeliveryCost, 2) }}</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        @else
                                            <tr style="background-color: #F0F0F0;">
                                                <td colspan="8"><i class="uk-text-small">Ready...</i></td>
                                            </tr>
                                    </tbody>
                                @endif
                        </table>

                    </div>

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-bottom uk-text-right">
                        {!! Form::open(['route'=>'deliveryStore', 'id'=>'frm-process-deliveries', 'class'=>'uk-form']) !!}
                        {!! Form::hidden('supplier_id', null, ['id'=>'supplier_id', 'readonly']) !!}
                        @if(count($deliverysets) > 0)
                            <div class="uk-text-right">
                                {!! Form::text('date_received', date('Y-m-d'), ['class'=>'uk-width-1-4', 'id'=>'date_received', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                                {!! Form::button('Process Deliveries', ['id'=>'btn-process-deliveries', 'class'=>'uk-button uk-button-primary']) !!}
                            </div>
                        @endif
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right uk-margin-small-top">
                {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                {!! Form::text('deliverydate', $selDate, ["data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
                {!! Form::select('supplier_id', [''=>'--Suppliers--'] + $suppliers, $selSupplier) !!}
                {!! Form::button('Filter', ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
                {!! Form::close() !!}
            </div>

            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">
                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                        <tr style="background-color: #464646; color: #fff;">
                            <th width="50">&nbsp;</th>
                            <th width="200">Date of Delivery</th>
                            <th width="200">Date Received</th>
                            <th width="200">Order Number</th>
                            <th>Supplier</th>
                            <th style="text-align: center">Total Cost</th>
                            <th>&nbsp;</th>
                        </tr>"
                    </thead>

                    @if(count($deliveries) > 0)
                        <tbody>
                        @foreach($deliveries as $delivery)
                            <tr>
                                <td>&nbsp;</td>
                                <td><a href="{{ route('deliveryDetailsShow', $delivery->delivery_id) }}"</a>{{ substr($delivery->deliverydate, 0, 10) }}</td>
                                <td>{{ substr($delivery->date_received, 0, 10) }}</td>
                                <td>{{ $delivery->order_number }}</td>
                                <td>{{ $delivery->mySupplier->companyname }}</td>
                                <td style="text-align: center">{{ number_format($delivery->totalcost, 2) }}</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8"><i>{{ count($deliveries) }} - Delivery record found</i></td>
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
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>
   <script type="text/javascript">
        $(function(){
            var selectedSupplier = $('#supplier_id').val();

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