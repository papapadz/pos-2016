@extends('admin')

@section('content')

<div class="uk-grid uk-grid-collapse">
    <div class="uk-width-4-10" style="padding-left: 5px;">

        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
            <div>

                {!! Form::open(['route'=>'deliverySetStore', 'class'=>'uk-form']) !!}
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">Search</div>
                            <div class="uk-width-3-4" style="padding-top: 5px;">
                                {!! Form::text('searchProducts', null, ['id'=>'search-products', 'class'=>'uk-width-1-1 uk-input', 'placeholder'=>'ex. Biscuit']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">Category</div>
                            <div class="uk-width-3-4" style="padding-top: 5px;">
                                {!! Form::select('category_id', $categories, null, ['id'=>'category', 'class'=>'uk-width-1-1 uk-select']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        {!! Form::select('products-list', $products, null, ['id'=>'products-list', 'class'=>'uk-width-1-1 uk-select', 'multiple', 'size'=>'10']) !!}
                    </div>
                </div>
                <div class="uk-form-row" hidden>
                    <div class="uk-form-controls">
                        {!! Form::select('product_id', ['0'=>'----'], null, ['id'=>'product', 'class'=>'uk-width-1-1 uk-select', 'disabled']) !!}
                    </div>
                </div>
                <div class="uk-form-row uk-background-muted">
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">SRP (PHP)</div>
                            <div class="uk-width-3-4" style="padding-top: 5px;">
                                {!! Form::text('unitprice', null, ['id'=>'unitprice', 'class'=>'uk-width-1-2 uk-input', 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">Delivery Price (PHP)</div>
                            <div class="uk-width-3-4" style="padding-top: 5px;">
                                {!! Form::text('deliveryunitprice', '0.00', ['id'=>'deliveryunitprice', 'class'=>'uk-width-1-2 uk-form-danger uk-input', 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">Quantity</div>
                            <div class="uk-width-3-4" style="padding-top: 5px;">
                                {!! Form::text('qty', null, ['id'=>'qty', 'class'=>'uk-width-1-2 uk-input', 'placeholder'=>'Quantity', 'disabled','min'=>1]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">Sub Total (PHP)</div>
                            <div class="uk-width-3-4" style="padding-top: 5px;">
                                {!! Form::text('deliveryprice', null, ['id'=>'deliveryprice', 'class'=>'uk-width-1-2 uk-input', 'placeholder'=>'Unit Cost', 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        {!! Form::button('Add', ['type'=>'submit', 'id'=>'btn-add', 'class'=>'uk-button uk-button-primary uk-width-1-1 uk-button-large uk-text-bold', 'disabled']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    </div>

    @if(count($deliverysets) > 0)
    <div class="uk-card uk-card-body uk-width-1-1">
        {!! Form::open(['route'=>'deliveryStore', 'id'=>'frm-process-deliveries', 'class'=>'uk-form']) !!}
            
            <div style="padding-left:10px;" class="uk-form-row">
                <div class="uk-form-controls">
                    <div class="uk-grid">
                        <div>Delivery Date: {!! Form::text('deliverydate', '', ['id'=>'deliverydate']) !!}</div>
                        <div>
                            Supplier: {!! Form::select('suppliers-list', $suppliers, null, ['id'=>'suppliers-list', 'required']) !!}
                            {!! Form::text('supplier_id',null,['id'=>'supplier_id','hidden']) !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="uk-panel uk-margin-small-top uk-margin-small-bottom" style="min-height: 250px; background-color: #fafafa; padding-left:10px;">
                <table class="uk-table uk-table-hover uk-table-condensed">
                    <thead>
                    <tr style="background-color: #4E5255; color: #fff;">
                        <th>&nbsp;</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th style="text-align: right">Delivery Price</th>
                        <th style="text-align: right" width="70">Subtotal</th>
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
                                        <td>
                                            <a href="{{ route('destroyDelivery-set', ['id'=>$deliveryset->deliveryset_id]) }}" class="uk-button uk-button-danger uk-button-small del-rec" uk-icon="icon: close"></a>
                                        </td>
                                    </tr>
    
                                @endforeach
                                    <tr style="background-color: #F0F0F0;">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="2" class="uk-text-right"><strong>Total Amount (PHP)</strong></td>
                                        <td style="text-align: right">{{ number_format($totDeliveryCost, 2) }}</td>
                                        <td>&nbsp;</td>
                                    </tr>
                        @else
                                    <tr style="background-color: #F0F0F0;">
                                        <td colspan="7" class="uk-text-small uk-text-danger"><i class="uk-icon-info"></i> No items yet</td>
                                    </tr>
                            </tbody>
                        @endif
                </table>
            </div>
    
            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-bottom uk-text-right">
                @if(count($deliverysets) > 0)
                    <div class="uk-text-right">
                        
                        {!! Form::button('Submit', ['id'=>'btn-process-deliveries', 'class'=>'uk-button uk-button-primary']) !!}
                    </div>
                @endif
            </div>
            {!! Form::close() !!}
    </div>
    @endif
</div>

    {{-- <div class="uk-modal" id="supplier-modal">
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
    </div> --}}

@stop

@section('location') Delivery @stop

@section('css')
@stop

@section('js')
   <script type="text/javascript">
        $(function(){
            var selectedSupplier = $('#supplier_id').val();
            $( "#deliverydate" ).datepicker({ dateFormat: 'yy-mm-dd' });
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

            // $('#supplier').change(function(){
            //     var supplier = $(this).val();
            //     $.ajax({
            //         url: '/ajax/fetch/products',
            //         method: 'get',
            //         async: false,
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             supplier: supplier
            //         }
            //     }).success(function(r){
            //         if(r)
            //         {
            //             $('#products').empty().html(r).prop('disabled', false);
            //         }
            //     });
            // });

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
                    $('#deliveryprice').val(parseFloat(r).toFixed(2));
                    $('#qty, #deliveryprice, #btn-cost, #product, #unitprice, #deliveryunitprice').prop('disabled', false);
                    $('#qty').val('1');
                });
            });

            $('#products-list').change(function(){
                $('#qty, #deliveryprice, #btn-add, #btn-cost, #product, #unitprice, #deliveryunitprice').prop('disabled', true);

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
                        $('#deliveryprice').val(parseFloat(r).toFixed(2));

                        $('#unitprice').val(parseFloat(r).toFixed(2));
                        $('#qty, #deliveryprice, #btn-cost, #product, #unitprice, #deliveryunitprice').prop('disabled', false);
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
                       $('#products-list').empty().html(r).prop('disabled', false);
                   }
               });
            });

            // $('#btn-update-supplier').click(function(){
            //     var selectedSupplier = $('#suppliers-list').val();
            //     $('#supplier_id').val(selectedSupplier);

            //     $.ajax({
            //         url: '/ajax/fetch/key/supplier',
            //         method: 'get',
            //         async: false,
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             supplier: selectedSupplier
            //         }
            //     }).success(function(r){
            //         $('#supplier-name').empty().html(r);
            //     });
            // });

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

            // $('#btn-update-cost').click(function(){
            //     var product = $('#product').val();
            //     var newUnitCost = $('#new-unit-cost').val();
            //     var option = $('#update-cost-option').val();

            //     if(option == 1)
            //     {
            //         // update
            //         $.ajax({
            //             url: '/ajax/update/product/unitcost',
            //             method: 'get',
            //             async: false,
            //             data: {
            //                 _token: '{{ csrf_token() }}',
            //                 product: product,
            //                 newUnitCost: newUnitCost
            //             }
            //         }).success(function(r){
            //             if(r == 1)
            //             {
            //                 $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', true);
            //                 $('#deliveryprice').val('');
            //                 $('#qty').val('');
            //                 $('#products-list').val('');
            //                 window.location.reload();
            //             }
            //             else
            //             {
            //                 return false;
            //             }
            //         });
            //     }
            //     else
            //     {
            //         // create new
            //         $.ajax({
            //             url: '/ajax/store/product/unitcost',
            //             method: 'get',
            //             async: false,
            //             data: {
            //                 _token: '{{ csrf_token() }}',
            //                 product: product,
            //                 cost: newUnitCost

            //             }
            //         }).success(function(r){
            //             if(r == 1)
            //             {
            //                 $('#qty, #deliveryprice, #btn-add, #btn-cost, #product').prop('disabled', true);
            //                 $('#deliveryprice').val('');
            //                 $('#qty').val('');
            //                 $('#products-list').val('');
            //                 window.location.reload();
            //             }
            //             else
            //             {
            //                 return false;
            //             }
            //         });
            //     }

            // })

            // $('#qty').change(function(){
            //     $('#qty, #deliveryprice, #btn-add, #btn-cost').prop('disabled', true);

            //     var newQty = $(this).val();
            //     var product = $('#product').val();

            //     $.ajax({
            //         url: '/ajax/fetch/product/cost',
            //         method: 'get',
            //         async: false,
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             product: product
            //         }
            //     }).success(function(r){
            //         var price = r;
            //         var newPrice = parseFloat(newQty) * parseFloat(price);

            //         if(newPrice > 0)
            //         {
            //             $('#deliveryprice').val(newPrice);
            //         }
            //         else
            //         {
            //             $('#deliveryprice').val(0);
            //         }

            //         $('#qty, #deliveryprice, #btn-add, #btn-cost').prop('disabled', false);
            //     });
            // });

            $('#qty').change(function() {
                var delprice = parseFloat($('#deliveryunitprice').val())
                if(delprice>0) {
                    var newTotal = $('#deliveryunitprice').val() * $('#qty').val()
                    $('#deliveryprice').val(parseFloat(newTotal).toFixed(2))
                } else
                    alert('Check delivery price!')
                
            })

            $('#deliveryunitprice').change(function() {
                var delprice = parseFloat($('#deliveryunitprice').val())
                var srp = parseFloat($('#unitprice').val())

                if(delprice>srp)
                    $('#unitprice').prop('class','uk-width-1-2 uk-form-danger uk-input')
                else
                    $('#unitprice').prop('class','uk-width-1-2 uk-input')

                if(delprice>0) {
                    $('#btn-add').prop('disabled', false);
                    $(this).prop('class','uk-width-1-2 uk-input')
                    var newCost = delprice * $('#qty').val()
                    $('#deliveryprice').val(parseFloat(newCost).toFixed(2))
                } else {
                    $('#btn-add').prop('disabled', false);
                    $(this).prop('class','uk-width-1-2 uk-form-danger uk-input')
                }                
            })

            $('#suppliers-list').change(function() {
                $('#supplier_id').val($(this).val())
            })
        });
    </script>
@stop