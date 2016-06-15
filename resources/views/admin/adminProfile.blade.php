@extends('layouts.admin')

@section('title', 'Admin Profile | ')


@section('content')

@include('notification.notify')
        <div class="panel mb25">
          <div class="panel-heading border">
         {{ tr('admin_profile') }}
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" action="{{route('adminProfileProcess')}}" method="POST" enctype="multipart/form-data" role="form">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('name') }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="name" value="{{ isset($admin->name) ? $admin->name : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('paypal_email') }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="paypal_email" value="{{ isset($admin->paypal_email) ? $admin->paypal_email : '' }}" required class="form-control">
                    </div>
                  </div>
                  
                  <input type="hidden" name="id" value="@if(isset($admin)) {{$admin->id}} @endif" />
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('gender') }}</label>

                    <div class="col-sm-10">
                      <div class="radio">
                        <label>
                          <input name="gender" @if(isset($admin)) @if($admin->gender == 'male') checked @endif @endif value="male" type="radio">{{ tr('male') }}</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio"@if(isset($admin)) @if($admin->gender == 'female') checked @endif @endif name="gender" value="female">{{ tr('female') }}</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio"@if(isset($admin)) @if($admin->gender == 'others') checked @endif @endif name="gender" value="others">{{ tr('others') }}</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('email') }}</label>
                    <div class="col-sm-10">
                      <input type="email" name="email" value="{{ isset($admin->email) ? $admin->email : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('contact_num') }} </label>
                    <div class="col-sm-10">
                      <input type="number" name="mobile"  value="{{ isset($admin->mobile) ? $admin->mobile : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('address') }}</label>
                    <div class="col-sm-10">
                      <textarea name="address" required class="form-control" rows="3">{{ isset($admin->address) ? $admin->address : '' }}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('profile_pic') }}</label>
                    <div class="col-sm-10">
                    @if(isset($admin->picture))
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$admin->picture}}">
                    @else
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"  src="{{asset('logo.png')}}">
                    @endif
                      <input name="picture" type="file">
                      <p class="help-block">{{ tr('upload_message') }}</p>
                    </div>
                  </div>

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">{{ tr('submit') }}</button>
                    
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection