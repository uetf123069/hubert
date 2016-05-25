@extends('layouts.admin.focused')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/register') }}">
    {{ csrf_field() }}

    <div class="text-center mb15">
        <img src="{{ Setting::get('site_logo', asset('logo.png')) }}" />
    </div>

    <p class="text-center mb25">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>


    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" name="password" placeholder="Password">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-success btn-block mb15">
                <i class="fa fa-btn fa-user"></i> Register
            </button>
        </div>
    </div>
</form>
@endsection
