@extends('layouts.provider')

@section('title', 'Dashboard | ')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
			<div class="col-md-3">
				<div class="amazo-tile tile-white">
					<div class="tile-heading">
						<div class="title">Overall Request Count</div>
					</div>
					<div class="tile-body">
						<div class="content">{{get_provider_requests(Auth::guard('provider')->user()->id)}}  <i style="float:right" class="fa fa-smile-o"></i>  </div>
					</div>
					<div class="tile-footer">
						<span class="info-text text-right">13.4% <i class="fa fa-level-up"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="amazo-tile tile-info" href="#"> 
					<div class="tile-heading">
				        <div class="title">Request Count on this month</div>
				    </div>
				    <div class="tile-body">

				        <div class="content">   {{get_provider_request_this_month(Auth::guard('provider')->user()->id)}}  <i style="float:right" class="fa fa-check"></i> </div>
				    </div>
				    <div class="tile-footer">
				    	<span class="info-text text-right">82%</span>
				    </div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="amazo-tile tile-white">
					<div class="tile-heading">
						<div class="title">Completed Request</div>
					</div>
					<div class="tile-body">
						<span class="content">{{get_provider_completed_request(Auth::guard('provider')->user()->id)}}  <i style="float:right" class="fa fa-certificate"></i> </span>
					</div>
					<div class="tile-footer text-center">
						<span class="info-text text-right" style="color: #f04743">13.4% <i class="fa fa-level-down"></i></span>
					</div>
				</div>
			</div>
			

			
			<div class="col-md-3">
				<div class="amazo-tile tile-success">
					<div class="tile-heading">
						<span class="title">Provider Since</span>
					</div>
					<div class="tile-body">
						<span class="content">{{date('d M, Y',strtotime(Auth::guard('provider')->user()->created_at))}} <i style="float:right" class="fa fa-calendar"></i></span>
					</div>
					<div class="tile-footer">
						<span class="info-text text-right" style="color: #94c355">9.2% <i class="fa fa-level-up"></i></span>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
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