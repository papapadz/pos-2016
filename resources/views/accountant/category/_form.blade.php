<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::text('categoryname', null, ['class'=>'uk-width-1-2', 'placeholder'=>'Category Name']) !!}
        @if($errors->has('categoryname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('categoryname') }}</small></i></span> @endif
    </div>
</div>
<div class="uk-form-row">
    <div class="uk-form-controls">
        {!! Form::textarea('description', null, ['rows'=>'3', 'class'=>'uk-width-1-2', 'placeholder'=>'Description']) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
    </div>
</div>