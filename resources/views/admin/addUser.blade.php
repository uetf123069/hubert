@extends('layouts.admin')

          @if(isset($name))
            @section('title', 'Edit Users | ')
          @else
            @section('title', 'Add Users | ')
          @endif

@section('content')

@include('notification.notify')
        <div class="panel mb25">
          <div class="panel-heading border">
          @if(isset($name))
          Edit User
          @else
            Create New User
          @endif
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" action="{{route('admin.addUserProcess')}}" method="POST" enctype="multipart/form-data" role="form">
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
                  
                  <input type="hidden" name="id" value="@if(isset($user)) {{$user->id}} @endif" />
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>

                    <div class="col-sm-10">
                      <div class="radio">
                        <label>
                          <input name="gender" @if(isset($user)) @if($user->gender == 'male') checked @endif @endif value="male" type="radio">Male</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio"@if(isset($user)) @if($user->gender == 'female') checked @endif @endif name="gender" value="female">Female</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio"@if(isset($user)) @if($user->gender == 'others') checked @endif @endif name="gender" value="others">Others</label>
                      </div>
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
                      <input type="number" name="mobile"  value="{{ isset($user->mobile) ? $user->mobile : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                      <textarea name="address" required class="form-control" rows="3">{{ isset($user->address) ? $user->address : '' }}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Profile Picture</label>
                    <div class="col-sm-10">
                    @if(isset($user->picture))
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$user->picture}}">
                    @endif
                      <input name="picture" type="file">
                      <p class="help-block">Upload only .png, .jpg or .jpeg image files only</p>
                    </div>
                  </div>

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">Submit</button>
                    
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection