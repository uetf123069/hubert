@extends('layouts.admin')

@section('title', 'Admin Password | ')

@section('content')

@include('notification.notify')

<div class="panel mb25">
  <div class="panel-heading border">
    {{ tr('change_password') }}
  </div>
  <div class="panel-body">
    <div class="row no-margin">
      <div class="col-lg-12">
        @if (count($errors) > 0)
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form class="form-horizontal bordered-group" action="{{route('admin.profile.password.update')}}" method="POST">
          <div class="form-group">
            <label class="col-sm-2 control-label">{{ tr('old_password') }}</label>
            <div class="col-sm-10">
              <input type="password" name="old_password" class="form-control" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">{{ tr('password') }}</label>
            <div class="col-sm-10">
              <input type="password" name="password" class="form-control" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">{{ tr('confirm_password') }}</label>
            <div class="col-sm-10">
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
          </div>

          <div class="form-group">
            <label></label>
            <div class="col-md-4 col-md-offset-4">
              <button class="btn btn-primary btn-block">{{ tr('submit') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection