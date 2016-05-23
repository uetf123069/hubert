@extends('layouts.admin')

@section('title', 'Add Provider | ')

@section('content')
        <div class="panel mb25">
          <div class="panel-heading border">
            Create New Provider
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" role="form">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="first_name" value="{{ isset($provider->first_name) ? $provider->first_name : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="last_name" value="{{ isset($provider->last_name) ? $provider->last_name : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="gender">
                      <option value="{{ isset($provider->gender) ? $provider->gender : '' }}">value="{{ isset($provider->gender) ? $provider->gender : '' }}"</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="email" value="{{ isset($provider->email) ? $provider->email : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact Number </label>
                    <div class="col-sm-10">
                      <input type="number" name="contact" value="{{ isset($provider->mobile) ? $provider->mobile : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                      <textarea name="address" required class="form-control" rows="3">{{ isset($provider->address) ? $provider->address : '' }}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Zipcode</label>
                    <div class="col-sm-10">
                      <input type="number" name="zip" value="{{ isset($provider->zip) ? $provider->zip : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Paypal Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="paypal_email" value="{{ isset($provider->paypal_email) ? $provider->paypal_email : '' }}" required class="form-control">
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