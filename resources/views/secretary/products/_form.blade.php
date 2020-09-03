<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('status', ['0'=>'Active', '1'=>'Not Active'], null, ['class'=>'uk-width-1-10']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('productname', null, ['class'=>'uk-width-1-2', 'placeholder'=>'Product Name']) !!}
        @if($errors->has('productname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('productname') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('unitcost', null, ['class'=>'uk-width-1-10', 'placeholder'=>'Unit Cost']) !!}
        {!! Form::select('markup', $markup, null, ['class'=>'uk-width-1-10']) !!}
        <!--{!! Form::text('unitprice', null, ['class'=>'uk-width-1-10', 'placeholder'=>'Unit Price']) !!} -->
        @if($errors->has('unitcost')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('unitcost') }}</small></i></span> @endif
        <!--@if($errors->has('unitprice')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('unitprice') }}</small></i></span> @endif -->
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('reorderlimit', $reorderlimit, null, ['class'=>'uk-width-1-10']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('category_id', $categories, null, ['class'=>'uk-width-2-4']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('supplier_id', $suppliers, null, ['class'=>'uk-width-2-4']) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>