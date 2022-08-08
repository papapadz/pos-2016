@extends('auth')

@section('content')

    <div class="uk-vertical-align-middle" style="width:600px;">

        <form class="uk-panel uk-panel-box uk-panel-box-primary uk-panel-box-primary-hover uk-form" style="background: grey" method="post" action="/auth/login">
            <h1 style="color:#ddd;">Point of Sale System</h1>
            {!! csrf_field() !!}
            <div class="uk-form-row">
                 <div class="uk-form-icon"><i class="uk-icon-user"></i>
                    <input type="text" placeholder="Username" class="uk-width-1-1 uk-form-large uk-form-width-large" name="username" value="{{ old('username') }}">
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-form-icon"><i class="uk-icon-unlock-alt"></i>
                    <input type="password" placeholder="Password" class="uk-width-1-1 uk-form-large uk-form-width-large" name="password" id="password">
                </div>
            </div>
            <div class="uk-form-row">
                <button type="submit" class="uk-width-1-2 uk-button uk-button-success uk-button-large">Login</button>
            </div>
        </form>

    </div>

@stop

@section('js')

        <!-- Javascript-->
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.backstretch.min.js"></script>
        <script src="/assets/js/scripts.js"></script>
        
@stop