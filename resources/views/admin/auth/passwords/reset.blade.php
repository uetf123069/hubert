@extends('layouts.admin.focused')

@section('content')
<form class="form-layout" role="form" method="POST" action="{{ url('/admin/password/reset') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="text-center mb15">
        <img src="{{ Setting::get('site_logo', asset('logo.png')) }}" />
    </div>

    <p class="text-center mb25">{{ tr('password_reset_msg') }}</p>

    <div class="form-inputs">

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control input-lg" name="email" value="{{ $email or old('email') }}" placeholder="E-Mail Address">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control input-lg" name="password" placeholder="Password">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input type="password" class="form-control input-lg" name="password_confirmation" placeholder="Confirm Password">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6 col-md-offset-3">
        <button class="btn btn-success btn-block mb15" type="submit">
                <span><i class="fa fa-btn fa-refresh"></i> {{ tr('password_reset_button') }}</span>
        </button>
    </div>
    
</form>
@endsection
