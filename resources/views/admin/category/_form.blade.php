<div>
    <div>Category</div>
    <div class="uk-form-controls">
        {!! Form::text('categoryname', null, ['class'=>'uk-input', 'placeholder'=>'Category']) !!}
        @if($errors->has('categoryname')) <span class="uk-form-help-inline uk-text-danger"><i><small>{{ $errors->first('categoryname') }}</small></i></span> @endif
    </div>
</div>
<div>
    <div>Description</div>
    <div class="uk-form-controls">
        {!! Form::textarea('description', null, ['rows'=>'3', 'class'=>'uk-textarea', 'placeholder'=>'Description']) !!}
    </div>
</div>

<hr>

<div class="uk-form-row">
    <div class="uk-form-controls uk-text-right">
        {!! Form::button($btnCaption, ['type'=>'submit', 'class'=>'uk-button uk-button-primary']) !!}
        <a href="{{ route('categoryIndex') }}" class="uk-button uk-button-danger">Cancel</a>
    </div>
</div>