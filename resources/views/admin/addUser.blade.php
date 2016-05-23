@extends('layouts.admin')

@section('title', 'Add Users | ')

@section('content')
        <div class="panel mb25">
          <div class="panel-heading border">
            Create New User
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" role="form">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="first_name" value="{{ isset($user->first_name) ? $user->first_name : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="last_name" value="{{ isset($user->last_name) ? $user->last_name : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="email" value="{{ isset($user->email) ? $user->email : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact Number </label>
                    <div class="col-sm-10">
                      <input type="number" name="contact" value="{{ isset($user->contact) ? $user->contact : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                      <textarea name="address" required class="form-control" rows="3">{{ isset($user->address) ? $user->address : '' }}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Zipcode</label>
                    <div class="col-sm-10">
                      <input type="number" name="zip" value="{{ isset($user->zip) ? $user->zip : '' }}" required class="form-control">
                    </div>
                  </div>

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">Submit</button>
                    <button class="btn btn-default">Reset</button>
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection