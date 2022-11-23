<div>
    <div class="uk-width-1-6">Status</div>
    <div>{!! Form::select('status', ['0'=>'Active', '1'=>'Not Active'], null, ['class' => 'uk-select']) !!}</div>
</div>
<div>
    <div class="uk-width-1-6">Category</div>
    <div>{!! Form::select('category_id', $categories, null, ['class' => 'uk-select']) !!}</div>
</div>
<div>
    <div class="uk-width-1-6">Product Name</div>
            <div>
                {!! Form::text('productname', null, ['placeholder'=>'Product Name', 'class' => 'uk-input']) !!}
                @if($errors->has('productname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('productname') }}</small></i></span> @endif
            </div>
</div>
{{-- <div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('pattern', null, ['class'=>'uk-width-1-2', 'placeholder'=>'Pattern']) !!}
        @if($errors->has('pattern')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('pattern') }}</small></i></span> @endif
    </div>
</div> --}}
<div>
    <div class="uk-width-1-12">Unit Cost - Market Value (PHP)</div>
            <div>
                {!! Form::text('unitcost', null, ['placeholder'=>'Unit Cost', 'class' => 'uk-input']) !!}
            </div>
</div>
<div>
    <div class="uk-width-1-12">Unit Price - Selling Price (PHP)</div>
            <div>
                {!! Form::text('unitprice', null, ['placeholder'=>'Unit Price', 'class' => 'uk-input']) !!}
            </div>
</div>
<div>
    <div class="uk-width-1-6">Stock</div>
            <div>{!! Form::text('stock', null, ['placeholder'=>'0-9999', 'class' => 'uk-input']) !!}</div>
</div>
<div>
    <div class="uk-width-1-6">Product Code</div>
    <div>
        {!! Form::text('productcode', null, ['placeholder'=>'Product Code', 'class' => 'uk-input']) !!}
        @if($errors->has('productcode')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('productcode') }}</small></i></span> @endif
    </div>
</div>
{{-- <div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('unitcost', null, ['class'=>'uk-width-1-10', 'placeholder'=>'Unit Cost']) !!}
        {!! Form::text('unitprice', null, ['class'=>'uk-width-1-10', 'placeholder'=>'Unit Price']) !!}
        {!! Form::select('percentage', $percentage, null, ['class'=>'uk-width-1-10']) !!}
        @if($errors->has('unitcost')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('unitcost') }}</small></i></span> @endif
        @if($errors->has('unitprice')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('unitprice') }}</small></i></span> @endif
    </div>
</div> --}}
{{-- <div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('reorderlimit', $reorderlimit, null, ['class'=>'uk-width-1-10']) !!}
    </div>
</div> --}}

{{-- <div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('supplier_id', $suppliers, null, ['class'=>'uk-width-2-4']) !!}
    </div>
</div> --}}

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
        <a href="{{ route('productsIndex') }}" class="uk-button uk-button-danger">Cancel</a>
    </div>
</div>