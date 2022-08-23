<div class="uk-form-row">
    <div class="uk-form-controls">
        <div class="uk-grid">
            <div class="uk-width-1-4">Employee Position</div>
            <div>
                {!! Form::select('position', $employeeType, null, []) !!}
                @if($errors->has('position')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('position') }}</small></i></span> @endif
            </div>
        </div>
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        <div class="uk-grid">
            <div class="uk-width-1-4">Employee Name</div>
            <div>
                {!! Form::text('employeename', null, ['placeholder'=>'ex. Dela Cruz, Juan']) !!}
                @if($errors->has('employeename')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('employeename') }}</small></i></span> @endif
            </div>
        </div>
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        <div class="uk-grid">
            <div class="uk-width-1-4">Employee Contact Number</div>
            <div>
                {!! Form::text('contactno', null, ['placeholder'=>'ex. 0917xxxxxx']) !!}
                @if($errors->has('contactno')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('contactno') }}</small></i></span> @endif
            </div>
        </div>
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('username', null, ['class'=>'uk-width-1-4', 'placeholder'=>'Username']) !!}
        @if($errors->has('username')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('username') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::password('password', ['class'=>'uk-width-1-4', 'placeholder'=>'Password']) !!}
        @if($errors->has('password')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('password') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::password('password_confirmation', ['class'=>'uk-width-1-4', 'placeholder'=>'Confirm Password']) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>