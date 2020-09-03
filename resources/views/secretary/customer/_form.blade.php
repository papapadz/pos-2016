<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('companyname', null, ['class'=>'uk-width-1-2', 'placeholder'=>'Company Name']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('lastname', null, ['placeholder'=>'Customer Lastname', 'class'=>'uk-width-1-4']) !!}
        {!! Form::text('firstname', null, ['placeholder'=>'Customer Firstname', 'class'=>'uk-width-1-4']) !!}
        @if($errors->has('lastname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('lastname') }}</small></i></span> @endif
        @if($errors->has('firstname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('firstname') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('tin_no', null, ['placeholder'=>'TIN']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('contactno', null, ['placeholder'=>'Contact Number']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::textarea('address', null, ['rows'=>'2', 'class'=>'uk-width-1-2', 'placeholder'=>'Address']) !!}
        @if($errors->has('address')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('address') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('city', null, ['class'=>'uk-width-1-2', 'placeholder'=>'City']) !!}
        @if($errors->has('city')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('city') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('cust_type', $customerType, null) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>