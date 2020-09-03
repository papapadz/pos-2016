<div class="uk-form-row">
    <label for="form-s-it" class="uk-form-label">Delivery Date</label>
    <div class="uk-form-controls">
        {!! Form::text('deliverydate', null, ["data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
    </div>
</div>
<div class="uk-form-row">
    <label for="form-s-it" class="uk-form-label">Supplier</label>
    <div class="uk-form-controls">
        {!! Form::select('supplier_id', $suppliers, null, ['id'=>'supplier']) !!}
    </div>
</div>
<div class="uk-form-row">
    <label for="form-s-it" class="uk-form-label">Product</label>
    <div class="uk-form-controls">
        {!! Form::select('product_id', $products, null, ['id'=>'product']) !!}
    </div>
</div>
<div class="uk-form-row">
    <label for="form-s-it" class="uk-form-label">Quantity Delivered</label>
    <div class="uk-form-controls">
        {!! Form::text('qty', null) !!}
    </div>
</div>
<div class="uk-form-row">
    <label for="form-s-it" class="uk-form-label">Unit Delivery Cost</label>
    <div class="uk-form-controls">
        {!! Form::text('unitcost', null) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>