<div class="uk-grid-divider" uk-grid>
    <div class="uk-width-1-2">
        <div>
            <h3>Employee Info</h3>
        </div>
        <div>
            <div>Position</div>
            <div>
                {!! Form::select('position', $employeeType, null, ['class' => 'uk-select']) !!}
                @if($errors->has('position')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('position') }}</small></i></span> @endif
            </div>
        </div>
        <div>
            <div>Name (Last Name, First Name, M.I.)</div>
            <div>
                {!! Form::text('employeename', null, ['placeholder'=>'ex. Dela Cruz, Juan A.', 'class' => 'uk-input']) !!}
                @if($errors->has('employeename')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('employeename') }}</small></i></span> @endif
            </div>
        </div>
        <div>
            <div>Contact Number</div>
            <div>
                {!! Form::text('contactno', null, ['placeholder'=>'ex. 0917xxxxxx', 'class' => 'uk-input']) !!}
                @if($errors->has('contactno')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('contactno') }}</small></i></span> @endif
            </div>
        </div>
        <div>
            <div>Address</div>
            <div>
                {!! Form::textarea('address', null, ['placeholder'=>'Brgy. 1, XXXXX', 'class' => 'uk-textarea']) !!}
                @if($errors->has('address')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('address') }}</small></i></span> @endif
            </div>
        </div>
        <div>
            <div>Email Address</div>
            <div>
                {!! Form::email('email', null, ['placeholder'=>'xxxx@xxx.xxx', 'class' => 'uk-input']) !!}
                @if($errors->has('email')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('email') }}</small></i></span> @endif
            </div>
        </div>
    </div>
    <div class="uk-width-1-2">
        <div>
            <h3>Login Info</h3>
        </div>
        <div>
            <div>Username</div>
            <div>
                {!! Form::text('username', null, ['class'=>'uk-input', 'placeholder'=>'Username']) !!}
                @if($errors->has('username')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('username') }}</small></i></span> @endif
            </div>
        </div>
        <div>
            <div>Password</div>
            <div>
                {!! Form::password('password', ['class'=>'uk-input', 'placeholder'=>'Password']) !!}
                @if($errors->has('password')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('password') }}</small></i></span> @endif
            </div>
        </div>
        <div>
            <div>Confirm Password</div>
            <div>
                {!! Form::password('password_confirmation', ['class'=>'uk-input', 'placeholder'=>'Confirm Password']) !!}
            </div>
        </div>
    </div>
    
</div>
<hr>
<div>
    {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    <a href="{{ route('employeeIndex') }}" class="uk-button uk-button-danger">Cancel</a>
</div>