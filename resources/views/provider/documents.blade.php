@extends('layouts.provider')

@section('title', 'Documents | ')

@section('page_title', 'Documents')

@section('content')

		<div class="container-fluid">
					<div class="panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-heading">
					<h2>Documents</h2>
						<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}" data-action-expand="" data-action-colorpicker="">
						<span class="button-icon has-bg"><i class="fa fa-minus"></i></span><span class="button-icon has-bg"><i class="fa fa-expand"></i></span><span class="button-icon"><i class="fa fa-tint"></i></span></div>
				</div>
				<div class="panel-editbox" data-widget-controls=""></div>
				<div class="panel-body">
					<form action="" class="form-horizontal row-border">

							<div class="form-group">
								<label class="col-sm-2 control-label">Upload Document</label>
								<div class="col-sm-8">
									<div class="fileinput fileinput-new" data-provides="fileinput"><input type="hidden" value="" name="...">
										<div class="input-group">
											<div class="form-control uneditable-input" data-trigger="fileinput">
												<i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
											</div>
											<span class="input-group-btn">
												<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">Select file</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="" accept=".jpg,.png,.pdf">
												</span>
												
											</span>
										</div>
									</div>
								</div>
							</div>

							<hr>
							<h4>Uploaded Documents</h4>
							<hr>
							<div class="search-result">
                           		<h5>Driving Licence Added</h5><a href="#">Delete</a>
                           		
                        	</div>

                        	<hr>


					</form>
				</div>
			</div>


		</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/fileinput.js') }}"></script>

@endsection

@section('unusedscripts')

<!-- Load page level scripts-->

<script type="text/javascript" src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>                  <!-- FullCalendar -->
<script type="text/javascript" src="{{ asset('assets/plugins/wijets/wijets.js') }}"></script>                                  <!-- Wijet -->
<script type="text/javascript" src="{{ asset('assets/plugins/charts-chartistjs/chartist.min.js') }}"></script>                 <!-- Chartist -->
<script type="text/javascript" src="{{ asset('assets/plugins/charts-chartistjs/chartist-plugin-tooltip.js') }}"></script>      <!-- Chartist -->
<script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/moment.min.js') }}"></script>                <!-- Moment.js for Date Range -->
<script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/daterangepicker.js') }}"></script>           <!-- Date Range Picker -->

<!-- End loading page level scripts-->

@endsection