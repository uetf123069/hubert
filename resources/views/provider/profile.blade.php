@extends('layouts.provider')

@section('title', 'Profile | ')

@section('page_title', 'Profile')

@section('page_tabs')
<div class="page-tabs">
    <ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#tab1">Account Details</a></li>
		<li><a data-toggle="tab" href="#tab2">Password</a></li>
    </ul>
</div>
@endsection

@section('styles')

	<script type="text/javascript" src="{{ asset('assets/user/css/styles-blessed1.css') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/user/css/styles-blessed2.css') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/user/css/styles-blessed3.css') }}"></script>

@endsection

@section('content')
<div class="container-fluid">
    <div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading"><h2>Profile Update</h2></div>
						<div class="panel-body">
							<form action="" class="form-horizontal row-border">

									<div class="form-group pb10">
										<label class="col-sm-2 control-label">Availability</label>
										<div class="col-sm-8">
											<ul class="demo-btns mb-10">
												<li><div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-animate"><div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-success">ON</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input class="bootstrap-switch switch-alt" type="checkbox" checked="false" data-on-color="success" data-off-color="default"></div></div></li>
											</ul>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">First Name</label>
										<div class="col-sm-8">
											<input type="text" name="first_name" class="form-control tooltips"  data-trigger="hover" data-original-title="Update your First name." >
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Last Name</label>
										<div class="col-sm-8">
											<input type="text" name="last_name" class="form-control tooltips"  data-trigger="hover" data-original-title="Update your Last name.">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Gender</label>
										<div class="col-sm-8">
											<label class="radio-inline icheck">
												<div class="iradio_minimal-blue checked" style="position: relative;"><input type="radio" id="inlineradio1" value="male" name="gender" checked="true" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> Male
											</label>
											<label class="radio-inline icheck">
												<div class="iradio_minimal-blue" style="position: relative;"><input type="radio" id="inlineradio2" value="female" name="gender" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> Female
											</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Profile Image</label>
										<div class="col-sm-5">
											<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
												<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;"></div>
												<div>
													<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
													<span class="btn btn-default btn-file"><span class="fileinput-new">Select Profile Image</span><span class="fileinput-exists">Change</span><input type="file" name="profile_image"></span>
													
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Phone</label>
										<div class="col-sm-8">
											<input type="text" name="phone" class="form-control tooltips"  data-trigger="hover" data-original-title="Update your Phone number.">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Bio</label>
										<div class="col-sm-8">
											<textarea class="form-control tooltips" data-trigger="hover" data-original-title="Update your Bio." name="bio"></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Address</label>
										<div class="col-sm-8">
											<textarea class="form-control tooltips" data-trigger="hover" data-original-title="Update your Address." name="address"></textarea>
										</div>
									</div>

									<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button class="btn-primary btn">Submit</button>
											<button class="btn-default btn">Cancel</button>
										</div>
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab2">
			<div class="row">
				<div class="col-md-12">
					<div data-widget-group="group1">
						<div class="panel panel-info" data-widget='{"draggable": "false"}'>
							<div class="panel-heading">
								<h2>Change Password</h2>
								<div class="panel-ctrls"
									data-actions-container="" 
									data-action-collapse='{"target": ".panel-body"}'
									data-action-expand=''
									data-action-colorpicker=''>
								</div>
							</div>
							<div class="panel-editbox" data-widget-controls=""></div>
							<div class="panel-body">
								<form action="{{ route('provider.password') }}" method="POST" class="form-horizontal row-border">

			                        <div class="form-group{{ $errors->has('password_old') ? ' has-error' : '' }}">
			                            <label class="col-md-2 control-label">Old Password</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="password_old" data-trigger="hover" data-original-title="Enter your current password">

			                                @if ($errors->has('password_old'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password_old') }}</strong>
			                                    </span>
			                                @endif
			                            </div>
			                        </div>

			                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			                            <label class="col-md-2 control-label">Password</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="password" data-trigger="hover" data-original-title="Enter new password">

			                                @if ($errors->has('password'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password') }}</strong>
			                                    </span>
			                                @endif
			                            </div>
			                        </div>

			                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
			                            <label class="col-md-2 control-label">Confirm Password</label>
			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="password_confirmation" data-trigger="hover" data-original-title="Enter your Confirm password">

			                                @if ($errors->has('password_confirmation'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
			                                    </span>
			                                @endif
			                            </div>
			                        </div>

								</form>
								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button class="btn-primary btn">Submit</button>
											<button class="btn-default btn">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- .container-fluid -->

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/fileinput.js') }}"></script>
@endsection