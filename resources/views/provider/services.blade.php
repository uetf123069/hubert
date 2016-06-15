@extends('layouts.provider')

@section('title', 'Services History | ')

@section('page_title', 'Services History')

@section('styles')
<link type="text/css" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/plugins/datatables/dataTables.fontAwesome.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2>{{ tr('your_history') }}</h2>
				<div class="panel-ctrls">
				</div>
			</div>
			<div class="panel-body panel-no-padding">
				<table id="history_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
					@if(!empty($requests))
					<thead>
						<tr>
							<th>{{ tr('request') }} #ID</th>
							<th>{{ tr('user_name') }}</th>
							<th>{{ tr('base_price') }}</th>
							<th>{{ tr('tax_price') }}</th>
							<th>{{ tr('total') }}</th>
							<th>{{ tr('address') }}</th>
							<th>{{ tr('service_type') }}</th>
							<th>{{ tr('started_on') }}</th>
							<th>{{ tr('ended_on') }}</th>
							<th>{{ tr('rating') }}</th>
							<th>{{ tr('review') }}</th>
						</tr>
					</thead>
					<tbody>
					
					@foreach($requests as $request)
						<tr>
							<td># {{$request->id}}</td>
							<td>{{ $request->user_name }}</td>
							<?php $payment = get_payment_details($request->id); ?>
							<td>{{$payment->base_price}}</td>
							<td>{{$payment->tax_price}}</td>
							<td>{{$payment->total ? $payment->total : 0 }}</td>
							<?php $request_details = get_request_details($request->id); ?>
							<td>{{$request_details->s_address}}</td>
							<td>{{get_service_name($request->request_type)}}</td>
							<td class="center">{{date('H:i - d M, Y',strtotime($request_details->start_time))}}</td>
							<td class="center">{{date('H:i - d M, Y',strtotime($request_details->end_time))}}</td>
							<td>{{ $request_details->UserRating->rating }}</td>
							<td>{{ $request_details->UserRating->comment }}</td>
						</tr>
					@endforeach
					
					</tbody>
					@else
						<p>{{ tr('no_request') }}</p>

						
					@endif
				</table>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript">
	// -------------------------------
// Initialize Data Tables
// -------------------------------

$(document).ready(function() {
    $('#history_data').dataTable({
    	"language": {
    		"lengthMenu": "_MENU_"
    	},
    	"order": [[ 3, "desc" ]]
    });
    $('.dataTables_filter input').attr('placeholder','Search...');


    //DOM Manipulation to move datatable elements integrate to panel
	$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
	$('.panel-ctrls').append("<i class='separator'></i>");
	$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");

	$('.panel-footer').append($(".dataTable+.row"));
	$('.dataTables_paginate>ul.pagination').addClass("pull-right m0");

});
</script>
@endsection
