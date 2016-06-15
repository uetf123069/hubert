@extends('layouts.provider')

@section('title', 'Documents | ')

@section('page_title', 'Documents')

@section('content')

		<div class="container-fluid">
					<div class="panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-heading">
					<h2>{{ tr('documents') }}</h2>
						<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}" data-action-expand="" data-action-colorpicker="">
						</div>
				</div>
				<div class="panel-editbox" data-widget-controls=""></div>
				<div class="panel-body">
					<form action="{{route('provider.upload.documents')}}" method="POST" enctype="multipart/form-data" class="form-horizontal row-border">

					<?php $inc = 0; ?>
						@foreach($documents as $document)

							<?php $status = check_provider_document($document->id,Auth::guard('provider')->user()->id); $inc++; ?>

							@if($status['success'] == false)

							<div class="form-group">
								<label class="col-sm-2 control-label">{{ tr('upload') }} {{$document->name}}</label>
								<div class="col-sm-8">
									<div class="fileinput fileinput-new" data-provides="fileinput"><input type="hidden" value="" name="...">
										<div class="input-group">
											<div class="form-control uneditable-input" data-trigger="fileinput">
												<i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
											</div>
											<span class="input-group-btn">
												<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ tr('remove') }}</a>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">{{ tr('select_file') }}</span>
													<span class="fileinput-exists">{{ tr('change') }}</span>
													<input type="file" name="document_{{$document->id}}" accept=".jpg,.png,.pdf">
												</span>
												
											</span>
										</div>
									</div>
								</div>
							</div>

							<hr>

							@else

							<div class="search-result">
                           		<h5>{{$document->name}} {{ tr('added') }}</h5><a href="{{$status['document_url']}}" target="_blank">{{ tr('view') }}</a> &nbsp; <a href="{{route('provider.delete.document',$document->id)}}">{{ tr('delete') }}</a>
                           		
                        	</div>

                        	<hr>

                        	@endif

                        	@endforeach

                        	@if($inc != 0)
							<div class="col-sm-8 col-sm-offset-2">
								<button type="submit" class="btn-primary btn">{{ tr('submit_documents') }}</button>
							</div>
							@else
								<div><strong style="text-align:center"> No Documents Types Found</strong></div>
							@endif

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