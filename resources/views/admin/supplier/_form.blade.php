<div>
    <div>Business Name</div>
    <div>
        {!! Form::text('companyname', null, ['class'=>'uk-width-2-4 uk-input', 'placeholder'=>'Business Name']) !!}
        @if($errors->has('companyname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('companyname') }}</small></i></span> @endif
    </div>
</div>
<div>
    <div>Business Owner's Name (Last Name, First Name M.I)</div>
    <div>
        {!! Form::text('owner_name', null, ['placeholder'=>'(ex. Dela Cruz, Juan A.)', 'class'=>'uk-input']) !!}
        @if($errors->has('owner_name')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('contactno') }}</small></i></span> @endif
    </div>
</div>
<div>
    <div>Contact Number</div>
    <div>
        {!! Form::text('contactno', null, ['placeholder'=>'ex. 09xxxxxxxx','class' => 'uk-input']) !!}
         @if($errors->has('contactno')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('contactno') }}</small></i></span> @endif
    </div>
</div>
<div>
    <div>Business Address</div>
    <div>
        {!! Form::textarea('address', null, ['rows'=>'2', 'class'=>'uk-input', 'placeholder'=>'Brgy. 1 XXXXX']) !!}
        @if($errors->has('address')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('address') }}</small></i></span> @endif
    </div>
</div>
<div>
    <div>TIN</div>
    <div>
        {!! Form::text('tin', null, ['class'=>'uk-input', 'placeholder'=>'TIN']) !!}
        @if($errors->has('tin')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('tin') }}</small></i></span> @endif
    </div>
</div>
<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
        <a href="{{ route('supplierIndex') }}" class="uk-button uk-button-danger">Cancel</a>
    </div>
</div>