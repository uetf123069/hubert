@extends('layouts.provider.focused')

@section('title', 'Login | ')

@section('content')
<div class="container" id="login-form">
    <a href="{{ url('/') }}" class="login-logo"><img src="{{ asset('logo.png') }}"></a>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>{{ tr('login_form') }}</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" id="validate-form" role="form" method="POST" action="{{ url('provider/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">                           
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Username" data-parsley-minlength="6" placeholder="{{ tr('password_ph') }}" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" name="password" placeholder="{{ tr('password') }}">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <a href="{{ url('provider/password/reset') }}" class="pull-left">{{ tr('forgot_password') }}</a>

                            </div>
                        </div>

                        <div class="panel-footer">
                            <div class="clearfix">
                                <a href="{{ url('provider/register') }}" class="btn btn-default pull-left">{{ tr('register') }}</a>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-sign-in"></i> {{ tr('login') }}
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
