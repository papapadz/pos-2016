<div class="uk-form-row">
    <div class="uk-form-controls">
         {!! Form::select('cust_id', $customers, null, ['class'=>'uk-width-2-4']) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>