@extends('layouts.admin.focused')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form class="form-layout" role="form" method="POST" action="{{ url('/admin/password/email') }}">
    {{ csrf_field() }}

    <div class="text-center mb15">
        <img src="{{ Setting::get('site_logo', asset('logo.png')) }}" />
    </div>

    <p class="text-center mb25">{{ tr('password_reset_email') }}</p>

    <div class="form-inputs">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button class="btn btn-success btn-block mb15" type="submit">
                    <i class="fa fa-btn fa-envelope"></i> {{ tr('password_reset_button') }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
