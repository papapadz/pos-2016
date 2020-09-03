<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::select('agent', $agents, []) !!}
        @if($errors->has('agent')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('agent') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('expensedate', null, ['placeholder'=>'Date', "data-uk-datepicker"=>"{format:'YYYY-MM-DD'}"]) !!}
        @if($errors->has('expensedate')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('expensedate') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('food', null, ['class'=>'uk-width-1-4', 'placeholder'=>'Food Allowance']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('home_stay', null, ['class'=>'uk-width-1-4', 'placeholder'=>'Home Stay']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('diesel', null, ['placeholder'=>'Diesel', 'class'=>'uk-width-1-4']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('load', null, ['class'=>'uk-width-1-4', 'placeholder'=>'Load']) !!}
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('others', null, ['class'=>'uk-width-1-4', 'placeholder'=>'Others']) !!}
    </div>
</div>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>
