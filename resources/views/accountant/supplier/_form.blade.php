<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('companyname', null, ['class'=>'uk-width-2-4', 'placeholder'=>'Company']) !!}
        @if($errors->has('companyname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('companyname') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('lastname', null, ['placeholder'=>'Lastname', 'class'=>'uk-width-1-4']) !!}
        {!! Form::text('firstname', null, ['placeholder'=>'Firstname', 'class'=>'uk-width-1-4']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('contactno', null, ['placeholder'=>'Contact']) !!}
         @if($errors->has('contactno')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('contactno') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::textarea('address', null, ['rows'=>'2', 'class'=>'uk-width-2-4', 'placeholder'=>'Address']) !!}
         @if($errors->has('address')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('address') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('city', null, ['class'=>'uk-width-2-4', 'placeholder'=>'City']) !!}
         @if($errors->has('city')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('city') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('tin', null, ['placeholder'=>'TIN']) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>