
@extends('layouts.user')

@section('title', 'Profile | ')

@section('page_title', 'Profile')

@section('page_tabs')
<div class="page-tabs">
    <ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#tab1">{{ tr('account_details') }}</a></li>
		<li><a data-toggle="tab" href="#tab2">{{ tr('password') }}</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default" data-widget='{"draggable": "false"}'>
						<div class="panel-heading">
							<h2>{{ tr('update_profile') }}</h2>
							<div class="panel-ctrls"
								data-actions-container="" 
								data-action-collapse='{"target": ".panel-body"}'
								data-action-expand=''
								data-action-colorpicker=''>
							</div>
						</div>
						<div class="panel-body">
							<form action="{{ route('user.profile.save') }}" method="POST" class="form-horizontal row-border" enctype="multipart/form-data">

		                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('first_name') }}</label>

		                            <div class="col-md-8">
		                                <input type="text" class="form-control" name="first_name" value="{{ Auth::user()->first_name }}">

		                                @if ($errors->has('first_name'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('first_name') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

		                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('last_name') }}</label>

		                            <div class="col-md-8">
		                                <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}">

		                                @if ($errors->has('last_name'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('last_name') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

		                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('email') }}</label>

		                            <div class="col-md-8">
		                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" readonly="true">

		                                @if ($errors->has('email'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('email') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
									
								<div class="form-group">
									<label class="col-sm-2 control-label">{{ tr('gender') }}</label>
									<div class="col-sm-8">
										<label class="radio-inline icheck">
											<input type="radio" value="male" name="gender" @if(Auth::user()->gender == 'male')checked="true"@endif>
											Male
										</label>
										<label class="radio-inline icheck">
											<input type="radio" value="female" name="gender" @if(Auth::user()->gender == 'female')checked="true"@endif> Female
										</label>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">{{ tr('profile_pic') }}</label>
									<div class="col-sm-5">
										<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
											<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;">
												@if(Auth::user()->picture != "")
													<img src="{{ Auth::user()->picture }}"></img>
												@endif
											</div>
											<div>
												<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ tr('remove') }}</a>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">{{ tr('select_image') }}</span>
													<span class="fileinput-exists">{{ tr('change') }}</span>
													<input type="file" name="picture">
												</span>
												
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="alert alert-info">{{ tr('img_upload') }}</div>
									</div>
								</div>

		                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('phone') }}</label>

		                            <div class="col-md-8">
		                                <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}">

		                                @if ($errors->has('mobile'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('mobile') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-4">
											<button class="btn-primary btn">{{ tr('submit')}}</button>
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
					<div class="panel panel-default" data-widget='{"draggable": "false"}'>
						<div class="panel-heading">
							<h2>{{ tr('change_password') }}</h2>
							<div class="panel-ctrls"
								data-actions-container="" 
								data-action-collapse='{"target": ".panel-body"}'
								data-action-expand=''
								data-action-colorpicker=''>
							</div>
						</div>
						<div class="panel-body">
							<form action="{{ route('user.profile.password') }}" method="POST" class="form-horizontal row-border">

		                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('old_password') }}</label>

		                            <div class="col-md-8">
		                                <input type="password" class="form-control tooltips" name="old_password" data-trigger="hover" data-original-title="Enter your current password here.">

		                                @if ($errors->has('old_password'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('old_password') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

		                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('password') }}</label>

		                            <div class="col-md-8">
		                                <input type="password" class="form-control tooltips" name="password" data-trigger="hover" data-original-title="Enter new password here">

		                                @if ($errors->has('password'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('password') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

		                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
		                            <label class="col-md-2 control-label">{{ tr('confirm_password') }}</label>
		                            <div class="col-md-8">
		                                <input type="password" class="form-control tooltips" name="password_confirmation" data-trigger="hover" data-original-title="Confirm new password">

		                                @if ($errors->has('password_confirmation'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button class="btn-primary btn">{{ tr('submit') }}</button>
											<button class="btn-default btn">{{ tr('cancel') }}</button>
										</div>
									</div>
								</div>
							</form>
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
<script type="text/javascript" src="{{ asset('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>
@endsection