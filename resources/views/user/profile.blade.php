@extends('layouts.user')

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

@section('content')
<div class="container-fluid">
    <div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-success">
						<div class="panel-heading"><h2>Green Panels</h2></div>
						<div class="panel-body">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab2">
			<div class="row">
				<div class="col-md-12">
					<div data-widget-group="group1">
						<div class="panel panel-default" data-widget='{"draggable": "false"}'>
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
								<form action="{{ route('user.password') }}" method="POST" class="form-horizontal row-border">

			                        <div class="form-group{{ $errors->has('password_old') ? ' has-error' : '' }}">
			                            <label class="col-md-2 control-label">Old Password</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="password_old" data-trigger="hover" data-original-title="Enter your current password here.">

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
			                                <input type="password" class="form-control tooltips" name="password" data-trigger="hover" data-original-title="Enter new password here">

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
			                                <input type="password" class="form-control tooltips" name="password_confirmation" data-trigger="hover" data-original-title="Confirm new password">

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
@endsection