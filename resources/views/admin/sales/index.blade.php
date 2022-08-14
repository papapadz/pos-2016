@extends('admin')

@section('content')

    @if(Session::has('success'))
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ Session::get('success')}}</p>
    </div>
    @endif
    <div style="padding: 5px; background:gainsboro">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid uk-grid-collapse">

                <div class="uk-width-4-10" style="padding-right: 5px;">

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary">
                        {{-- <div class="uk-text-bold  uk-text-right">
                            <a href="{{ route('productsIndex')}}" class="uk-button"><i class="uk-icon-shopping-cart"></i></a></div>
                        <hr> --}}
                        <div>

                            {!! Form::open(['route'=>'ordersCreate', 'class'=>'uk-form']) !!}
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    <label>Search Item</label>
                                    {!! Form::text('key', null, ['id'=>'key', 'class'=>'uk-width-1-1', 'placeholder'=>'ex. Biscuit']) !!}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::select('category_id', $categories, null, ['id'=>'category', 'class'=>'uk-width-1-1']) !!}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::select('productList', $products, null, ['id'=>'product-list', 'class'=>'uk-width-1-1', 'multiple', 'size'=>'10']) !!}

                                    
                                </div>
                            </div>
                            <div class="uk-form-row" hidden>
                                <div class="uk-form-controls">
                                    {!! Form::select('product_id', ['0'=>'----'], 0, ['class'=>'uk-width-1-1','id'=>'product', 'disabled']) !!}
                                </div>
                            </div>
                            <input type="number" value="1" name="qty" hidden>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    <div class="uk-grid">
                                        <div class="uk-width-1-4" style="padding-top: 5px;"><i class="uk-icon-shopping-cart"></i> Stock</div>
                                        <div class="uk-width-3-4" style="padding-top: 5px;">
                                            <label id="onhand">----</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- 
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    <div class="uk-grid">
                                        <div class="uk-width-1-4" style="padding-top: 5px;">Quantity</div>
                                        <div class="uk-width-3-4">
                                            {!! Form::text('qty', null, ['id'=>'qty', 'placeholder'=>'Quantity', 'disabled']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>  --}}
                            <div class="uk-form-row" hidden>
                                <div class="uk-form-controls">
                                    <div class="uk-grid">
                                        <div class="uk-width-1-4" style="padding-top: 5px;">Unit Price</div>
                                        <div class="uk-width-3-4">
                                            {!! Form::text('unitprice', 'null', ['id'=>'unitprice', 'placeholder'=>'Price', 'disabled']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="uk-form-row" hidden>
                                <div class="uk-form-controls">
                                    <div class="uk-grid">
                                        <div class="uk-width-1-4" style="padding-top: 5px;">Total Price</div>
                                        <div class="uk-width-3-4">
                                            {!! Form::text('orderprice', null, ['id'=>'orderprice', 'placeholder'=>'Price', 'disabled']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="uk-form-row">
                                <div class="uk-form-controls">
                                    {!! Form::button('Add Item', ['type'=>'submit', 'id'=>'btn-add', 'class'=>'uk-button uk-button-primary uk-button-large uk-width-1-1 uk-text-bold', 'disabled']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>

                </div>

                <div class="uk-width-6-10">

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary" style="background-color: #e5e4e4;display: none;">
                        <div class="uk-grid">
                            <div class="uk-width-1-1" style="margin-left: 20px;">
                                <div> 
                                    <table width="100%" class="uk-form uk-width-2-10 uk-text-left">
                                        <tr>
                                            {!! Form::open(['route'=>'salesCreate', 'method'=>'post']) !!}
                                            <td class="uk-width-1-1">{!! Form::text('salesdate', $selDate, ['id'=>'salesdate', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="uk-text-left">{!! Form::select('sales_type', ['1'=>'Cash', '2'=>'Credit'], 1, ['id'=>'sales_type']) !!}</td>
                                            <td class="uk-text-left">{!! Form::select('terms', ['0'=>'terms', '1'=>'1 month', '2'=>'2 months', '3'=>'3 months', '4'=>'4 months', '5'=>'5 months'], 0, ['id'=>'terms']) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="uk-text-success uk-text-bold uk-text-left"> 
                                    <a href="#customer-modal" data-uk-modal class="uk-button"><span id="customer-name">Customer</span></a>             
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top uk-margin-small-bottom" style="min-height: 250px; background-color: #fafafa;">
                        <table class="uk-table uk-table-hover uk-table-condensed">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                
                                <th>Item</th>
                                <th style="text-align: right" width="120px;">Quantity</th>
                                <th>&nbsp;</th>
                                <th style="text-align: right">Unit Price</th>
                                
                                <th style="text-align: right">Total</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>{{ $order->myProduct->productname }}</td>
                                        <td style="text-align: right" width="120px;">
                                            <input type="text" value="{{ $order->qty }}" class="uk-width-3-10 order-qty" id="{{ $order->order_id }}">
                                        </td>
                                        <th>&nbsp;</th>
                                        <td style="text-align: right">{{ number_format($order->myProduct->unitprice, 2) }}</td>
                                        
                                        <td style="text-align: right">{{ number_format($order->orderprice, 2) }}</td>
                                        <td class="uk-text-right" width="10">
                                            <a href="{{ route('destroyOrder', ['id'=>$order->order_id]) }}" class="uk-button uk-button-danger uk-button-mini del-rec"><i class="uk-icon-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                {{-- <tr style="background-color: #F0F0F0;">
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="uk-text-right"><i>VATable Sales</i></td>
                                    <td style="text-align: right"><i>{{ number_format($vatSales, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="background-color: #F0F0F0;">
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="uk-text-right"><i>VAT</i></td>
                                    <td style="text-align: right"><i>{{ number_format($vat, 2) }}</i></td>
                                    <td>&nbsp;</td>
                                </tr> --}}
                                <tr style="background-color: #F0F0F0;">
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="uk-text-right"><strong>Total</strong></td>
                                    <td style="text-align: right"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="uk-text-right"><i>Discount</i></td>
                                    <td class="uk-width-1-10 uk-text-right">
                                        
                                        {!! Form::text('fixedAmtDiscount', null, ['id'=>'fixedAmtDiscount', 'class'=>'uk-width-1-8']) !!}
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                    
                                <tr style="background-color: #F0F0F0;">
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="uk-text-right"><strong>Total Amount Due</strong></td>
                                    <td style="text-align: right"><strong>{{ number_format($dprice, 2) }}</strong></td> 
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="background-color: #F0F0F0;" id="tdad-panel">
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="uk-text-right"><i><strong>Discounted Amount Due</strong></i></td>
                                    <td style="text-align: right"><i><strong id='tdad'>----</strong></i></td> 
                                    <td>&nbsp;</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="uk-text-small uk-text-danger" colspan="8"><i class="uk-icon-info"></i> No items yet</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if (Session::has('code'))
                            @if(Session::get('code') == 1)
                                <div class="uk-alert uk-alert-success uk-animation-slide-top">Transaction Complete!</div>
                            @endif
                        @endif
                    </div>

                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-bottom uk-text-right">
                        {!! Form::hidden('amtToPay', ($grandTotal), ['id'=>'amt-to-pay', 'readonly']) !!}
                        {!! Form::hidden('cust_id', 1, ['id'=>'cust_id', 'readonly']) !!}
                        {!! Form::hidden('discounted', null, ['id'=>'discounted']) !!}
                        {!! Form::hidden('discountedsales', null, ['id'=>'discountedsales']) !!}
                        {!! Form::hidden('discountAmt', null, ['id'=>'discountAmt']) !!}
                        

                        @if(count($orders) > 0)
                            <table width="100%" class="uk-form">
                                
                                <tr class="forcash">
                                    <td style="padding-right: 10px;">Amount Tendered</td>
                                    <td class="uk-width-2-10">{!! Form::text('payment', null, ['id'=>'payment', 'class'=>'uk-width-1-1']) !!}</td>
                                </tr>
                                <tr class="forcash">
                                    <td style="padding-right: 10px;">Change<i class="uk-text-small"><strong>(Php)</strong></i></td>
                                    <td class="uk-text-left"><span id="sales-change" class="uk-text-bold">{{ number_format(0, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="uk-text-right">
                                        <hr>
                                        <button id="btn-charge" class="uk-button uk-button-primary" disabled>Process Invoice</button>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="uk-modal" id="customer-modal">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header"><h2>Select Customer</h2></div>
            <div>
                <table class="uk-form" width="100%">
                    <tr>
                        <td>{!! Form::text('search-customer', null, ['id'=>'search-customer', 'class'=>'uk-width-1-1', 'placeholder'=>'Search Customer']) !!}</td>
                    </tr>
                    <tr>
                        <td>
                            {!! Form::select('customer-list', $customers, null, ['id'=>'customer-list', 'class'=>'uk-width-1-1', 'multiple', 'size'=>'10']) !!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <a href="#" class="uk-button uk-button-primary" id="btn-update-customer">Select Customer</a>
                <a href="#" class="uk-button uk-button-danger uk-modal-close">Cancel</a>
            </div>
        </div>
    </div>

@stop

@section('location') Sales @stop

@section('css')
    <link rel="stylesheet" href="/css/components/datepicker.gradient.min.css">
    <link rel="stylesheet" href="/css/components/form-select.gradient.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/js/components/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/components/form-select.min.js"></script>
    <script type="text/javascript">

        $(function(){
            

            /* Load customer name */
            var customer = $('#cust_id').val();

            $.ajax({
                url: '/ajax/fetch/get/customer/details',
                method: 'get',
                async: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    customer: customer
                }
            }).success(function(r){
                $('#customer-name').empty().html("Select Customer");
            });


            var amtToPay = parseFloat($('#amt-to-pay').val());
            var tendered = parseFloat($('#payment').val());
            var change = (tendered - amtToPay);
            if(change >= 0)
            {
                $('#sales-change').html(change);
            }
            else
            {
                $('#sales-change').html(0);
            }

            $('.del-rec').click(function(){
                var r = confirm('Are you sure you want to delete this order?');

                if(!r){
                    return false;
                }
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
                        $('#product-list').empty().html(r).prop('disabled', false);
                    }
                    else
                    {
                        $('#product-list').empty().prop('disabled', true);
                    }
                });
            });

            $('#product').change(function(){

                $('#btn-add').prop('disabled', true);

                var product = $(this).val();

                $.ajax({
                    url: '/ajax/check/product/stock',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product: product
                    }
                }).success(function(r){
                    if(r <= 0)
                    {
                        var r2 = confirm('This product needs restocking before you can proceed!');
                        if(r2)
                        {
                            if(product)
                            {
                                $('#qty').prop('disabled', false).val(1);
                                //$('#btn-add').prop('disabled', false);

                                $.ajax({
                                    url: '/ajax/fetch/product/price',
                                    method: 'get',
                                    async: false,
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        product: product
                                    }
                                }).success(function(r){
                                    if(r)
                                    {
                                        $('#orderprice, #unitprice').prop('disabled', false).val(r);
                                    }
                                });

                                $.ajax({
                                    url: '/ajax/fetch/product/onhand',
                                    method: 'get',
                                    async: false,
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        product: product
                                    }
                                }).success(function(r){
                                    if(r)
                                    {
                                        if(r < 0)
                                        {
                                            $('#onhand').empty().html(0);
                                        }
                                        else
                                        {
                                            $('#onhand').empty().html(r);
                                        }
                                    }
                                });
                            }
                            else
                            {
                                $('#qty, #orderprice').prop('disabled', true).val('');
                                $('#btn-add').prop('disabled', false);
                            }
                        }
                    }
                    else
                    {
                        if(product)
                        {
                            $('#qty, #btn-add').prop('disabled', false).val(1);
                            $('#btn-add').prop('disabled', false);
                            $('#markup').prop('disabled', false).val(0);

                            $.ajax({
                                url: '/ajax/fetch/product/price',
                                method: 'get',
                                async: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    product: product
                                }
                            }).success(function(r){
                                if(r)
                                {
                                    $('#orderprice, #unitprice').prop('disabled', false).val(r);
                                }
                            });

                            $.ajax({
                                url: '/ajax/fetch/product/onhand',
                                method: 'get',
                                async: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    product: product
                                }
                            }).success(function(r){
                                if(r)
                                {
                                    if(r < 0)
                                    {
                                        $('#onhand').empty().html(0);
                                    }
                                    else
                                    {
                                        $('#onhand').empty().html(r);
                                    }
                                }
                            });
                        }
                        else
                        {
                            $('#qty, #orderprice').prop('disabled', true).val('');
                            $('#btn-add').prop('disabled', false);
                            $('#markup').prop('disabled', false).val(0);
                        }
                    }

                    return false;
                });

            });

            $('#product-list').change(function(){
                var productlist = $('#product-list option:selected').text();

                $.ajax({
                    url: '/ajax/fetch/sales/products',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        productlist: productlist
                    }
                }).success(function(r){

                    $('#product').empty().html(r);

                    $('#btn-add').prop('disabled', true);

                    var product = $('#product').val();

                    $.ajax({
                        url: '/ajax/check/product/stock',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            product: product
                        }
                    }).success(function(r){
                        if(r <= 0)
                        {
                            var r2 = confirm('This product needs restocking before you can proceed!');
                            if(r2)
                            {
                                if(product)
                                {
                                    $('#product').prop('disabled', false);
                                    $('#qty').prop('disabled', false).val(1);
                                    //$('#btn-add').prop('disabled', false);
                                    $('#markup').prop('disabled', false).val(0);

                                    $.ajax({
                                        url: '/ajax/fetch/product/price',
                                        method: 'get',
                                        async: false,
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            product: product
                                        }
                                    }).success(function(r){
                                        if(r)
                                        {
                                            $('#orderprice, #unitprice').prop('disabled', false).val(r);
                                        }
                                    });

                                    $.ajax({
                                        url: '/ajax/fetch/product/onhand',
                                        method: 'get',
                                        async: false,
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            product: product
                                        }
                                    }).success(function(r){
                                        if(r)
                                        {
                                            if(r < 0)
                                            {
                                                $('#onhand').empty().html(0);
                                            }
                                            else
                                            {
                                                $('#onhand').empty().html(r);
                                            }
                                        }
                                    });
                                }
                                else
                                {
                                    $('#qty, #orderprice').prop('disabled', true).val('');
                                    $('#btn-add').prop('disabled', false);
                                    $('#markup').prop('disabled', false).val(0);
                                }
                            }
                        }
                        else
                        {
                            if(product)
                            {
                                $('#product').prop('disabled', false);
                                $('#qty, #btn-add').prop('disabled', false).val(1);
                                $('#btn-add').prop('disabled', false);
                                $('#markup').prop('disabled', false).val(0);

                                $.ajax({
                                    url: '/ajax/fetch/product/price',
                                    method: 'get',
                                    async: false,
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        product: product
                                    }
                                }).success(function(r){
                                    if(r)
                                    {
                                        $('#orderprice, #unitprice').prop('disabled', false).val(r);
                                    }
                                });

                                $.ajax({
                                    url: '/ajax/fetch/product/onhand',
                                    method: 'get',
                                    async: false,
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        product: product
                                    }
                                }).success(function(r){
                                    if(r)
                                    {
                                        if(r < 0)
                                        {
                                            $('#onhand').empty().html(0);
                                        }
                                        else
                                        {
                                            $('#onhand').empty().html(r);
                                        }
                                    }
                                });
                            }
                            else
                            {
                                $('#qty, #orderprice').prop('disabled', true).val('');
                                $('#btn-add').prop('disabled', false);
                                $('#markup').prop('disabled', false).val(0);
                            }
                        }

                        return false;
                    });
                });
            });

            $('.order-qty').keyup(function(e){
                var code = e.keyCode || e.which;
                var order = this.id;
                var qty = $(this).val();

                if(code == 13) {
                    $.ajax({
                        url: '/ajax/update/order/qty',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            order: order,
                            qty: qty
                        }
                    }).success(function(r){
                        location.reload();
                    });
                }
            });

            $('#key').keyup(function(e){
                var key = $(this).val();
                var code = e.keyCode || e.which;

                if(code == 13) {
                    $('#category').val(0).prop('disabled', false);

                    $.ajax({
                        url: '/ajax/fetch/key/products',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            key: key
                        }
                    }).success(function(r){
                        if(r)
                        {
                            $('#product-list').empty().html(r).prop('disabled', false);
                        }
                        else
                        {
                            $('#product-list').empty().prop('disabled', true);
                        }
                    });
                }
                else
                {
                    if(key != '')
                    {
                        $('#category').val(0).prop('disabled', false);
                    }
                    else
                    {
                        $('#category').val(0).prop('disabled', false);
                    }
                }
            });

            $('#payment').keyup(function(){
                var salesType = $('#sales_type').val();
                var payTerms = $('#terms').val();
                var amtToPay = parseFloat($('#amt-to-pay').val());
                var tendered = parseFloat($('#payment').val());
                

                var discountedsales = $('#discountedsales').val();

                if(discountedsales > 0)
                {
                    var change = (tendered - discountedsales);
                }
                else
                {
                    var change = (tendered - amtToPay);
                }

                if(tendered <= 0)
                {
                    alert('Wrong amount value!');
                    $(this).val('');
                    return false;
                }

                if(salesType == 2)
                {
                    $('#btn-charge').prop('disabled', false);
                }
                else
                {
                    if(change >= 0)
                    {
                        $('#sales-change').html(change.toFixed(2));
                        $('#btn-charge').prop('disabled', false);
                    }
                    else
                    {
                        $('#sales-change').html(0);
                        $('#btn-charge').prop('disabled', true);
                    }
                }
            });

            $('#search-customer').keyup(function(){
                var key = $(this).val();
                var keyLen = key.length;
                if(keyLen > 3)
                {
                    $.ajax({
                        url: '/ajax/fetch/key/customers',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            key: key
                        }
                    }).success(function(r){
                        $('#customer-list').empty().html(r);
                    });
                }
            });

            $('#btn-update-customer').click(function() {
                var modal = UIkit.modal("#customer-modal");
                var selectedCustomer = $('#customer-list').val();

                $('#cust_id').val(selectedCustomer);
                var customer = $('#cust_id').val();

                if (customer == 1) {
                    $('.forcash').show();

                    var amtToPay = parseFloat($('#amt-to-pay').val());
                    var tendered = parseFloat($('#payment').val());
                    var change = (tendered - amtToPay);

                    if (change >= 0) {
                        $('#sales-change').html(change);
                        $('#btn-charge').prop('disabled', false);
                    }
                    else {
                        $('#sales-change').html(0);
                        $('#btn-charge').prop('disabled', true);
                    }

                    $('#sales_type').val(1);
                }

                $.ajax({
                    url: '/ajax/fetch/get/customer/details',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        customer: customer
                    }
                }).success(function(r){
                    $('#customer-name').empty().html(r);
                });

                modal.hide();
            });

            $('#btn-charge').click(function(){
                var customer = $('#cust_id').val();
                if(customer == '' || customer == null)
                {
                    alert('Please select customer first.');
                    return false;
                }
                else
                {
           
                    $('#frm-process-invoice').submit();
                }
            });

            $('#sales_type').change(function(){
                var stype = $(this).val();
                if(stype == 1)
                {
                    $('.forcash').show();

                    var amtToPay = parseFloat($('#amt-to-pay').val());
                    var tendered = parseFloat($('#payment').val());
                    var change = (tendered - amtToPay);

                    if(change >= 0)
                    {
                        $('#sales-change').html(change);
                        $('#btn-charge').prop('disabled', false);
                    }
                    else
                    {
                        $('#sales-change').html(0);
                        $('#btn-charge').prop('disabled', true);
                    }

                    $('#cust_id').val(1);
                    $.ajax({
                        url: '/ajax/fetch/get/customer/details',
                        method: 'get',
                        async: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            customer: 1
                        }
                    }).success(function(r){
                        $('#customer-name').empty().html(r);
                    });
                }
                else
                {
                    $('#fixedAmtDiscount').prop('disabled', true);  //added
                    $('#btn-charge').prop('disabled', false);
                    $('.forcash').hide();

                    $('#cust_id').val('');
                    $('#customer-name').empty().html("Select Customer");
                }
                //window.location.reload();
            });

            $('#qty').keyup(function(){

                $('#btn-add').prop('disabled', true);

                var qty = $(this).val();
                var product = $('#product').val();
                var price = 0;

                $.ajax({
                    url: '/ajax/fetch/product/price',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product: product
                    }
                }).success(function(r){
                    if(r)
                    {
                        price = r;
                    }
                });

                $.ajax({
                    url: '/ajax/check/product/stock',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product: product,
                        qty: qty
                    }
                }).success(function(r){
                    if(r < 0)
                    {
                        var r2 = confirm('This product needs restocking before you can proceed!');
                        if(!r2)
                        {
                            return false;
                        }
                        else
                        {
                            //$('#btn-add').prop('disabled', false);
                            $('#orderprice').prop('disabled', false).val(parseFloat(qty) * parseFloat(price));
                            $('#unitprice').prop('disabled', false).val(parseFloat(price));
                        }
                    }
                    else
                    {
                        $('#btn-add').prop('disabled', false);
                        $('#orderprice').prop('disabled', false).val(parseFloat(qty) * parseFloat(price));
                        $('#unitprice').prop('disabled', false).val(parseFloat(price));
                    }
                });


            });

            $('#unitprice').keyup(function(){
                var qty = $('#qty').val();
                var unitprice = $(this).val();
                var orderprice = parseFloat(unitprice) * parseFloat(qty);

                $('#orderprice').val(orderprice);
            });

            $('#customer-list').change(function(){
                var customer = $(this).val();

                $.ajax({
                    url: '/ajax/check/customer/credit',
                    method: 'get',
                    async: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        customer: customer
                    }
                }).success(function(r){
                    if(r == 0)
                    {
                        $.ajax({
                            url: '/ajax/fetch/customer/credit',
                            method: 'get',
                            async: 'false',
                            data: {
                                _token: '{{ csrf_token() }}',
                                customer: customer
                            }
                        }).success(function(r){
                            var c = confirm('Customer has outstanding balance of ' + r + '. Are you sure you want to select customer?');

                            if(!c)
                            {
                                $('#customer-list').val('');
                                return false;
                            }
                        });

                        
                    }
                    
                });
            });

            /* Discount */
            $('#discount').change(function(){
                if($(this).val() == 0)
                {
                    $('#discounted').val(0);
                    $('#discountedsales').val(0);
                    $('#tdad').html('----');

                    $('#fixedAmtDiscount').prop('disabled', false);  //added
                }
                else
                {
                    var percentDiscount = parseFloat($(this).val()) / 100;
                    var amtToPay = $('#amt-to-pay').val();

                    var newAmtToPay =  amtToPay - (amtToPay * percentDiscount);

                    $('#discounted').val($(this).val());
                    $('#discountedsales').val(newAmtToPay.toFixed(2));

                    $('#tdad-panel').show();
                    $('#tdad').html(newAmtToPay.toFixed(2));

                    $('#fixedAmtDiscount').prop('disabled', true);  //added
                }
                
                var myPayment = $('#payment').val();
                if(myPayment > 0)
                {
                    $('#payment').val('');   
                    $('#sales-change').html(0);
                    $('#btn-charge').prop('disabled', true);            
                }
            });

             /* Discount input */
            $('#fixedAmtDiscount').keyup(function(){
                if($(this).val() == 0)
                {
                    $('#discountAmt').val(0);
                    $('#discountedsales').val(0);
                    $('#tdad').html('----');

                    $('#discount').prop('disabled', false);  //added
                }
                else
                {
                    var percentDiscount = parseFloat($(this).val()) / 100;
                    var amtToPay = $('#amt-to-pay').val();

                    var newAmtToPay = amtToPay - (percentDiscount * 100);

                    $('#discountAmt').val($(this).val());
                    /*$('#discounted').val($(this).val());*/
                    $('#discountedsales').val(newAmtToPay.toFixed(2));

                    $('#tdad-panel').show();
                    $('#tdad').html(newAmtToPay.toFixed(2));

                    $('#discount').prop('disabled', true);  //added
                }
                
                var myPayment = $('#payment').val();
                if(myPayment > 0)
                {
                    $('#payment').val('');   
                    $('#sales-change').html(0);
                    $('#btn-charge').prop('disabled', true);            
                }
            });
            
        })
    </script>
@stop