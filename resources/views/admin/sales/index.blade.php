@extends('admin')

@section('content')

    @if(Session::has('success'))
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ Session::get('success')}}</p>
    </div>
    @endif

    <div class="uk-grid-divider uk-child-width-1-2@m" uk-grid>
        <div class="uk-width-1-3@m">
                {!! Form::open(['route'=>'ordersCreate', 'class'=>'uk-form-stacked']) !!}
                <div class="uk-margin">
                    <div class="uk-form-controls">
                        <label>Search Item</label>
                        {!! Form::text('key', null, ['id'=>'key', 'class'=>'uk-width-1-1 uk-input uk-form-small', 'placeholder'=>'ex. Biscuit']) !!}
                    </div>
                </div>
                <div class="uk-margin">
                    <label>Category</label>
                    <div class="uk-form-controls">
                        {!! Form::select('category_id', $categories, null, ['id'=>'category', 'class'=>'uk-width-1-1 uk-select']) !!}
                    </div>
                </div>
                <div class="uk-margin">
                    <label>Item List</label>
                    <div class="uk-form-controls">
                        {!! Form::select('productList', $products, null, ['id'=>'product-list', 'class'=>'uk-width-1-1 uk-textarea', 'multiple', 'size'=>'10']) !!}
                    </div>
                    <div>
                        <span uk-icon="cart"></span> <label id="onhand">----</label>
                    </div>
                </div>
                <div class="uk-margin" hidden>
                    <div class="uk-form-controls">
                        {!! Form::select('product_id', ['0'=>'----'], 0, ['class'=>'uk-width-1-1','id'=>'product', 'disabled']) !!}
                    </div>
                </div>
                <input type="number" value="1" name="qty" hidden>
                
                <div class="uk-margin" hidden>
                    <div class="uk-form-controls">
                        <div class="uk-grid">
                            <div class="uk-width-1-4" style="padding-top: 5px;">Unit Price</div>
                            <div class="uk-width-3-4">
                                {!! Form::text('unitprice', 'null', ['id'=>'unitprice', 'placeholder'=>'Price', 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="uk-margin" hidden>
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
                <div class="uk-margin">
                    <div class="uk-form-controls">
                        {!! Form::button('Add Item', ['type'=>'submit', 'id'=>'btn-add', 'class'=>'uk-button uk-button-primary uk-button-large uk-width-1-1 uk-text-bold', 'disabled']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
        </div>
        
        <div class="uk-width-expand@m">
            
        {!! Form::open(['route'=>'salesCreate', 'method'=>'post']) !!}
            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top uk-margin-small-bottom">
                <table class="uk-table uk-table-hover uk-table-justify uk-table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Item</th>
                        <th style="text-align: right" width="120px;">Quantity</th>
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
                                <td style="text-align: right">{{ number_format($order->myProduct->unitprice, 2) }}</td>
                                <td style="text-align: right">{{ number_format($order->orderprice, 2) }}</td>
                                <td colspan="2" class="uk-text-right" width="10">
                                    <a href="{{ route('destroyOrder', ['id'=>$order->order_id]) }}" class="uk-button uk-button-danger uk-button-small del-rec">X</a>
                                </td>
                            </tr>
                        @endforeach                
                    @else
                        <tr>
                            <td class="uk-text-small uk-text-danger" colspan="7"><span uk-icon="warning"></span> No items yet</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @if (Session::has('code'))
                    @if(Session::get('code') == 1)
                        <div class="uk-alert uk-alert-success uk-animation-slide-top">Transaction Complete!</div>
                    @endif
                @endif
                
                @if(count($orders)>0)
                <div class="uk-card uk-text-right">
                    <div class="uk-margin">
                        <div class="uk-flex-right" uk-grid>
                            <div class="uk-width-1-2@m"><strong>Total: </strong></div>
                            <div><strong>{{ number_format($grandTotal, 2) }}</strong></div>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-flex-right" uk-grid>
                            <div class="uk-width-1-2@m"><i>Discount:</i></div>
                            <div>
                                {!! Form::text('fixedAmtDiscount', null, ['id'=>'fixedAmtDiscount', 'class' => 'uk-input uk-form-small']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-flex-right" uk-grid>
                            <div class="uk-width-1-2@m"><strong>Total Amount Due: </strong></div>
                            <div><strong>{{ number_format($dprice, 2) }}</strong></div>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-flex-right" uk-grid>
                            <div class="uk-width-1-2@m"><strong>Discounted Amount Due: </strong></div>
                            <div><i><strong id='tdad'>----</strong></i></div>
                        </div>
                    </div>

                    <hr class="uk-divider-icon">

                    <div class="uk-margin forcash">
                        <div class="uk-flex-right" uk-grid>
                            <div class="uk-width-1-2@m"><strong>Amount Tendered: </strong></div>
                            <div>{!! Form::text('payment', null, ['id'=>'payment', 'class'=>'uk-width-1-1 uk-input uk-form-small']) !!}</div>
                        </div>
                    </div>

                    <div class="uk-margin forcash">
                        <div class="uk-flex-right" uk-grid>
                            <div class="uk-width-1-2@m"><strong>Change<i class="uk-text-small">(Php)</i></strong></div>
                            <div><span id="sales-change" class="uk-text-bold">{{ number_format(0, 2) }}</span></div>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <button id="btn-charge" class="uk-button uk-button-primary" disabled>Submit</button>
                    </div>
                    {!! Form::select('sales_type', ['1'=>'Cash', '2'=>'Credit'], 1, ['id'=>'sales_type', 'hidden']) !!}
                    {!! Form::select('terms', ['0'=>'terms', '1'=>'1 month', '2'=>'2 months', '3'=>'3 months', '4'=>'4 months', '5'=>'5 months'], 0, ['id'=>'terms', 'hidden']) !!}
                    {!! Form::hidden('amtToPay', ($grandTotal), ['id'=>'amt-to-pay', 'readonly']) !!}
                    {!! Form::hidden('cust_id', 1, ['id'=>'cust_id', 'readonly']) !!}
                    {!! Form::hidden('discounted', null, ['id'=>'discounted']) !!}
                    {!! Form::hidden('discountedsales', null, ['id'=>'discountedsales']) !!}
                    {!! Form::hidden('discountAmt', null, ['id'=>'discountAmt']) !!}
                </div>
                @endif
            </div>
        {!! Form::close() !!}
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