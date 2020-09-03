<form method="POST" action="/auth/register">
    {!! csrf_field() !!}
    @if (Session::has('message'))
        <div class="uk-alert uk-alert-success uk-animation-slide-top"> {{ Session::get('message') }} </div>
    @endif
    <div>
        Name
        <input type="text" name="employeename" value="{{ old('employeename') }}">
    </div>

    <div>
        Username
        <input type="text" name="username" value="{{ old('username') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>