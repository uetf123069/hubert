@extends('layouts.admin.focused')

@section('content')


<form class="form-layout" role="form" method="POST" action="{{ url('/admin/login') }}">
    {{ csrf_field() }}

    <div class="text-center mb15">
        <img class="adm-log-logo" src="{{ asset('logo.png') }}" />
    </div>

    <p class="text-center mb30">{{ tr('welcome') }}</p>

    <div class="form-inputs">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="{{ tr('email_add') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

            <input type="password" class="form-control input-lg" name="password" placeholder="{{ tr('password') }}">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

        </div>


    </div>

    <div class="col-md-6 col-md-offset-3">
        <button class="btn btn-success btn-block mb15" type="submit">
            <h5><span><i class="fa fa-btn fa-sign-in"></i> {{ tr('login')}}</span></h5>
        </button>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <a class="btn btn-link" href="{{ url('/admin/password/reset') }}">{{ tr('forgot')}}</a>
        </div>
        <div class="col-md-6 text-right">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> {{ tr('remember')}}
                </label>
            </div>
        </div>
    </div>

</form>
@endsection
